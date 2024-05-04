<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $settings = [
            [
                "name" => "appointment_status",
                "title" => "Randevu Durumu",
                "desc" => "Randevu sistemin açık veya kapalı olma durumunu düzenler.",
                "value" => json_encode(true),
                "options" => json_encode([]),
                "element" => "toggle",
                "category" => "Randevu",
            ],
            [
                "name" => "timezone",
                "title" => "Zaman Dilimi",
                "desc" => "Randevuların doğru planlanması ve görüntülenmesi için tercih ettiğiniz saat dilimini ayarlayın.",
                "value" => json_encode([
                    "name" => "Europe/Istanbul","text" => "Avrupa/İstanbul"
                ]),
                "options" => json_encode([
                    ["value" => "Europe/Istanbul", "option" => "Avrupa/İstanbul"],
                    ["value" => "Asia/Tbilisi", "option" => "Asya/Tiflis"],
                ]),
                "element" => "select",
                "category" => "Randevu",
            ],
            [
                "name" => "price",
                "title" => "Randevu Ücreti",
                "desc" => "",
                "value" => json_encode([
                    "price" => "300",
                    "currency" => "TL"
                ]),
                "options" => json_encode(['TL', 'USD', 'EURO']),
                "element" => "input:text:options",
                "category" => "Randevu",
            ],
            [
                "name" => "payment_duration",
                "title" => "Randevu Ücreti Ödeme Süresi",
                "desc" => "Randevu saatine kalan süre belirtilen süreden az ise randevu otomatik olarak iptal edilir.",
                "value" => json_encode("36"),
                "options" => json_encode("saat"),
                "element" => "input:text",
                "category" => "Randevu",
            ],
            [
                "name" => "edit_limit",
                "title" => "Randevu Düzenleme Süresi",
                "desc" => "Randevu saatine kalan süre belirtilen süreden fazla ise katılımcı düzenleme, iptal işlemleri yapabilir yada eğer ödeme yapmışsa para iadesi alabilir.",
                "value" => json_encode("48"),
                "options" => json_encode("saat"),
                "element" => "input:text",
                "category" => "Randevu",
            ],
            [
                "name" => "duration",
                "title" => "Randevu Süresi",
                "desc" => "Katılımcı ile yapılacak görüşmenin süresidir.",
                "value" => json_encode([
                    "min" => "45",
                    "max" => "60"
                ]),
                "options" => json_encode([]),
                "element" => "input:text:double",
                "category" => "Randevu",
            ],
            [
                "name" => "appointment_months",
                "title" => "Randevu Alınabilir Aylar",
                "desc" => "Bu ayar, mevcut ayı baz alarak seçilen ay sayısı kadar ileriye randevu alınabilmesini sağlar.",
                "value" => json_encode("3"),
                "options" => json_encode([
                    ["value" => "1", "option" => "1 ay"],
                    ["value" => "2", "option" => "2 ay"],
                    ["value" => "3", "option" => "3 ay"],
                    ["value" => "4", "option" => "4 ay"],
                    ["value" => "5", "option" => "5 ay"],
                    ["value" => "6", "option" => "6 ay"]
                ]),
                "element" => "select",
                "category" => "Randevu",
            ],
            [
                "name" => "blocked_days",
                "title" => "Pasif Randevu Günleri",
                "desc" => "Seçilen günler için randevu alımı engellenir.",
                "value" => json_encode([]),
                "options" => json_encode([]),
                "element" => "datepicker",
                "category" => "Randevu",
            ],
            [
                "name" => "appointment_same_day",
                "title" => "Aynı Güne Randevu",
                "desc" => "Bu seçenek aktif edilirse, işlem günü için randevu alınabilir.",
                "value" => json_encode(false),
                "options" => json_encode([]),
                "element" => "toggle",
                "category" => "Randevu",
            ],
            [
                "name" => "age_range",
                "title" => "Katılımcı Yaş Aralığı",
                "desc" => "",
                "value" => json_encode([
                    "min" => "10",
                    "max" => "65"
                ]),
                "options" => json_encode([]),
                "element" => "input:text:double",
                "category" => "Randevu",
            ],
            [
                "name" => "appointment_times",
                "title" => "Randevu Saatleri",
                "desc" => "Katılımcı sadece belirtilen saatlerde randevu alabilir.",
                "value" => json_encode(["09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00"]),
                "options" => json_encode([]),
                "element" => "button:addable",
                "category" => "Randevu",
            ],
            [
                "name" => "bank_name",
                "title" => "Banka İsmi",
                "desc" => "",
                "value" => json_encode("İş Bank"),
                "options" => json_encode([]),
                "element" => "input:text",
                "category" => "Ödeme",
            ],
            [
                "name" => "account_name",
                "title" => "Hesap Adı",
                "desc" => "",
                "value" => json_encode("Saliha Nur Can"),
                "options" => json_encode([]),
                "element" => "input:text",
                "category" => "Ödeme",
            ],
            [
                "name" => "iban_no",
                "title" => "IBAN Numarası",
                "desc" => "",
                "value" => json_encode("TR76 0009 9012 3456 7800 1000 01"),
                "options" => json_encode([]),
                "element" => "input:text",
                "category" => "Ödeme",
            ],
            [
                "name" => "feedback_duration",
                "title" => "Geri Bildirim Süresi",
                "desc" => "Randevu sonrasında katılımcı geri bildirim e-postası aldıktan sonra, belirtilen süre içinde yorum yapması beklenir.",
                "value" => json_encode("10"),
                "options" => json_encode("gün"),
                "element" => "input:text",
                "category" => "Geri Bildirim",
            ],
            [
                "name" => "feedback_max_score",
                "title" => "Geri Bildirim Puanı",
                "desc" => "Katılımcı belirtilen puan üzerinden değerlendirme yapar.",
                "value" => json_encode("5"),
                "options" => json_encode([]),
                "element" => "input:text",
                "category" => "Geri Bildirim",
            ],
            [
                "name" => "feedback_text_length",
                "title" => "Geri Bildirim Metni",
                "desc" => "Katılımcı belirtilen uzunlukta metin yazabilir.",
                "value" => json_encode("300"),
                "options" => json_encode('harf'),
                "element" => "input:text",
                "category" => "Geri Bildirim",
            ],
            [
                "name" => "feedback_number",
                "title" => "Geri Bildirim Sayısı",
                "desc" => "Sitede gösterilecek geri bildirim sayısı(En az 5, en fazla 30).",
                "value" => json_encode("30"),
                "options" => json_encode('adet'),
                "element" => "input:text",
                "category" => "Geri Bildirim",
            ],
            [
                "name" => "contact_email",
                "title" => "İletişim E-Posta Adresi",
                "desc" => "Randevu alındıktan sonra gönderilen e-posta içerisinde yer alan iletişim adresi.",
                "value" => json_encode("contact@sitename.com"),
                "options" => json_encode([]),
                "element" => "input:text",
                "category" => "Site",
            ],

            [
                "name" => "suicide_contract",
                "title" => "İntihar Sözleşmesi",
                "desc" => "",
                "value" => json_encode(""),
                "options" => json_encode([]),
                "element" => "list",
                "category" => "Sözleşmeler",
            ],
            [
                "name" => "user_agreement",
                "title" => "Kullanıcı Sözleşmesi",
                "desc" => "",
                "value" => json_encode(""),
                "options" => json_encode([]),
                "element" => "list",
                "category" => "Sözleşmeler",
            ],
            [
                "name" => "kvkk",
                "title" => "Aydınlatma Metni",
                "desc" => "",
                "value" => json_encode(""),
                "options" => json_encode([]),
                "element" => "list",
                "category" => "Sözleşmeler",
            ]
        ];

        DB::table('settings')->insert($settings);
    }
}
