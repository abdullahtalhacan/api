<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Feedback;
use App\Models\PaymentStatus;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'pending', 'text' => 'Yeni Randevu', 'desc' => 'Katılımcı yeni randevu girişi yaptı. Ödeme bekleniyor.'],
            ['name' => 'approved', 'text' => 'Onaylandı', 'desc' => 'Tüm koşullar yerine getirildi. Randevu saati bekleniyor.'],
            ['name' => 'rescheduled', 'text' => 'Yeniden Planlandı', 'desc' => 'Randevu saati veya tarihi değiştirildi.'],
            ['name' => 'completed', 'text' => 'Tamamlandı', 'desc' => 'Randevu başarıyla sonuçlandırıldı.'],
            ['name' => 'cancelled', 'text' => 'İptal Edildi', 'desc' => 'Katılımcı tarafından iptal edilen veya zamanında ücreti ödenmeyen randevu.'],
            ['name' => 'no_participation', 'text' => 'Katılım Yok', 'desc' => 'Randevu saatinde katılımcı gelmedi.'],
            ['name' => 'feedback_pending', 'text' => 'Yorum Bekleniyor', 'desc' => 'Katılımcının randevu sonrasında değerlendirme formunu doldurması beklenmektedir.'],
        ];

        $payment_status = [
            ['name' => 'pending', 'text' => 'Ödeme Bekleniyor', 'desc' => 'Randevu sonuçlandırıldı ve ödeme bekleniyor.'],
            ['name' => 'approved', 'text' => 'Ödeme Yapıldı', 'desc' => 'Katılımcı Ödemeyi yaptı'],
            ['name' => 'no_payment', 'text' => 'Ödeme Yapılmadı', 'desc' => 'Katılımcı belirtilen süre içinde ödeme yapmadı.'],
            ['name' => 'awaiting_refund', 'text' => 'İade Bekleniyor', 'desc' => 'Katılımcı belirtilen koşullar altında randevusunu iptal etti.'],
        ];

        AppointmentStatus::insert($statuses);
        PaymentStatus::insert($payment_status);

        $numAppointments = 280;
        $faker = \Faker\Factory::create('tr_TR');
        $dataArray = [];
        for ($i = 0; $i < 60; $i++) {
            array_push($dataArray, [
                'name' => $faker->firstName(),
                'surname' => $faker->lastName(),
                'phone' => $faker->phoneNumber(),
                'gender' => $faker->randomElement(['male', 'female']),
                'age' => $faker->numberBetween(10, 65),
                "email" => $faker->unique()->safeEmail(),

            ]);
        }
        // Loop to create appointments with associated feedback
        for ($i = 0; $i < $numAppointments; $i++) {
            // Create a feedback for every nth appointment (adjust as needed)
            $hasFeedback = $i % 5 === 0;

            // Create an appointment
            $randomIndex = $faker->numberBetween(0,59);
            $appointment = Appointment::factory()->create([
                'name' => $dataArray[$randomIndex]['name'],
                'surname' => $dataArray[$randomIndex]['surname'],
                'phone' => $dataArray[$randomIndex]['phone'],
                'gender' => $dataArray[$randomIndex]['gender'],
                'age' => $dataArray[$randomIndex]['age'],
                'email' => $dataArray[$randomIndex]['email'],
                'feedback_id' => $hasFeedback ? Feedback::factory()->create()->id : null,
            ]);

            // Output the created appointment ID for reference
            $this->command->info("Appointment ID {$appointment->id} created.");

            // If you want to do something with the created appointment, you can use $appointment here
        }
        //Appointment::factory(280)->create(); // */

    }
}
