<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\DetailsMail;
use DateTime;
use DateTimeZone;
use Exception;
use stdClass;
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

        $allowedStatus = ['pending_payment', 'approved', 'rescheduled'];

        $today = Carbon::now()->toDateString();
        $appointment = Appointment::with('status')->whereDate('date', ">=", $today)->get()->toArray();
        return response()->json(reFormatDates($appointment, $allowedStatus));
    }

    public function getSettings () {
        return response()->json(Setting::getFormattedSettings());
    }

    public function manageAppointment (Request $request) {
        $settings = Setting::getFormattedSettings();
        $timeZone = $settings['timezone'];
        $limit = $settings['edit_duration'];
        function isItEditable($dateTime, $limit, $timeZone)
        {
            $dateTime = new DateTime($dateTime, new DateTimeZone($timeZone));
            $today = new DateTime('now', new DateTimeZone($timeZone));
            if ($dateTime < $today) {
                return 'pastDay';
            }
            $interval = $dateTime->diff($today);
            $hours = $interval->h + $interval->days * 24;
            return $hours > $limit;
        }

        $request->validate([
            "email" => "required|email",
            "verifyCode" => "required|min:6|max:6"
        ]);
        $appointment = Appointment::where("email", $request->email)->where("verifyCode", $request->verifyCode)->with('status')->get()->toArray();
        $notFoundList = ['feedback_pending', 'cancelled', 'completed'];
        if (count($appointment)) {
            $status = $appointment[0]["status"]['name'];
            if (in_array($status, $notFoundList)) {
                return response()->json("not_found");
            }
            if ($status === 'awaiting_refund') {
                return response()->json([
                    "name" => $status,
                    "message" => "Geri ödeme talebiniz bize ulaştı. İşlemleriniz en kısa sürede yapılacaktır."
                ]);
            }
            if ($status === 'no_participation') {
                return response()->json([
                    "name" => $status,
                    "message" => "Belirtilen tarih ve saatte randevuya katılım yapılmadığı için randevunuz iptal edilmiştir."
                ]);
            }
            if ($status === 'no_payment') {
                return response()->json([
                    "name" => $status,
                    "message" => "Belirtilen süre içerisinde ödeme yapılmadığı için randevunuz iptal edildi."
                ]);
            }
            $date = $appointment[0]['date'];
            $time = $appointment[0]['time'];
            if (isItEditable($date . " " . $time . ":00", $limit, $timeZone) === 'pastDay') {
                return response()->json("not_found");
            } else if (isItEditable($date . " " . $time . ":00", $limit, $timeZone) === true) {
                $fields = ["id", "name", "surname", "email", "verifyCode", "phone", "gender", "age", "date", "time", 'status'];
                $responseFields = collect($appointment[0])->only($fields)->toArray();
                $responseFields['status'] = $responseFields['status']['name'];
                return response()->json($responseFields);
            } else {
                return response()->json([
                    "message" => "Özür dileriz, ancak randevu şartları çerçevesinde, randevu saatine " . $limit . " saat kala herhangi bir değişiklik yapılamamaktadır."
                ]);
            }
        } else {
            return response()->json("not_found");
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
        } catch (Exception $e) {
            return response()->json([
                "message" => "bir sorun olustu => {$e}"
            ], 404);
        }
        return response()->json([
            "email" => $appointment->email,
            "date" => $appointment->date,
            "price" => $priceText,
            "time" => $appointment->time,
            "verifyCode" => $appointment->verifyCode
        ]);
    }
}
