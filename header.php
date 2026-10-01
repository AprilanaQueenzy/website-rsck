<style>
    /* Mengatur agar saat link layanan atau kontak diklik, gulirannya halus dan tidak tertutup header */
    html {
        scroll-behavior: smooth;
        scroll-padding-top: 85px; 
    }

    body {
        overflow-x: hidden; /* Mencegah munculnya scrollbar horizontal saat animasi slide */
    }

    /* Styling Dasar Header */
    .rs-header-custom {
        background-color: #ffffff;
        border-bottom: 1px solid #f3f4f6; 
        position: sticky;
        top: 0;
        z-index: 1000;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        width: 100%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
    }
    
    .rs-header-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 12px 20px; 
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-sizing: border-box;
    }

    /* Area Logo & Judul */
    .rs-logo-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .rs-logo-img {
        height: 45px; 
        width: auto;
        margin: 0;
        padding: 0;
        display: block;
    }

    .rs-logo-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 1px; 
        line-height: 1.1;
        margin: 0;
        padding: 0;
    }

    .rs-logo-title {
        color: #006699; 
        font-size: 17px; 
        font-weight: 700;
        letter-spacing: 0.5px;
        margin: 0; 
        padding: 0;
    }

    .rs-logo-subtitle {
        color: #6b7280; 
        font-size: 11px; 
        letter-spacing: 1.2px;
        font-weight: 500;
        margin: 0; 
        padding: 0;
    }

    /* Hamburger Menu Button (Hanya muncul di HP) */
    .rs-hamburger {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 24px;
        color: #1f2937;
        padding: 5px;
    }

    /* Area Navigasi Menu Utama */
    .rs-nav-menu {
        display: flex;
        gap: 20px; 
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .rs-nav-menu > li {
        position: relative;
        padding: 5px 0; 
    }

    .rs-nav-menu a {
        text-decoration: none;
        color: #1f2937; 
        font-size: 14px; 
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: color 0.2s ease;
        cursor: pointer; 
        white-space: nowrap;
    }

    .rs-nav-menu a:hover,
    .rs-nav-menu a.active-dropdown {
        color: #006699; 
    }

    /* --- SIDE FLOATING BUTTONS (POSISI DINAIKKAN & UKURAN DIBESARKAN) --- */
    .rs-side-widgets {
        position: fixed;
        right: 0;
        top: 85px; /* Dinaikkan mendekati header (sebelumnya 120px) */
        z-index: 9999;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
    }

    /* Style dasar tombol samping */
    .side-widget-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #ffffff !important;
        text-decoration: none;
        padding: 14px 20px; /* Diberikan padding lebih besar (sebelumnya 12px 16px) */
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
        box-shadow: -3px 4px 14px rgba(0, 0, 0, 0.2);
        font-weight: 700;
        font-size: 15px; /* Ukuran teks diperbesar (sebelumnya 13px) */
        letter-spacing: 0.5px;
        white-space: nowrap;
        cursor: pointer;
        /* Default: Bersembunyi ke kanan, hanya menampilkan area ikon (~54px) */
        transform: translateX(calc(100% - 54px));
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Ketika KURSOR DIARAHKAN (HOVER): Slide membukan ke kiri */
    .side-widget-btn:hover {
        transform: translateX(0);
    }

    .side-widget-btn svg {
        flex-shrink: 0;
    }

    /* Warna Tombol Call Center (Hijau) */
    .side-call-center {
        background-color: #00a040;
    }

    .side-call-center:hover {
        background-color: #008434;
    }

    /* Warna Tombol IGD (Merah) */
    .side-igd {
        background-color: #e50000;
    }

    .side-igd:hover {
        background-color: #cc0000;
    }

    /* --- ANIMASI PANAH DROPDOWN --- */
    .dropdown-icon {
        font-size: 8px;
        color: inherit; 
        display: inline-block;
        transition: transform 0.2s ease;
    }

    .rs-nav-menu a.active-dropdown .dropdown-icon {
        transform: rotate(90deg);
    }

    /* --- STYLING DROPDOWN MENU --- */
    .dropdown-content {
        display: none; 
        position: absolute;
        top: 100%; 
        left: 0;
        background-color: #ffffff;
        min-width: 250px; 
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        border-radius: 4px;
        border: 1px solid #e5e7eb;
        padding: 0; 
        list-style: none;
        margin: 0;
        z-index: 1001;
    }

    .dropdown-content.show {
        display: block;
        animation: fadeInDown 0.2s ease;
    }

    .dropdown-content li {
        padding: 0;
        border-bottom: 1px solid #f3f4f6; 
    }

    .dropdown-content li:last-child {
        border-bottom: none; 
    }

    .dropdown-content a {
        padding: 14px 20px; 
        font-size: 14px;
        color: #374151; 
        font-weight: 400; 
        display: block;
        line-height: 1.4;
        white-space: normal;
    }

    .dropdown-content a:hover {
        background-color: #f8fafc;
        color: #006699;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* --- RESPONSIVE KHUSUS UNTUK HP (MAX-WIDTH: 1024px) --- */
    @media (max-width: 1024px) {
        .rs-hamburger {
            display: block;
        }

        .rs-nav-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: #ffffff;
            flex-direction: column;
            align-items: flex-start;
            gap: 0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid #e5e7eb;
            padding: 10px 0;
        }

        .rs-nav-menu.active-mobile {
            display: flex;
        }

        .rs-nav-menu > li {
            width: 100%;
            padding: 0;
        }

        .rs-nav-menu > li > a {
            padding: 12px 20px;
            width: 100%;
            box-sizing: border-box;
            border-bottom: 1px solid #f9fafb;
        }

        .dropdown-content {
            position: static;
            box-shadow: none;
            border: none;
            background-color: #f8fafc;
            padding-left: 15px;
            width: 100%;
            box-sizing: border-box;
        }

        .dropdown-content a {
            padding: 10px 20px;
        }
    }
</style>

<header class="rs-header-custom">
    <div class="rs-header-inner">
        
        <!-- Bagian Kiri: Logo dan Teks -->
        <a href="index.php" class="rs-logo-wrapper">
            <img src="tzuchilogo.png" alt="Logo RS Cinta Kasih" class="rs-logo-img">
            <div class="rs-logo-text">
                <span class="rs-logo-title">RUMAH SAKIT CINTA KASIH TZU CHI</span>
                <span class="rs-logo-subtitle">CENGKARENG</span>
            </div>
        </a>

        <!-- Tombol Hamburger (Garis 3 untuk HP) -->
        <button class="rs-hamburger" onclick="toggleMobileMenu()" aria-label="Menu">
            ☰
        </button>

        <!-- Bagian Kanan: Menu Navigasi Utama -->
        <ul class="rs-nav-menu" id="navMenu">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="tentang-kami.php">Tentang Kami</a></li>
            <li><a href="jadwal-dokter.php">Jadwal Dokter</a></li>
            
            <!-- Menu Dropdown: Informasi -->
            <li>
                <a onclick="toggleDropdown(event, 'info-menu')" class="dropdown-trigger">
                    Informasi <span class="dropdown-icon">►</span>
                </a>
                <ul class="dropdown-content" id="info-menu">
                    <li><a href="promosi.php">Promosi</a></li>
                    <li><a href="berita.php">Berita</a></li>
                    <li><a href="indikator-mutu.php">Indikator Mutu</a></li>
                </ul>
            </li>
            
            <!-- Menu Dropdown: Fasilitas & Layanan -->
            <li>
                <a onclick="toggleDropdown(event, 'fasilitas-menu')" class="dropdown-trigger">
                    Fasilitas & Layanan <span class="dropdown-icon">►</span>
                </a>
                <ul class="dropdown-content" id="fasilitas-menu">
                    <li><a href="layanan.php#igd">IGD (Gawat Darurat)</a></li>
                    <li><a href="layanan.php#poli-penyakit-dalam">Poliklinik Rawat Jalan</a></li>
                    <li><a href="layanan.php#laboratorium">Instalasi Laboratorium</a></li>
                    <li><a href="layanan.php#radiologi">Instalasi Radiologi</a></li>
                    <li><a href="layanan.php#mcu">Medical Check Up (MCU)</a></li>
                    <li><a href="layanan.php" style="font-weight: 500; color: #006699;">Lihat Semua Layanan</a></li>
                </ul>
            </li>
            
            <li><a href="karir.php">Karir</a></li>
            <li><a href="#footer" onclick="scrollToFooter(event)">Kontak</a></li>
        </ul>

    </div>
</header>

<!-- Floating Side Widgets -->
<div class="rs-side-widgets">
    <!-- 1. Tombol Call Center (Hijau) -->
    <a href="https://wa.me/6281234567890" target="_blank" class="side-widget-btn side-call-center">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
        <span>CALL CENTER</span>
    </a>

    <!-- 2. Tombol IGD (Merah) -->
    <a href="tel:02154363000" class="side-widget-btn side-igd">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
        </svg>
        <span>IGD EMERGENCY</span>
    </a>
</div>

<script>
    function toggleMobileMenu() {
        const navMenu = document.getElementById('navMenu');
        navMenu.classList.toggle('active-mobile');
    }

    function closeMobileMenu() {
        const navMenu = document.getElementById('navMenu');
        if (navMenu.classList.contains('active-mobile')) {
            navMenu.classList.remove('active-mobile');
        }
    }

    function scrollToFooter(event) {
        event.preventDefault();
        closeMobileMenu();

        const footerTarget = document.getElementById('footer') || document.querySelector('footer');
        const targetPosition = footerTarget 
            ? footerTarget.getBoundingClientRect().top + window.pageYOffset 
            : (document.documentElement.scrollHeight - window.innerHeight);

        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        const duration = 1000;
        let startTimestamp = null;

        function step(currentTime) {
            if (!startTimestamp) startTimestamp = currentTime;
            const elapsed = currentTime - startTimestamp;
            const progress = Math.min(elapsed / duration, 1);

            const ease = progress < 0.5 
                ? 4 * progress * progress * progress 
                : 1 - Math.pow(-2 * progress + 2, 3) / 2;

            window.scrollTo(0, startPosition + (distance * ease));

            if (elapsed < duration) {
                requestAnimationFrame(step);
            }
        }

        requestAnimationFrame(step);
    }

    function toggleDropdown(event, dropdownId) {
        event.preventDefault(); 
        event.stopPropagation(); 
        
        const currentDropdown = document.getElementById(dropdownId);
        const triggerBtn = event.currentTarget;
        
        const isCurrentlyOpen = currentDropdown.classList.contains('show');
        
        const allDropdowns = document.getElementsByClassName("dropdown-content");
        const allTriggers = document.getElementsByClassName("dropdown-trigger");
        
        for (let i = 0; i < allDropdowns.length; i++) {
            allDropdowns[i].classList.remove('show');
            allTriggers[i].classList.remove('active-dropdown');
        }
        
        if (!isCurrentlyOpen) {
            currentDropdown.classList.add('show');
            triggerBtn.classList.add('active-dropdown');
        }
    }

    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-trigger') && !event.target.closest('.dropdown-trigger') && !event.target.matches('.rs-hamburger') && !event.target.closest('.rs-hamburger')) {
            const allDropdowns = document.getElementsByClassName("dropdown-content");
            const allTriggers = document.getElementsByClassName("dropdown-trigger");
            
            for (let i = 0; i < allDropdowns.length; i++) {
                if (allDropdowns[i].classList.contains('show')) {
                    allDropdowns[i].classList.remove('show');
                    allTriggers[i].classList.remove('active-dropdown');
                }
            }

            const navMenu = document.getElementById('navMenu');
            if (navMenu.classList.contains('active-mobile') && !event.target.closest('.rs-nav-menu')) {
                navMenu.classList.remove('active-mobile');
            }
        }
    }
</script>