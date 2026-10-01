<style>
    .rs-footer-section {
        background: linear-gradient(
            to bottom, 
            rgba(224, 242, 254, 0) 0%, 
            rgba(186, 230, 253, 0.45) 40px, 
            rgba(186, 230, 253, 0.85) 100%
        );
        color: #0f172a;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        font-size: 0.88rem;
        margin-top: 40px;
        padding-top: 50px;
        clear: both;
        position: relative;
        z-index: 1;
        box-sizing: border-box;
    }

    .rs-footer-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 310px 1fr;
        gap: 36px;
        align-items: start;
        box-sizing: border-box;
    }

    .rs-left-column {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .rs-map-card {
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #bae6fd;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.06);
    }

    .rs-map-card iframe {
        width: 100%;
        height: 155px;
        border: 0;
        display: block;
    }

    .rs-map-action-bar {
        background: #f0f9ff;
        padding: 8px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #e0f2fe;
    }

    .rs-map-action-bar span {
        color: #0369a1;
        font-size: 0.78rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .rs-map-btn {
        background: #0284c7;
        color: #ffffff;
        padding: 5px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 600;
        transition: background 0.2s;
    }

    .rs-map-btn:hover { background: #0369a1; }
    .rs-contact-wrapper {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .rs-contact-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-radius: 10px;
        text-decoration: none;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        box-shadow: 0 2px 5px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }

    .rs-contact-card:hover {
        transform: translateY(-2px);
    }

    .rs-contact-card.rs-call-center {
        border-left: 4px solid #0284c7;
    }

    .rs-contact-card.rs-call-center:hover {
        border-color: #0284c7;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.15);
    }

    .rs-contact-card.rs-emergency {
        border-left: 4px solid #dc2626;
    }

    .rs-contact-card.rs-emergency:hover {
        border-color: #dc2626;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
    }

    .rs-contact-inner {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .rs-icon-badge {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .rs-call-center .rs-icon-badge { background: #e0f2fe; color: #0284c7; }
    .rs-emergency .rs-icon-badge { background: #fee2e2; color: #dc2626; }

    .rs-icon-badge svg { width: 18px; height: 18px; fill: currentColor; }

    .rs-contact-text-group { display: flex; flex-direction: column; }

    .rs-contact-tag {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .rs-call-center .rs-contact-tag { color: #0284c7; }
    .rs-emergency .rs-contact-tag { color: #dc2626; }

    .rs-contact-val {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        margin-top: 1px;
    }

    .rs-contact-action {
        color: #94a3b8;
        font-size: 1.1rem;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .rs-contact-card:hover .rs-contact-action {
        transform: translateX(3px);
    }

    .rs-call-center:hover .rs-contact-action { color: #0284c7; }
    .rs-emergency:hover .rs-contact-action { color: #dc2626; }
    .rs-info-content {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .rs-brand-header {
        display: flex;
        flex-direction: column;
        gap: 8px;
        border-bottom: 1.5px solid #bae6fd;
        padding-bottom: 14px;
    }

    .rs-brand-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .rs-brand-logo { height: 40px; width: auto; object-fit: contain; }

    .rs-brand-text-group h3 {
        color: #0284c7;
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .rs-brand-text-group span {
        color: #0369a1;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .rs-brand-description {
        color: #475569;
        font-size: 0.82rem;
        line-height: 1.5;
        margin: 0;
    }

    .rs-details-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 20px;
    }

    .rs-info-box label {
        display: block;
        color: #0284c7;
        font-size: 0.78rem;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        border-bottom: 1.5px solid #bae6fd;
        padding-bottom: 4px;
    }

    .rs-nav-list-2col {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px 15px;
    }

    .rs-nav-list-2col a {
        color: #334155;
        text-decoration: none;
        font-size: 0.85rem;
        display: block;
    }

    .rs-nav-list-2col a:hover {
        color: #0284c7;
        text-decoration: underline;
    }

    .rs-info-box p {
        color: #334155;
        line-height: 1.5;
        margin: 0 0 8px 0;
        font-size: 0.85rem;
    }

    .rs-contact-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 6px;
    }

    .rs-contact-item a { color: #334155; text-decoration: none; }
    .rs-contact-item a:hover { color: #0284c7; text-decoration: underline; }
    .rs-inline-icon { width: 16px; height: 16px; fill: #0284c7; flex-shrink: 0; }

    .rs-bottom-right-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 20px;
        padding-top: 14px;
        margin-top: -6px;
        border-top: 1px dashed #bae6fd;
    }

    .rs-social-bar {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .rs-social-title {
        font-size: 0.78rem;
        color: #0284c7;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .rs-social-icons-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rs-social-icon {
        width: 36px;
        height: 36px;
        background: #ffffff;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        color: #0284c7;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .rs-social-icon svg { width: 18px; height: 18px; fill: #0284c7; }

    .rs-social-icon:hover {
        background: #0284c7;
        border-color: #0284c7;
        transform: translateY(-2px);
    }

    .rs-social-icon:hover svg { fill: #ffffff; }
    .rs-app-section-right {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .rs-app-title-right {
        color: #0284c7;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .google-play-badge {
        display: inline-flex;
        align-items: center;
        background-color: #000000;
        color: #ffffff;
        padding: 6px 14px;
        border-radius: 7px;
        text-decoration: none;
        border: 1px solid #a6a6a6;
        box-sizing: border-box;
        transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        height: 42px;
        width: fit-content;
    }

    .google-play-badge:hover {
        background-color: #111111;
        border-color: #ffffff;
        transform: translateY(-1px);
    }

    .google-play-badge svg {
        width: 20px;
        height: 22px;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .google-play-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: left;
    }

    .google-play-text .sub-text {
        font-size: 8.5px;
        font-weight: 500;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        color: #ffffff;
        line-height: 1;
        margin-bottom: 2px;
    }

    .google-play-text .title-text {
        font-size: 15px;
        font-weight: 600;
        letter-spacing: -0.2px;
        color: #ffffff;
        line-height: 1;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .rs-copyright-bar {
        background-color: rgba(2, 132, 199, 0.08);
        margin-top: 24px;
        padding: 14px 20px;
        border-top: 1px solid rgba(2, 132, 199, 0.15);
        color: #475569;
        font-size: 0.78rem;
    }

    .rs-copyright-flex {
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .rs-copyright-flex a { color: #475569; text-decoration: none; margin-left: 14px; }
    .rs-copyright-flex a:hover { color: #0284c7; text-decoration: underline; }

    @media (max-width: 850px) {
        .rs-footer-container { grid-template-columns: 1fr; }
    }
</style>

<footer class="rs-footer-section">
    <div class="rs-footer-container">
        <div class="rs-left-column">
            <div class="rs-map-card">
                <iframe 
                    src="https://maps.google.com/maps?q=Rumah%20Sakit%20Cinta%20Kasih%20Tzu%20Chi%20Cengkareng&t=&z=16&ie=UTF8&iwloc=B&output=embed" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <div class="rs-map-action-bar">
                    <span>
                        <svg style="width:14px; height:14px; fill:#0369a1;" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        RS Cinta Kasih Tzu Chi
                    </span>
                    <a href="https://www.google.com/maps/search/?api=1&query=Rumah+Sakit+Cinta+Kasih+Tzu+Chi+Cengkareng" target="_blank" rel="noopener noreferrer" class="rs-map-btn">
                        Petunjuk Arah &rarr;
                    </a>
                </div>
            </div>
            <div class="rs-contact-wrapper">
                <a href="tel:02155963680" class="rs-contact-card rs-call-center" title="Hubungi Call Center">
                    <div class="rs-contact-inner">
                        <div class="rs-icon-badge">
                            <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                        </div>
                        <div class="rs-contact-text-group">
                            <span class="rs-contact-tag">Call Center</span>
                            <span class="rs-contact-val">021 5596 3680</span>
                        </div>
                    </div>
                    <div class="rs-contact-action">&rarr;</div>
                </a>
                <a href="tel:02150950800" class="rs-contact-card rs-emergency" title="Hubungi Emergency / UGD">
                    <div class="rs-contact-inner">
                        <div class="rs-icon-badge">
                            <svg viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9 4.03-9 9v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7c0-4.97-4.03-9-9-9zm0 2c3.87 0 7 3.13 7 7v1H5v-1c0-3.87 3.13-7 7-7zm-7 14v-4h14v4H5zm7-11c.83 0 1.5.67 1.5 1.5S12.83 11 12 11s-1.5-.67-1.5-1.5S11.17 8 12 8z"/></svg>
                        </div>
                        <div class="rs-contact-text-group">
                            <span class="rs-contact-tag">IGD 24 Jam</span>
                            <span class="rs-contact-val">021 5095 0800</span>
                        </div>
                    </div>
                    <div class="rs-contact-action">&rarr;</div>
                </a>
            </div>
        </div>
        <div class="rs-info-content">
            <div class="rs-brand-header">
                <div class="rs-brand-title-wrap">
                    <img src="assets/img/logo.png" alt="Logo RS Cinta Kasih Tzu Chi" class="rs-brand-logo" onerror="this.style.display='none'">
                    <div class="rs-brand-text-group">
                        <h3>RUMAH SAKIT CINTA KASIH TZU CHI</h3>
                        <span>Cengkareng, Jakarta Barat</span>
                    </div>
                </div>
                <p class="rs-brand-description">
                    Memberikan pelayanan kesehatan yang profesional dan berstandar tinggi dengan landasan cinta kasih demi kesejahteraan masyarakat.
                </p>
            </div>
            <div class="rs-details-grid">
                <div class="rs-info-box">
                    <label>Navigasi Menu</label>
                    <ul class="rs-nav-list-2col">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="#">Promosi</a></li>
                        <li><a href="tentang-kami.php">Tentang Kami</a></li>
                        <li><a href="berita.php">Berita</a></li>
                        <li><a href="#">Jadwal Dokter</a></li>
                        <li><a href="#">Indikator Mutu</a></li>
                        <li><a href="layanan.php">Fasilitas &amp; Layanan</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="rs-info-box">
                    <label>Kontak & Operasional</label>
                    <p>Jl. Kamal Raya Outer Ring Road, Cengkareng Timur, Jakarta Barat, 11730</p>
                    <div class="rs-contact-item">
                        <svg class="rs-inline-icon" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        <span><strong>Email:</strong> <a href="mailto:email@rscktzuchi.co.id">email@rscktzuchi.co.id</a></span>
                    </div>
                    <div class="rs-contact-item">
                        <svg class="rs-inline-icon" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                        <span><strong>Telp:</strong> <a href="tel:02155963680">021 - 55963680</a></span>
                    </div>
                    <p style="margin-top: 10px;"><strong>Jam Layanan:</strong><br>Senin - Sabtu: 08:00 - 15:30 WIB<br>Minggu: Tutup</p>
                </div>
            </div>
            <div class="rs-bottom-right-row">
                <div class="rs-social-bar">
                    <span class="rs-social-title">Ikuti Kami</span>
                    <div class="rs-social-icons-wrapper">
                        <a href="#" class="rs-social-icon" title="Facebook">
                            <svg viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H7.5v-3H10V9.5C10 7.02 11.49 5.65 13.7 5.65c1.06 0 2.17.19 2.17.19v2.38h-1.22c-1.23 0-1.61.76-1.61 1.54V12h2.69l-.43 3h-2.26v6.8c4.56-.93 8-4.96 8-9.8z"/></svg>
                        </a>
                        
                        <a href="#" class="rs-social-icon" title="Twitter / X">
                            <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>

                        <a href="#" class="rs-social-icon" title="Instagram">
                            <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        
                        <a href="#" class="rs-social-icon" title="YouTube">
                            <svg viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>
                <div class="rs-app-section-right">
                    <span class="rs-app-title-right">DAPATKAN APLIKASI MOBILE</span>
                    <a href="https://play.google.com/store/search?q=rumah+sakit+cinta+kasih+tzu+chi&c=apps" target="_blank" rel="noopener noreferrer" class="google-play-badge">
                        <svg viewBox="0 0 512 512">
                            <path fill="#0288d1" d="M22.28 12.35C15.19 19.8 11 31.62 11 47.16v417.68c0 15.54 4.19 27.36 11.28 34.81l1.81 1.76L263.3 262.2v-2.4L24.09 10.59l-1.81 1.76z"/>
                            <path fill="#00d676" opacity=".9" d="M346.42 345.32l-83.12-83.12v-2.4l83.12-83.12 1.88 1.07 98.42 55.92c28.11 15.97 28.11 42.17 0 58.14l-98.42 55.92-1.88 1.59z"/>
                            <path fill="#ffca28" d="M348.3 346.91L263.3 261.9 22.28 503.11c9.25 9.8 24.52 11.02 41.74 1.25l284.28-157.45z"/>
                            <path fill="#f44336" d="M348.3 177.09L64.02 19.64C46.8 9.87 31.53 11.09 22.28 20.89L263.3 261.9l85-84.81z"/>
                        </svg>
                        <div class="google-play-text">
                            <span class="sub-text">TEMUKAN DI</span>
                            <span class="title-text">Google Play</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="rs-copyright-bar">
        <div class="rs-copyright-flex">
            <div>
                Copyright &copy; <?php echo date('Y'); ?> Yayasan BUDDHA TZU CHI MEDIKA INDONESIA.
            </div>
            <div>
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</footer>