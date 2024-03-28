<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title></title>
</head>
<body style="width: 100%;
  display: flex;
  justify-content: center;
  color: #1F2937;
  background-color: #d8d8d9;">
<div style="
  padding-left: 2rem;
padding-right: 2rem;
padding-top: 1.25rem;
padding-bottom: 1.25rem;
max-width: 64rem;">

    <div
        style="
        padding: 1rem;
        border-radius: 0.75rem;
        background-color: #ffffff;
        box-shadow:
          0 1px 3px 0 rgba(0, 0, 0, 0.1),
          0 1px 2px 0 rgba(0, 0, 0, 0.06);
      "
    >
        <div
            style="
          display: flex;
          margin-top: 1rem;
          flex-direction: column;
          justify-content: center;
          align-items: center;
        "
        >
            <div
                style="
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
          "
            >
                <div style="position: relative; padding-bottom: 1rem">
                    <div
                        style="
                position: absolute;
                top: -3px;
                left: 0.25rem;
                border-radius: 0.375rem;
                width: 2.5rem;
                height: 2.5rem;
                background-color:  rgb(22 163 74 / 1);
                transform: rotate(12deg);
              "
                    ></div>
                    <div
                        style="
                display: flex;
                z-index: 50;
                justify-content: center;
                align-items: center;
                border-radius: 0.375rem;
                width: 2.5rem;
                height: 2.5rem;
                background-color: rgb(255 255 255 / 0.3);
                backdrop-filter: blur(4px);
              "
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            aria-hidden="true"
                            data-slot="icon"
                            style="width: 1.5rem; height: 1.5rem; color: #ffffff"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                            ></path>
                        </svg>
                    </div>
                </div>
                <h2
                    style="
              font-size: 1.25rem;
              line-height: 1.75rem;
              font-weight: 700;
              color: #1f2937;
            "
                >
                    Teşekkürler! Randevunuz Kayıt Edildi.
                </h2>
                <p style="max-width: 56rem;font-size: 0.875rem; line-height: 1.25rem; color: #4b5563">
                    Merhaba {{ $name }}. Lütfen aşağıdaki bilgileri kontrol ediniz. Eğer bilgilerde bir yanlışlık
                    olduğunu düşünüyorsanız bizimle iletişime geçebilir yada <strong><a
                            href="{{ $site_url }}/appointment/manage"
                            style="text-decoration: underline;color: #1F2937;">Randevu
                            İşlemleri</a></strong> sayfasından bilgilerinizi düzenleyebilirsiniz.
                </p>
            </div>
            <div style="display: flex">
                <div
                    style="
              padding-top: 0.25rem;
              padding-bottom: 0.25rem;
              padding-left: 0.75rem;
              padding-right: 0.75rem;
              border-radius: 0.375rem;
              border: solid 1px rgb(9 9 11 / 0.2);
            "
                >
                    <div
                        style="
                display: grid;
                padding-top: 1rem;
                padding-bottom: 1rem;
                border-bottom: solid 1px rgb(9 9 11 / 0.2);
                margin-left: 0.875rem;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                align-items: center;
              "
                    >
                        <div
                            style="
                  display: flex;
                  margin-right: 0.75rem;
                  grid-column: span 2 / span 2;
                  align-items: center;
                "
                        >
                            <div
                                style="
                    padding: 0.375rem;
                    margin-right: 0.5rem;
                    border-radius: 0.375rem;
                    border-width: 1px;
                  "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                    data-slot="icon"
                                    style="width: 1.25rem; height: 1.25rem"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"
                                    ></path>
                                </svg>
                            </div>
                            <span style="font-weight: 600">Ücret</span>
                        </div>
                        <span style="grid-column: span 3 / span 3">{{ $price }}</span>
                    </div>
                    <div
                        style="
                display: grid;
                padding-top: 1rem;
                padding-bottom: 1rem;
                border-bottom: solid 1px rgb(9 9 11 / 0.2);
                margin-left: 0.875rem;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                align-items: center;
              "
                    >
                        <div
                            style="
                  display: flex;
                  margin-right: 0.75rem;
                  grid-column: span 2 / span 2;
                  align-items: center;
                "
                        >
                            <div
                                style="
                    padding: 0.375rem;
                    margin-right: 0.5rem;
                    border-radius: 0.375rem;
                    border-width: 1px;
                  "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                    data-slot="icon"
                                    style="width: 1.25rem; height: 1.25rem"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                    ></path>
                                </svg>
                            </div>
                            <span style="font-weight: 600">Saat</span>
                        </div>
                        <span style="grid-column: span 3 / span 3">{{ $time }}</span>
                    </div>
                    <div
                        style="
                display: grid;
                padding-top: 1rem;
                padding-bottom: 1rem;
                border-bottom: solid 1px rgb(9 9 11 / 0.2);
                margin-left: 0.875rem;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                align-items: center;
              "
                    >
                        <div
                            style="
                  display: flex;
                  margin-right: 0.75rem;
                  grid-column: span 2 / span 2;
                  align-items: center;
                "
                        >
                            <div
                                style="
                    padding: 0.375rem;
                    margin-right: 0.5rem;
                    border-radius: 0.375rem;
                    border-width: 1px;
                  "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                    data-slot="icon"
                                    style="width: 1.25rem; height: 1.25rem"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z"
                                    ></path>
                                </svg>
                            </div>
                            <span style="font-weight: 600">Tarih</span>
                        </div>
                        <span style="grid-column: span 3 / span 3">{{ $date }}</span>
                    </div>
                    <div
                        style="
                display: grid;
                padding-top: 1rem;
                padding-bottom: 1rem;
                margin-left: 0.875rem;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                align-items: center;
              "
                    >
                        <div
                            style="
                  display: flex;
                  margin-right: 0.75rem;
                  grid-column: span 2 / span 2;
                  align-items: center;
                "
                        >
                            <div
                                style="
                    padding: 0.375rem;
                    margin-right: 0.5rem;
                    border-radius: 0.375rem;
                    border-width: 1px;
                  "
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                    data-slot="icon"
                                    style="width: 1.25rem; height: 1.25rem"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z"
                                    ></path>
                                </svg>
                            </div>
                            <span
                                style="display: flex; align-items: center; font-weight: 600"
                            >
                  <span style="margin-right: 0.25rem">Randevu Kodu</span>

                </span>
                        </div>
                        <span style="grid-column: span 3 / span 3">{{ $verifyCode }}</span>
                    </div>
                </div>
            </div>
            <div style="max-width: 48rem; margin-top: 2rem;">
                <div
                    style="
              padding: 0.5rem;
              border-radius: 0.375rem;
              background-color: #ecfdf5;
              transition-property: all;
              transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
              transition-duration: 300ms;
              opacity: 1;
            "
                >
                    <div style="display: flex">

                        <div style="margin-left: 0.75rem; flex-grow: 1">
                            <div
                                style="
                    font-size: 0.875rem;
                    line-height: 1.25rem;
                    color: #047857;
                  "
                            >
                                <p>
                                    Bir sorunuz mu var? Bize
                                    <span style="font-weight: 600; color: #047857">
                        <a href="mailto:{{ $contact_email }}"
                           style="text-decoration: underline;color: #047857">{{ $contact_email }}</a>
                    </span>
                                    adresinden e-posta gönderebilirisiniz.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
