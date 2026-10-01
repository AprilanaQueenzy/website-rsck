<?php

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Rumah Sakit Cinta Kasih Tzu Chi</title>
    <style>
        :root {
            --primary: #0284c7;
            --primary-light: #38bdf8;
            --text-dark: #0f172a;
            --text-muted: #475569;
            --line-color: #e2e8f0;
            --bg-light: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            color: var(--text-dark);
            background-color: #ffffff;
            line-height: 1.7;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .header-wrapper {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #ffffff;
            border-bottom: 1px solid var(--line-color);
        }

        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .hero-section {
            position: relative;
            width: 100%;
            padding: 70px 0 60px 0;
            background-image: 
                linear-gradient(to bottom, 
                    rgba(255, 255, 255, 0.2) 0%, 
                    rgba(255, 255, 255, 0.85) 70%, 
                    #ffffff 100%), 
                url('https://i.ytimg.com/vi/LC-vrUZzmA4/maxresdefault.jpg');
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 24px;
            letter-spacing: -0.5px;
        }

        .profile-text p {
            font-size: 16px;
            color: var(--text-dark);
            margin-bottom: 16px;
            text-align: justify;
        }

        .bg-feature-block {
            position: relative;
            padding: 100px 0;
            overflow: hidden;
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
            mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
        }

        .bg-feature-block.visi-bg {
            background-image: 
                linear-gradient(
                    to right, 
                    #ffffff 0%, 
                    rgba(255, 255, 255, 0.95) 35%, 
                    rgba(255, 255, 255, 0.3) 70%, 
                    rgba(255, 255, 255, 0) 100%
                ), 
                url('https://cdn-healthcare.hellohealthgroup.com/2022/08/1661764709_630c8465d528e8.59332073.jpg');
            background-size: cover;
            background-position: right center;
            background-repeat: no-repeat;
        }

        .bg-feature-block.misi-bg {
            background-image: 
                linear-gradient(
                    to left, 
                    #ffffff 0%, 
                    rgba(255, 255, 255, 0.95) 35%, 
                    rgba(255, 255, 255, 0.3) 70%, 
                    rgba(255, 255, 255, 0) 100%
                ), 
                url('https://www.tzuchi.or.id/inliners/1653021639-perawat-7-edt.png');
            background-size: cover;
            background-position: left center;
            background-repeat: no-repeat;
        }

        .feature-content {
            max-width: 580px;
        }

        .visi-bg .feature-content {
            margin-right: auto;
            text-align: left;
        }

        .misi-bg .feature-content {
            margin-left: auto;
            text-align: right;
        }

        .section-tag {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--primary);
            font-weight: 700;
            display: block;
            margin-bottom: 8px;
        }

        .section-heading {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 16px;
            letter-spacing: -0.3px;
        }

        .feature-content p {
            font-size: 16px;
            color: var(--text-dark);
            line-height: 1.8;
            font-weight: 500;
        }

        .misi-list {
            list-style: none;
            padding: 0;
        }

        .misi-list li {
            position: relative;
            padding-right: 24px;
            margin-bottom: 12px;
            font-size: 15.5px;
            color: var(--text-dark);
            font-weight: 500;
            text-align: right;
        }

        .misi-list li::before {
            content: "—";
            position: absolute;
            right: 0;
            color: var(--primary);
            font-weight: bold;
        }

        .animated-lines-section {
            position: relative;
            padding: 150px 0 170px 0;
            background-color: #f8fafc;
            border-top: none;
            border-bottom: none;
            overflow: hidden;
        }

        .meaningful-line-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            object-fit: cover;
        }

        .meaningful-line-bg path {
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .line-pulse {
            stroke: var(--primary);
            stroke-width: 1.5px;
            opacity: 0.5;
            stroke-dasharray: 600, 600;
            animation: seamlessPulse 8s linear infinite;
        }

        .line-top-wave {
            stroke: var(--primary-light);
            stroke-width: 1.2px;
            opacity: 0.35;
            stroke-dasharray: 800, 800;
            animation: seamlessPulse 12s linear infinite;
        }

        .line-bottom-wave {
            stroke: var(--primary);
            stroke-width: 1.1px;
            opacity: 0.3;
            stroke-dasharray: 700, 700;
            animation: seamlessPulseReverse 10s linear infinite;
        }

        @keyframes seamlessPulse {
            0% {
                stroke-dashoffset: 1200;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes seamlessPulseReverse {
            0% {
                stroke-dashoffset: 0;
            }
            100% {
                stroke-dashoffset: 1200;
            }
        }

        .animated-lines-section .container {
            position: relative;
            z-index: 2;
        }

        .lines-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 50px;
            align-items: start;
        }

        .minimal-item {
            text-align: center;
            padding: 0 15px;
        }

        .item-falsafah {
            transform: translateY(20px);
        }

        .item-nilai {
            transform: translateY(-15px);
        }

        .item-moto {
            transform: translateY(25px);
        }

        .minimal-tag {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 12px;
            display: block;
        }

        .minimal-item h4 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 14px;
            letter-spacing: -0.3px;
        }

        .minimal-item p {
            font-size: 16px;
            color: var(--text-muted);
            line-height: 1.7;
            font-weight: 500;
        }

        .minimal-item.item-moto p {
            font-style: italic;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 17.5px;
        }

        @media (max-width: 850px) {
            .bg-feature-block {
                padding: 60px 0;
            }

            .feature-content {
                max-width: 100% !important;
                margin: 0 !important;
            }

            .lines-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .minimal-item {
                transform: none !important;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header-wrapper">
        <?php include 'header.php'; ?>
    </div>
    <section class="hero-section">
        <div class="container">
            <h1 class="page-title">Profile</h1>
            <div class="profile-text">
                <p>Rumah Sakit Cinta Kasih Tzu Chi berdiri dibawah naungan Yayasan Buddha Tzu Chi Medika yang merupakan salah satu Badan Misi Yayasan Buddha Tzu Chi Indonesia yang bergerak di bidang Kesehatan.</p>
                <p>Rumah Sakit Cinta Kasih Tzu Chi telah terakreditasi Komisi Akreditasi Rumah Sakit (KARS) dengan Nomor Sertifikat KARS-SERT/765/VI/2019 dan Lulus Tingkat Paripurna pada 30 Juni 2019.</p>
                <p>Status Rumah Sakit Cinta Kasih Tzu Chi per tanggal 14 Desember 2016 berubah dari Rumah Sakit Khusus Bedah Kelas C menjadi Rumah Sakit Umum Kelas C sesuai dengan SK Kepala Dinas Provinsi DKI Jakarta No. 8821 Tahun 2016 tentang Perubahan Jenis Rumah Sakit menjadi Rumah Sakit Umum Cinta Kasih Tzu Chi dan No. 8822 Tahun 2016 tentang Sertifikat Penetapan Kelas Rumah Sakit.</p>
            </div>
        </div>
    </section>
    <section class="bg-feature-block visi-bg">
        <div class="container">
            <div class="feature-content">
                <span class="section-tag">Arah & Pandangan</span>
                <h2 class="section-heading">Visi Kami</h2>
                <p>Menjadi rumah sakit paripurna, bermutu dan terjangkau di Indonesia dengan berpegang teguh pada cinta kasih universal.</p>
            </div>
        </div>
    </section>
    <section class="bg-feature-block misi-bg">
        <div class="container">
            <div class="feature-content">
                <span class="section-tag">Komitmen Utama</span>
                <h2 class="section-heading">Misi Kami</h2>
                <ul class="misi-list">
                    <li>Memberikan pelayanan kesehatan dengan berlandaskan pada sifat welas asih dan kasih sayang</li>
                    <li>Meningkatkan integritas, kejujuran dan komitmen insan rumah sakit pada kemanusiaan</li>
                    <li>Meningkatkan kompetensi tenaga kesehatan menuju tenaga kesehatan yang handal dan profesional</li>
                    <li>Memberikan keteladanan dalam pelayanan medis</li>
                </ul>
            </div>
        </div>
    </section>
    <section class="animated-lines-section">
        <svg class="meaningful-line-bg" viewBox="0 0 1200 450" preserveAspectRatio="none">
            <defs>
                <pattern id="dotGrid" x="0" y="0" width="30" height="30" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="1" fill="#0284c7" opacity="0.08" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dotGrid)" />
            <path class="line-top-wave" d="
                M 0,80 
                C 300,160 300,0 600,80 
                C 900,160 900,0 1200,80
            " />
            <path class="line-pulse" d="
                M 0,225 
                L 100,225 
                L 110,185 L 120,265 L 135,105 L 150,305 L 165,185 L 175,225 
                L 350,225 
                L 360,185 L 370,265 L 385,115 L 400,295 L 415,195 L 425,225 
                L 600,225 
                L 610,185 L 620,265 L 635,105 L 650,305 L 665,185 L 675,225 
                L 850,225 
                L 860,185 L 870,265 L 885,115 L 900,295 L 915,195 L 925,225 
                L 1100,225
                L 1110,185 L 1120,265 L 1135,105 L 1150,305 L 1165,185 L 1175,225
                L 1200,225
            " />
            <path class="line-bottom-wave" d="
                M 0,370 
                C 300,290 300,430 600,370 
                C 900,290 900,430 1200,370
            " />
        </svg>
        <div class="container">
            <div class="lines-grid">
                <div class="minimal-item item-falsafah">
                    <span class="minimal-tag">01 / Landasan Utama</span>
                    <h4>Falsafah</h4>
                    <p>Melayani Tanpa Membedakan</p>
                </div>
                <div class="minimal-item item-nilai">
                    <span class="minimal-tag">02 / Budaya Kerja</span>
                    <h4>Nilai Utama</h4>
                    <p>Memberikan kebahagiaan pada semua insan di rumah sakit.</p>
                </div>
                <div class="minimal-item item-moto">
                    <span class="minimal-tag">03 / Semangat Pelayanan</span>
                    <h4>Moto Kami</h4>
                    <p>"Melayani berlandaskan kasih tanpa pamrih."</p>
                </div>

            </div>
        </div>
    </section>
    <script>
         document.onkeydown = function(e) {
         if(event.keyCode == 123) {
         return false;
         }
         if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
         return false;
         }
         if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
         return false;
         }
         if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
         return false;
         }
         if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
         return false;
         }
         if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
         return false;
         }
         if(e.ctrlKey && e.keyCode == 'H'.charCodeAt(0)){
         return false;
         }
         if(e.ctrlKey && e.keyCode == 'A'.charCodeAt(0)){
         return false;
         }
         if(e.ctrlKey && e.keyCode == 'F'.charCodeAt(0)){
         return false;
         }
         if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
         return false;
         }
         }
             var message="Function Disabled!";
             function clickdsb(){
             if (event.button==2){
             alert(message);
             return false;
             }
             }
             function clickbsb(e){
             if (document.layers||document.getElementById&&!document.all){
             if (e.which==2||e.which==3){
             alert(message);
             return false;
             }
             }
             }
             if (document.layers){
             document.captureEvents(Event.MOUSEDOWN);
             document.onmousedown=clickbsb;
             }
             else if (document.all&&!document.getElementById){
             document.onmousedown=clickdsb;
             }

             document.oncontextmenu=new Function("alert(message);return false")
     </script>
    <footer id="kontak">
        <?php include 'footer.php' ?>
    </footer>
</body>
</html>