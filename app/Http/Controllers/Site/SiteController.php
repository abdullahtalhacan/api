<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Http\Request;


use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Mail\DetailsMail;
use App\Models\Feedback;
use App\Models\PaymentStatus;
use DateTime;
use DateTimeZone;
use Exception;
use Closure;

class SiteController extends Controller
{
    public function appointmentList () {
        function reFormatDates(array $data, array $status): array
        {
            $formattedData = [];

            foreach ($data as $item) {
                if(in_array($item['status']['name'] ,$status)){
                    $date = new DateTime($item["date"]);
                    $monthNumber = $date->format("n");
                    $dayNumber = $date->format("j");

                    if (!isset($formattedData[$monthNumber][$dayNumber])) {
                        $formattedData[$monthNumber][$dayNumber] = [];
                    }
                    $formattedData[$monthNumber][$dayNumber][] = $item["time"];
                }
            }

            return $formattedData;
        }

        $allowedStatus = ['pending', 'approved', 'rescheduled'];

        $today = Carbon::now()->toDateString();
        $appointment = Appointment::with('status')->whereDate('date', ">=", $today)->get()->toArray();
        return response()->json(reFormatDates($appointment, $allowedStatus));
    }

    public function getSettings () {
        return response()->json(Setting::getFormattedSettings());
    }

    public function manageAppointment (Request $request) {
        $settings = Setting::getFormattedSettings();
        $timezone = $settings['timezone'];
        $limit = $settings['edit_limit'];

        $request->validate([
            "email" => "required|email",
            "verifyCode" => "required|min:6|max:6"
        ]);
        try {
            $appointment = Appointment::where("email", $request->email)->where("verifyCode", $request->verifyCode)->with('status')->with('payment_status')->first();
            $canEditList = ['pending', 'approved', 'rescheduled'];
        if ($appointment) {
            $status = $appointment->status->name;
            $payment_status = $appointment->payment_status->name;

            if ($payment_status === 'awaiting_refund') {
                return response()->json([
                    "name" => $payment_status,
                    "message" => "Geri ödeme talebiniz bize ulaştı. İşlemleriniz en kısa sürede yapılacaktır."
                ]);
            }
            if ($status === 'no_participation') {
                return response()->json([
                    "name" => $status,
                    "message" => "Belirtilen tarih ve saatte randevuya katılım yapılmadığı için randevunuz iptal edilmiştir."
                ]);
            }
            if ($payment_status === 'no_payment') {
                return response()->json([
                    "name" => $payment_status,
                    "message" => "Belirtilen süre içerisinde ödeme yapılmadığı için randevunuz iptal edildi."
                ]);
            }
            if (!in_array($status, $canEditList)) {
                return response()->json("not_found");
            }

            $date = $appointment->date;
            $time = $appointment->time;
            $dateTime = $date . " " . $time . ":00";
            $canEdit = isItEditable($dateTime, $limit, $timezone['name']);

            $fields = ["id", "name", "surname", "email", "verifyCode", "phone", "gender", "age", "date", "time", 'status', 'payment_status'];
            $responseFields = collect($appointment)->only($fields)->toArray();
            $responseFields['status'] = [
                "name" => $responseFields['status']['name'],
                "text" => $responseFields['status']['text']
            ];
            $responseFields['payment_status'] = [
                "name" => $responseFields['payment_status']['name'],
                "text" => $responseFields['payment_status']['text']
            ];
            $responseFields['edit_limit'] = $limit;
            $responseFields['timezone'] = $timezone['text'];
            $responseFields['canEdit'] = $canEdit;
            return response()->json($responseFields);

        } else {
            return response()->json("not_found");
        }
        } catch (\Throwable $th) {
            return response()->json("error");
        }
    }

    function generateRandomCode()
    {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randomLetter = implode('', array_map(function () use ($characters) {
            return $characters[rand(0, strlen($characters) - 1)];
        }, range(1, 3)));

        return $randomLetter . (rand(100, 999));
    }

