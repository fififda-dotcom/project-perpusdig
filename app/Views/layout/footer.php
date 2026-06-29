</div> <!-- Menutup div .content -->

<style>
.paw-footer-container {
    margin-top: 50px;
    width: 100%;
    box-sizing: border-box;
    font-family: 'Quicksand', sans-serif;
}

/* 1. Baris Newsletter (Gelap) */
.paw-newsletter-row {
    background-color: #2E2118;
    color: #FFFDF9;
    padding: 40px 50px;
    border-top-left-radius: 24px;
    border-top-right-radius: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 30px;
}

.newsletter-info h3 {
    margin: 0 0 8px 0;
    font-size: 1.8rem;
    font-weight: 700;
    font-family: 'Quicksand', sans-serif;
}

.newsletter-info p {
    margin: 0;
    font-size: 0.95rem;
    color: #ebd5c5;
    font-weight: 500;
}

.newsletter-form {
    display: flex;
    gap: 12px;
    flex-grow: 1;
    max-width: 500px;
    width: 100%;
}

.newsletter-form input {
    flex-grow: 1;
    padding: 14px 20px;
    border: 2px solid #5c4c3f;
    border-radius: 12px;
    background-color: #3d2d22;
    color: white;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
}

.newsletter-form input::placeholder {
    color: #8c7b70;
}

.newsletter-form input:focus {
    outline: none;
    border-color: #E69C62;
}

.newsletter-form button {
    background-color: #E69C62;
    color: white;
    border: none;
    padding: 14px 28px;
    border-radius: 12px;
    font-weight: 700;
    font-family: 'Quicksand', sans-serif;
    cursor: pointer;
    transition: background 0.2s;
    font-size: 0.95rem;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.2);
}

.newsletter-form button:hover {
    background-color: #c8814a;
}

/* 2. Baris Kolom Informasi & Link */
.paw-footer-links-row {
    background-color: #FAF6F0;
    border-left: 1px solid #ebd5c5;
    border-right: 1px solid #ebd5c5;
    padding: 50px;
    display: grid;
    grid-template-columns: 1.2fr 1fr 1fr 1.2fr;
    gap: 40px;
}

@media (max-width: 992px) {
    .paw-footer-links-row {
        grid-template-columns: 1.5fr 1fr 1.5fr;
    }
}

@media (max-width: 768px) {
    .paw-footer-links-row {
        grid-template-columns: 1fr;
        padding: 30px;
        gap: 30px;
    }
}

.footer-col {
    display: flex;
    flex-direction: column;
}

.footer-logo-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.6rem;
    font-weight: 700;
    color: #2E2118;
    margin-bottom: 12px;
}

.footer-logo-tagline {
    font-size: 0.9rem;
    font-weight: 700;
    color: #E69C62;
    margin-bottom: 10px;
}

.footer-logo-desc {
    font-size: 0.85rem;
    color: #756456;
    line-height: 1.6;
    margin: 0;
}

.footer-col h4 {
    margin: 0 0 20px 0;
    font-size: 1rem;
    font-weight: 700;
    color: #2E2118;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.footer-col ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.footer-col ul li a {
    color: #756456;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.2s;
    display: inline-block;
}

.footer-col ul li a:hover {
    color: #E69C62;
    transform: translateX(4px);
}

.footer-col.info-col p {
    margin: 0 0 12px 0;
    font-size: 0.88rem;
    color: #756456;
    font-weight: 600;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    line-height: 1.5;
}

.footer-col.info-col p i {
    color: #E69C62;
    margin-top: 3px;
    width: 14px;
}

/* 3. Baris Copyright & Sosial Media */
.paw-footer-bottom-row {
    background-color: #FAF6F0;
    border: 1px solid #ebd5c5;
    border-top: 1px solid #ebd5c5;
    border-bottom-left-radius: 24px;
    border-bottom-right-radius: 24px;
    padding: 25px 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

@media (max-width: 576px) {
    .paw-footer-bottom-row {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }
}

.footer-copyright {
    font-size: 0.85rem;
    color: #8c7b70;
    font-weight: 600;
}

.footer-socials {
    display: flex;
    gap: 12px;
}

.social-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid #ebd5c5;
    background-color: white;
    color: #756456;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.social-icon:hover {
    background-color: #E69C62;
    color: white !important;
    border-color: #E69C62;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(230, 156, 98, 0.2);
}
</style>

<!-- RENDER FOOTER UTAMA -->
<div class="paw-footer-container">
    <!-- Baris 1: Newsletter -->
    <div class="paw-newsletter-row">
        <div class="newsletter-info">
            <h3>Subscribe to our newsletter!</h3>
            <p>Dapatkan info buku baru, promosi, dan rekomendasi hangat langsung di email-mu.</p>
        </div>
        <div class="newsletter-form">
            <input type="email" placeholder="Masukkan email-mu..." required>
            <button type="button" onclick="alert('Terima kasih sudah berlangganan! 🐾')">Subscribe</button>
        </div>
    </div>

    <!-- Baris 2: Link Kolom -->
    <div class="paw-footer-links-row">
        <!-- Logo & Deskripsi Brand -->
        <div class="footer-col brand-col">
            <div class="footer-logo-brand">🐾 PawLib</div>
            <div class="footer-logo-tagline">"Kehangatan Buku di Setiap Langkah"</div>
            <p class="footer-logo-desc">
                PawLib memadukan kenyamanan membaca dengan kehangatan layaknya seekor kucing yang tertidur tenang di pangkuan Anda.
            </p>
        </div>
        
        <!-- Kolom Layanan -->
        <div class="footer-col">
            <h4>Layanan Pustaka</h4>
            <ul>
                <li><a href="/katalog">Katalog Buku</a></li>
                <li><a href="/profile/riwayat">Peminjaman Buku</a></li>
                <li><a href="/profile/riwayat">Pengembalian</a></li>
            </ul>
        </div>
        
        <!-- Kolom Menu Anggota -->
        <div class="footer-col">
            <h4>Menu Anggota</h4>
            <ul>
                <li><a href="/profile">Dashboard</a></li>
                <li><a href="/profile">Profil Saya</a></li>
                <li><a href="/profile/riwayat">Riwayat Saya</a></li>
            </ul>
        </div>
        
        <!-- Kolom Kontak / Hubungi Kami -->
        <div class="footer-col info-col">
            <h4>Hubungi Kami</h4>
            <p><i class="fas fa-clock"></i> <span>Setiap Hari (08.00 - 21.00 WIB)</span></p>
            <p><i class="fas fa-map-marker-alt"></i> <span>Lantai 2, Rak Hangat PawLib</span></p>
            <p><i class="fas fa-envelope"></i> <span>help@pawlib.com</span></p>
        </div>
    </div>

    <!-- Baris 3: Copyright & Sosial Media -->
    <div class="paw-footer-bottom-row">
        <div class="footer-copyright">
            © 2026 PawLib. All rights reserved.
        </div>
        <div class="footer-socials">
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-x-twitter"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
        </div>
    </div>
</div>

</div> <!-- Menutup div .main -->

<script>
document.getElementById('toggle-btn').addEventListener('click', function(){
    document.body.classList.toggle('hide-sidebar');
});
</script>
</body>
</html>