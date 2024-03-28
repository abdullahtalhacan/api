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
                "value" => json_encode("Europe/Istanbul"),
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
                "name" => "cancellation_duration",
                "title" => "Randevu İptal Süresi (Geri iade için geçerlidir)",
                "desc" => "Randevu saatine kalan süre belirtilen süreden fazla ise kişi randevuyu iptal edebilir. (Bu seçenek sadece randevu ücretini ödemiş kişiler için geçerlidir.)",
                "value" => json_encode("36"),
                "options" => json_encode("saat"),
                "element" => "input:text",
                "category" => "Randevu",
            ],
            [
                "name" => "edit_duration",
                "title" => "Randevu Düzenleme Süresi",
                "desc" => "Randevu saatine kalan süre belirtilen süreden fazla ise katılımcı düzenleme veya iptal işlemlerini yapabilir.",
                "value" => json_encode("36"),
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
                "name" => "terms",
                "title" => "Randevu Şartları",
                "desc" => "Belirtilen şartlara göre randevu kaydı yapılacak.",
                "value" => json_encode([
                    "Seans süresi 45 Dakikadır.",
                    "Seans ücreti 300 TL'dir.",
                    "Randevunuz seans ücreti ödendikten sonra aktif hale gelecektir.",
                    "Randevunuzu seans saatinden 12 saat öncesine kadar düzenleyebilir veya iptal edeblirsiniz.",
                    "Seans ücretini IBAN adresimize gönderebilirsiniz. Gönderme işlemi sırasında mutlaka açıklama kısmına tam adınızı yazınız."
                ]),
                "options" => json_encode([]),
                "element" => "list",
                "category" => "Randevu",
            ],
            [
                "name" => "agreement",
                "title" => "Randevu Sözleşmesi",
                "desc" => "Belirtilen şartlara göre randevu kaydı yapılacak.",
                "value" => json_encode([<<<END
<p class="MsoNormal" style="text-align:justify;text-indent:.25in;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;" lang="TR" dir="ltr">Ben ____________________________ , kendime zarar verme düşüncelerim olduğunda intihar etmeyeceğime ve aşağıdaki planı uygulayacağıma söz veriyorum. Bu kriz planını, terapistim Psikolog ____________________________________ ile beraber hazırladım. (________________________________________________ I promise not to commit suicide when I have thoughts of harming myself and to follow the plan below. I prepared this crisis plan together with my therapist, Psychologist _________________________.)</span></span>
</p>
<p class="MsoListParagraphCxSpFirst" style="margin-left:40px;mso-list:l0 level1 lfo1;text-align:justify;text-indent:-.25in;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">1.</span><span style="font:7.0pt 'Times New Roman';line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:115%;" lang="TR" dir="ltr">Kendime zarar verme düşüncelerim olduğunda aşağıda belirtilen kişileri telefonla aramayı kabul ediyorum. (I agree to call the following people by phone when I have thoughts of harming myself.)</span></span>
</p>
<p class="MsoListParagraphCxSpMiddle" style="margin-left:.75in;mso-add-space:auto;mso-list:l2 level1 lfo2;text-align:justify;text-indent:-.25in;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">a.</span><span style="font:7.0pt 'Times New Roman';line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:115%;" lang="TR" dir="ltr">Birinci dereceden yakının Adı Soyadı (Name and Surname of first degree relative):</span></span>
</p>
<p class="MsoListParagraphCxSpMiddle" style="margin-left:.75in;mso-add-space:auto;mso-list:l2 level1 lfo2;text-align:justify;text-indent:-.25in;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">b.</span><span style="font:7.0pt 'Times New Roman';line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:115%;" lang="TR" dir="ltr">Birinci dereceden yakının Adı Soyadı (Name and Surname of first degree relative):</span></span>
</p>
<p class="MsoListParagraphCxSpMiddle" style="margin-left:.75in;mso-add-space:auto;mso-list:l2 level1 lfo2;text-align:justify;text-indent:-.25in;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">c.</span><span style="font:7.0pt 'Times New Roman';line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:115%;" lang="TR" dir="ltr">Bir akraba ya da arkadaşının Adı Soyadı (Name and Surname of a relative or friend):</span></span>
</p>
<p class="MsoListParagraphCxSpMiddle" style="margin-left:40px;mso-list:l0 level1 lfo1;text-align:justify;text-indent:-.25in;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">2.</span><span style="font:7.0pt 'Times New Roman';line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:115%;" lang="TR" dir="ltr">Kendime zarar verme düşüncelerim hâlâ devam ediyorsa aşağıda belirtilen mekânlardan birine gitmeyi kabul ediyorum. (If I still have thoughts of harming myself, I agree to go to one of the places listed below.)</span></span>
</p>
<p class="MsoListParagraphCxSpMiddle" style="margin-left:.75in;mso-add-space:auto;mso-list:l1 level1 lfo3;text-align:justify;text-indent:-.25in;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">a.</span><span style="font:7.0pt 'Times New Roman';line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:115%;" lang="TR" dir="ltr">Evinin yakınlarında bir yer (Somewhere near your house):</span></span>
</p>
<p class="MsoListParagraphCxSpMiddle" style="margin-left:.75in;mso-add-space:auto;mso-list:l1 level1 lfo3;text-align:justify;text-indent:-.25in;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">b.</span><span style="font:7.0pt 'Times New Roman';line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:115%;" lang="TR" dir="ltr">İşinin veya okulunun yakınlarında bir yer (Somewhere near your work or school):</span></span>
</p>
<p class="MsoListParagraphCxSpMiddle" style="margin-left:.75in;mso-add-space:auto;mso-list:l1 level1 lfo3;text-align:justify;text-indent:-.25in;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">c.</span><span style="font:7.0pt 'Times New Roman';line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:115%;" lang="TR" dir="ltr">Sevdiği bir yer (A favorite place):</span></span>
</p>
<p class="MsoListParagraphCxSpLast" style="margin-left:40px;mso-list:l0 level1 lfo1;text-align:justify;text-indent:-.25in;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">3.</span><span style="font:7.0pt 'Times New Roman';line-height:115%;mso-fareast-font-family:'Times New Roman';mso-list:Ignore;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="line-height:115%;" lang="TR" dir="ltr">Kendime zarar verme düşüncelerim hâlâ devam ediyorsa bulunduğum yere en yakın hastanenin Acil Servisine gitmeyi kabul ediyorum. (If I still have thoughts of harming myself, I agree to go to the Emergency Service of the nearest hospital.)</span></span>
</p>
<p class="MsoNormal" style="text-align:justify;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;" lang="TR" dir="ltr">Danışanın Adı Soyadı (Client's Name and Surname):</span><span style="line-height:115%;mso-spacerun:yes;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
</p>
<p class="MsoNormal" style="text-align:justify;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;" lang="TR" dir="ltr">İmza (Signature):</span></span>
</p>
<p class="MsoNormal" style="text-align:justify;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;" lang="TR" dir="ltr">&nbsp;</span></span>
</p>
<p class="MsoNormal" style="text-align:justify;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;" lang="TR" dir="ltr">Terapistin Adı Soyadı (Therapist's Name and Surname):</span></span>
</p>
<p class="MsoNormal" style="text-align:justify;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;" lang="TR" dir="ltr">İmza (Signature):</span><span style="line-height:115%;mso-spacerun:yes;" lang="TR" dir="ltr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</span></span>
</p>
<p class="MsoNormal" style="text-align:justify;">
    <span style="font-family:'Times New Roman',serif;font-size:12.0pt;"><span style="line-height:115%;" lang="TR" dir="ltr">&nbsp;</span></span>
</p>
END]),
                "options" => json_encode([]),
                "element" => "list",
                "category" => "Randevu",
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
                "name" => "contact_email",
                "title" => "İletişim E-Posta Adresi",
                "desc" => "Randevu alındıktan sonra gönderilen e-posta içerisinde yer alan iletişim adresi.",
                "value" => json_encode("contact@sitename.com"),
                "options" => json_encode([]),
                "element" => "input:text",
                "category" => "Site",
            ]
        ];

        DB::table('settings')->insert($settings);
    }
}
