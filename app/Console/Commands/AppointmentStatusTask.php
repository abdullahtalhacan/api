<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\PaymentStatus;
use App\Models\Setting;
use Illuminate\Console\Command;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;

class AppointmentStatusTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:appointment-status-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = Setting::getFormattedSettings();
        $timezone = $settings['timezone']['name'];
        $limit = $settings['edit_limit'];
        $today = now($timezone)->toDateString();
        $appointmentStatus = AppointmentStatus::select('id')->where('name', 'cancelled')->first();
        $noPaymentStatus = PaymentStatus::select('id')->where('name', 'no_payment')->first();
        $willUpdateFields = ['pending', 'approved', 'rescheduled'];
        $statusIds = [];
        foreach($willUpdateFields as $key => $filed){
            $this->info($filed);
            $status = AppointmentStatus::select('id')->where('name', $filed)->first();
            $statusIds[$key] = $status->id;
        }

        /*
        $result = Appointment::whereDate('date', '<', $today)
        ->where(function ($query) use ($statusIds, $timezone) {
            $query->whereIn('appointment_status_id', $statusIds)
                ->whereTime('time', '<', now()->format('H:i'))
                ->orWhere('date', '<=', now($timezone)->toDateString());
        })
        ->orWhere(function ($query) use ($statusIds, $timezone) {
            $query->whereDate('date', '<=', now($timezone)->toDateString())
                ->whereIn('appointment_status_id', $statusIds);
        })
        ->update(['appointment_status_id' => $appointmentStatus->id]);
        */


        $payment_limit = 48;
        $noPayments = Appointment::where('payment_status_id', 1)
        ->whereIn('appointment_status_id', [1,3])
        ->where('date', '<', now($timezone)->subHours($payment_limit)->toDateString())
        ->orWhere(function ($query) use ($timezone, $payment_limit) {
            $query->where('date', now($timezone)->subHours($payment_limit)->toDateString())
                ->where('time', '<', now($timezone)->subHours($payment_limit)->toTimeString());
        })//48
        ->update(['appointment_status_id' => 6]);

        $this->info('noPayments => '. $noPayments);



        $currentDate = now($timezone)->toDateString();
        $currentTime = now($timezone)->subMinute(90)->toTimeString();
        $passAppointments = Appointment::whereIn('appointment_status_id', $statusIds)
        ->where(function ($query) use ($currentDate, $currentTime) {
            $query->where('date', '<', $currentDate)
                ->orWhere(function ($query) use ($currentDate, $currentTime) {
                    $query->where('date', $currentDate)
                        ->where('time', '<', $currentTime);
                });
        })
        ->update(['appointment_status_id' => $appointmentStatus->id]);

        $this->info('passAppointments => '. $passAppointments);
        /*$result = Appointment::whereDate('date', '<', $today)
        ->whereIn('appointment_status_id', $statusIds)->update(['appointment_status_id' => $appointmentStatus->id]);

        $result = Appointment::whereDate('date', '<', $today)
        ->where(function ($query) use ($statusIds, $timezone) {
            $query->whereIn('appointment_status_id', $statusIds)
                ->whereTime('time', '<', now()->subMinutes(90)->format('H:i:s'))
                ->orWhere('date', '<', now($timezone)->toDateString());
        })
        ->update(['appointment_status_id' => $appointmentStatus->id]);

        /*foreach ($appointments as $key => $appointment) {
            //$this->info($appointment->status['name']);
            $dateTime = $appointment->date . " " . $appointment->time . ":00";
            $isItPastDate = isItEditable($dateTime, $limit, $timezone);
            if(in_array($appointment->status['name'], $willUpdateFields)){
                $this->info($key . "=>" .$appointment->status['name']);
                $appointment->update(['appointment_status_id' => $appointmentStatus]);
                //$this->info($appointment->status['name']);
            }
        }*/
        //$this->info($today);
    }
}