    public function storeAppointment (Request $request) {
        $settings = Setting::getFormattedSettings();
        $ageRange = $settings['age_range'];
        $price = $settings['price'];
        $contact_email = $settings['contact_email'];

        $request->validate([
            "name" => "required|string|min:3|max:255",
            "surname" => "required|string|min:3|max:255",
            "email" => "required|string|email",
            "phone" => "required|string",
            "gender" => [
                "required",
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!($value === "male" || $value === "female"))
                        $fail("Yalnızca erkek veya kadın cinsiyeti seçilebilir");
                }
            ],
            "age" => [
                "required",
                function (string $attribute, mixed $value, Closure $fail) use ($ageRange) {
                    if ($value !== "{$ageRange['max']}+") {
                        $intValue = intval($value);
                        if (!($intValue >= $ageRange['min'] && $intValue <= $ageRange['max'])) {
                            $fail("Seçilen yaş {$ageRange['min']} ile {$ageRange['max']} aralığında değil.");
                        }
                    }
                }
            ],
            "date" => "required|string",
            "time" => "required|string",
            "terms" => "required|accepted",
            "agreement" => "required|accepted"
        ]);
        try {
            $date = DateTime::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $randomCode = $this->generateRandomCode();
            if (isset($request->id)) {
                $appointmentStatus = AppointmentStatus::select('id')->where('name', 'rescheduled')->first();
                $appointment = Appointment::find($request->id);
                $appointment->name = $request->name;
                $appointment->surname = $request->surname;
                $appointment->email = $request->email;
                $appointment->phone = $request->phone;
                $appointment->gender = $request->gender;
                $appointment->age = $request->age;
                $appointment->date = $date;
                $appointment->time = $request->time;
                $appointment->appointment_status_id = $appointmentStatus->id;
                $appointment->save();
                $randomCode = $appointment->verifyCode;
            } else {
                $appointment = Appointment::create([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'age' => $request->age,
                    'date' => $date,
                    'time' => $request->time,
                    'verifyCode' => $randomCode,
                ]);
            }
            setlocale(LC_TIME, 'tr_TR');
            $dateArray = array(
                'Monday' => 'Pazartesi',
                'Tuesday' => 'Salı',
                'Wednesday' => 'Çarşamba',
                'Thursday' => 'Perşembe',
                'Friday' => 'Cuma',
                'Saturday' => 'Cumartesi',
                'Sunday' => 'Pazar',
                'January' => 'Ocak',
                'February' => 'Şubat',
                'March' => 'Mart',
                'April' => 'Nisan',
                'May' => 'Mayıs',
                'June' => 'Haziran',
                'July' => 'Temmuz',
                'August' => 'Ağustos',
                'September' => 'Eylül',
                'October' => 'Ekim',
                'November' => 'Kasım',
                'December' => 'Aralık',
                'Mon' => 'Pts',
                'Tue' => 'Sal',
                'Wed' => 'Çar',
                'Thu' => 'Per',
                'Fri' => 'Cum',
                'Sat' => 'Cts',
                'Sun' => 'Paz',
                'Jan' => 'Oca',
                'Feb' => 'Şub',
                'Mar' => 'Mar',
                'Apr' => 'Nis',
                'Jun' => 'Haz',
                'Jul' => 'Tem',
                'Aug' => 'Ağu',
                'Sep' => 'Eyl',
                'Oct' => 'Eki',
                'Nov' => 'Kas',
                'Dec' => 'Ara',
            );
            $dateString = $date;
            $date = new DateTime($dateString);
            $day = $date->format("d");
            $dayName = $date->format('l');
            $monthName = $date->format('F');
            $year = $date->format('Y');
            $dateText = $day . " " . $dateArray[$monthName] . " " . $year . " " . $dateArray[$dayName];
            $priceText = $price['price'] . " " . $price['currency'];
            $fields = [
                "name" => $request->name . " " . $request->surname,
                "date" => $dateText,
                "price" => $priceText,
                "time" => $request->time,
                "verifyCode" => $randomCode,
                "contact_email" => $contact_email,
                "site_url" => config("app.frontend_url")
            ];
            Mail::to($appointment->email)->send(new DetailsMail($fields));
            return response()->json([
                "email" => $appointment->email,
                "date" => $appointment->date,
                "price" => $priceText,
                "time" => $appointment->time,
                "verifyCode" => $appointment->verifyCode
            ]);
        } catch (Exception $e) {
            return response()->json('error');
        }

    }

    public function cancelAppointment(Request $request) {
        $request->validate([
            "email" => "required|email",
            "verifyCode" => "required|min:6|max:6"
        ]);
        try {
            $approvedStatus = PaymentStatus::select('id')->where('name', 'approved')->first();
            $appointment = Appointment::where("email", $request->email)->where("verifyCode", $request->verifyCode)->with('status')->with('payment_status')->first();
            if($approvedStatus->id == $appointment->payment_status_id){

                $settings = Setting::getFormattedSettings();
                $dateTime = $appointment->date . " " . $appointment->time . ":00";
                $isRefundable = isItEditable($dateTime, $settings['edit_limit'], $settings['timezone']['name']);
                if($isRefundable){
                    $refundStatus = PaymentStatus::select('id')->where('name', 'awaiting_refund')->first();
                    $cancelledStatus = AppointmentStatus::select('id')->where('name', 'cancelled')->first();
                    $appointment->appointment_status_id = $cancelledStatus->id;
                    $appointment->payment_status_id = $refundStatus->id;
                    $appointment->save();
                    return response()->json('ok');
                }else {
                    $cancelledStatus = AppointmentStatus::select('id')->where('name', 'cancelled')->first();
                    $appointment->appointment_status_id = $cancelledStatus->id;
                    $appointment->save();
                    return response()->json('ok');
                }
            }else {
                $cancelledStatus = AppointmentStatus::select('id')->where('name', 'cancelled')->first();
                $appointment->appointment_status_id = $cancelledStatus->id;
                $appointment->save();
                return response()->json('ok');
            }
        } catch (\Throwable $th) {
            return response()->json('error'. $th);
        }
    }

    public function contactForm(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string'
        ]);
        try {
            $contactMail = Setting::select('value')->where('name', 'contact_email')->first();
            Mail::to($contactMail->value)->send(new ContactMail($request->all()));
            return response()->json('ok');
        } catch (Exception $e) {
            return response()->json('error');
        }
    }

    public function getTerms(Request $request) {
        $request->validate([
            'id' => 'required|string'
        ]);

        $fieldName = '';
        if($request->id === 'kvkk'){
            $fieldName = 'kvkk';
        }
        if($request->id === 'kullanici-sozlesmesi'){
            $fieldName = 'user_agreement';
        }
        if($request->id === 'intihar-sozlesmesi'){
            $fieldName = 'suicide_contract';
        }

        try {
            $terms = Setting::where('name', $fieldName)->first();
            if($terms){
                return response()->json($terms['value']);
            }else {
                return response()->json('error1');
            }

        } catch (\Throwable $th) {
            return response()->json('error2');
        }
    }

    public function checkFeedback(Request $request) {
        $request->validate([
            'id' => 'required|string'
        ]);
        try {
            $feedback = Feedback::where('uuid', $request->id)->first();
            if($feedback){
                $fields = ['feedback_max_score', 'feedback_text_length'];
                $settings = Setting::select('name', 'value')->whereIn('name', $fields)->get();
                return response()->json($settings);
            }else {
                return response()->json('not_found');
            }
        } catch (\Throwable $th) {
            return response()->json('error');
        }
    }

    public function getFeedbacks() {
        $feedbacks = Feedback::with('appointment')->offset(10)
        ->limit(30)
        ->get();//where isActive true
        $fields = [];
        foreach ($feedbacks as $feedback) {
            $surname = $feedback["appointment"]["surname"];
            $surname = mb_substr($surname, 0, 1);
            $name = $feedback["is_anonymous"] ? false : $feedback["appointment"]["name"] . " " . $surname . ".";
            $fields[] = [
                "score" => $feedback["score"],
                "comment" => $feedback["comment"],
                "name" => $name,

            ];
        }
        return response()->json($fields);
    }

    public function storeFeedback(Request $request) {
        try {
            $settings  = Setting::getFormattedSettings();
            $request->validate([
                'score' => ['required', 'min:1', Rule::max($settings['feedback_max_score'])],
                'comment' => ['required', 'min:3', Rule::max($settings['feedback_text_length'])],
                'is_anonymous' => "required|boolean"
            ]);

        } catch (\Throwable $th) {
           return response()->json('error');
        }

    }
}
