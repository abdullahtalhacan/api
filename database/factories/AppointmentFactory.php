<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AppointmentStatus;
use App\Models\PaymentStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{

    function generateRandomCode()
    {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randomLetter = implode('', array_map(function () use ($characters) {
            return $characters[rand(0, strlen($characters) - 1)];
        }, range(1, 3)));

        return $randomLetter . (rand(100, 999));
    }

    function generateRandomDate($startDate, $endDate)
    {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);

        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);

        return date("Y-m-d", $randomTimestamp);
    }

    function generateRandomTime($startTime, $endTime)
    {
        $startHour = (int)explode(":", $startTime)[0];
        $endHour = (int)explode(":", $endTime)[0];

        $randomHour = mt_rand($startHour, $endHour);

        return str_pad($randomHour, 2, "0", STR_PAD_LEFT) . ":00";
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = \Faker\Factory::create('tr_TR');

        $startDate = '2024-04-01';
        $endDate = '2024-06-20';

        $startTime = '09:00';
        $endTime = '15:00';

        $dataArray = [];
        $emailArray = [];
        for ($i = 0; $i < 300; $i++) {
            $randomDate = $this->generateRandomDate($startDate, $endDate);

            $attempt = 0;
            do {
                $randomTime = $this->generateRandomTime($startTime, $endTime);
                $isDuplicate = false;

                foreach ($dataArray as $existingData) {
                    if ($existingData['date'] == $randomDate && $existingData['time'] == $randomTime) {
                        $isDuplicate = true;
                        break;
                    }
                }
                $attempt++;

                if ($attempt > 100) {
                    $randomDate = $this->generateRandomDate($startDate, $endDate);
                    $attempt = 0;
                }
            } while ($isDuplicate);

            $dataArray[] = [
                "date" => $randomDate,
                "time" => $randomTime
            ];
        }

        for ($i=0; $i < 60; $i++) {
            array_push($emailArray, $faker->unique()->safeEmail());
        }

        $uniqueIndex = $faker->unique()->numberBetween(0, 280);
        $statusId = AppointmentStatus::inRandomOrder()->pluck('id')->first();
        $payment = PaymentStatus::inRandomOrder()->pluck('id')->first();

        return [
            'date' => $dataArray[$uniqueIndex]['date'],
            'time' => $dataArray[$uniqueIndex]['time'],
            'case_formulation' => $faker->paragraph(8),
            'diagnosis' => $faker->text(100),
            'notes' => $faker->text(350),
            'verifyCode' => $this->generateRandomCode(),
            'appointment_status_id' => $statusId,
            'payment_status_id' => $payment
        ];
    }
}
