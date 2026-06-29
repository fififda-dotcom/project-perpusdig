<?= $this->include('layout/sidebar'); ?>
<?= $this->include('layout/header'); ?>
<?php
$db = \Config\Database::connect();
$favoritIds = [];
$wishlistIds = [];
if (session()->get('role') == 'anggota') {
    $anggotaId = session()->get('anggota_id');
    $favoritList = $db->table('favorit')->where('anggota_id', $anggotaId)->get()->getResultArray();
    $favoritIds = array_column($favoritList, 'buku_id');
    
    $wishlistList = $db->table('wishlist')->where('anggota_id', $anggotaId)->get()->getResultArray();
    $wishlistIds = array_column($wishlistList, 'buku_id');
}
?>

<!-- Impor Google Font Quicksand agar selaras dengan tema kucing yang bulat dan hangat -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Impor Font Awesome untuk ikon-ikon cantik -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<?php
// Kumpulan quotes acak bertema buku dan kucing (khusus Anggota)
$quotes = [
[
'text' => 'Buku itu seperti kucing; mereka diam-diam mengisi ruang kosong di hati kita tanpa kita sadari.',
'author' => 'PawLib Mascot 🐾'
],
[
'text' => 'Tidak ada tempat tidur yang lebih nyaman di dunia selain wangi hangat dari tumpukan buku dan dengkuran manis seekor kucing.',
'author' => 'Pecinta Kucing & Buku'
],
[
'text' => 'Membaca buku bagaikan membelai kucing; perlahan-lahan menenangkan jiwa dan meredakan kepenatan hari.',
'author' => 'Pustakawan Cozy'
],
[
'text' => 'Ada dua cara untuk melarikan diri dari kesedihan dunia: musik dan kucing... serta wangi lembaran buku baru.',
'author' => 'Literature Club'
]
];
$selectedQuote = $quotes[array_rand($quotes)];

// Aggregated RSS News Aggregator for both Admin & Member Carousel
$newsItems = [];
$showNews = false;

// Read settings from writable
$settingsFilePath = WRITEPATH . 'news_settings.json';
$newsSettings = [
'cnn_enabled' => true,
'cnbc_enabled' => true,
'detik_enabled' => true,
'antara_enabled' => true,
'news_keyword' => ''
];
if (file_exists($settingsFilePath)) {
$jsonContent = @file_get_contents($settingsFilePath);
$parsedJson = json_decode($jsonContent, true);
if (is_array($parsedJson)) {
$newsSettings = array_merge($newsSettings, $parsedJson);
}
}

$feeds = [];
if (isset($newsSettings['cnn_enabled']) && $newsSettings['cnn_enabled']) {
$feeds['CNN Indonesia'] = 'https://www.cnnindonesia.com/nasional/rss';
}
if (isset($newsSettings['cnbc_enabled']) && $newsSettings['cnbc_enabled']) {
$feeds['CNBC Indonesia'] = 'https://www.cnbcindonesia.com/news/rss';
}
if (isset($newsSettings['detik_enabled']) && $newsSettings['detik_enabled']) {
$feeds['Detikcom'] = 'https://news.detik.com/berita/rss';
}
if (isset($newsSettings['antara_enabled']) && $newsSettings['antara_enabled']) {
$feeds['Antara News'] = 'https://www.antaranews.com/rss/top-news';
}

$context = stream_context_create([
'http' => [
'timeout' => 2.0,
'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n"
]
]);

$filterKeyword = trim($newsSettings['news_keyword']);

foreach ($feeds as $sourceName => $feedUrl) {
try {
$rssContent = @file_get_contents($feedUrl, false, $context);
if ($rssContent !== false) {
$xml = @simplexml_load_string($rssContent);
if ($xml && isset($xml->channel->item)) {
foreach ($xml->channel->item as $item) {
$title = (string)$item->title;
$link = (string)$item->link;
$description = (string)$item->description;
$pubDate = (string)$item->pubDate;

// Apply keyword filter (split by commas for multi-keyword search)
if ($filterKeyword !== '') {
$keywordsArray = array_map('trim', explode(',', $filterKeyword));
$matchesKeyword = false;
foreach ($keywordsArray as $kw) {
if ($kw !== '' && ((stripos($title, $kw) !== false) || (stripos($description, $kw) !== false))) {
$matchesKeyword = true;
break;
}
}
if (!$matchesKeyword) {
continue;
}
}

$imageUrl = '';
if (isset($item->enclosure) && isset($item->enclosure['url'])) {
$imageUrl = (string)$item->enclosure['url'];
} elseif (preg_match('/<img[^>]+src="([^">]+)"/', $description, $matches)) {
$imageUrl = $matches[1];
}

$descText = trim(strip_tags($description));
if (mb_strlen($descText) > 150) {
$descText = mb_substr($descText, 0, 147) . '...';
}

$timestamp = strtotime($pubDate);

$newsItems[] = [
'source' => $sourceName,
'title' => $title,
'link' => $link,
'image' => $imageUrl,
'desc' => $descText,
'date' => date('d M Y H:i', $timestamp),
'timestamp' => $timestamp
];
}
}
}
} catch (\Exception $e) {
// Silently skip if one feed fails
}
}

// Sort items by timestamp DESC (newest first)
if (count($newsItems) > 0) {
usort($newsItems, function ($a, $b) {
return $b['timestamp'] - $a['timestamp'];
});
// Slice top 6 articles
$newsItems = array_slice($newsItems, 0, 6);
$showNews = true;
}
?>

<style>
/* CSS Utama bertema Cozy Cat & Minimalis */
.paw-container {
font-family: 'Quicksand', sans-serif;
color: #4a3c31;
}

/* Hero Box Premium */
.hero-box {
background: linear-gradient(135deg, #FFF9F3 0%, #FBE7D4 100%);
padding: 45px 50px;
border-radius: 28px;
box-shadow: 0 8px 24px rgba(230, 156, 98, 0.08);
margin-bottom: 25px;
position: relative;
overflow: hidden;
border: 2px solid #f2e7dd;
}

.hero-box::after {
content: "🐾";
position: absolute;
right: 40px;
bottom: -10px;
font-size: 140px;
opacity: 0.07;
transform: rotate(-15deg);
pointer-events: none;
}

.hero-box h1 {
font-family: 'Quicksand', sans-serif;
font-weight: 700;
font-size: 38px;
color: #2E2118;
margin: 0 0 10px 0;
}

.hero-box p {
font-size: 1.1rem;
color: #756456;
margin: 0;
max-width: 600px;
line-height: 1.5;
}

/* Quote Box */
.paw-quote-card {
background: #FFFDFC;
border: 2px dashed #ebd5c5;
border-radius: 20px;
padding: 22px 28px;
margin-bottom: 40px;
display: flex;
align-items: center;
gap: 20px;
position: relative;
box-shadow: 0 4px 12px rgba(74, 60, 49, 0.02);
}

.paw-quote-icon {
font-size: 28px;
color: #E69C62;
background-color: #fff2e8;
width: 54px;
height: 54px;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
flex-shrink: 0;
}

.paw-quote-content {
display: flex;
flex-direction: column;
}

.paw-quote-text {
font-style: italic;
font-size: 1.05rem;
color: #5c4c3f;
line-height: 1.4;
margin: 0 0 4px 0;
}

.paw-quote-author {
font-size: 0.8rem;
font-weight: 700;
color: #E69C62;
text-transform: uppercase;
letter-spacing: 0.5px;
}

/* Section Headings */
h2 {
font-family: 'Quicksand', sans-serif;
font-weight: 700;
font-size: 24px;
color: #2E2118;
margin-top: 35px;
margin-bottom: 20px;
display: flex;
align-items: center;
gap: 10px;
}

/* Grid Layout */
.paw-grid {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
gap: 24px;
margin-bottom: 40px;
}

/* Card Buku */
.paw-card {
background: #ffffff;
border: 2px solid #f2e7dd;
border-radius: 20px;
overflow: hidden;
display: flex;
flex-direction: column;
box-shadow: 0 8px 18px rgba(74, 60, 49, 0.04);
transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
position: relative;
height: 100%;
}

.paw-card:hover {
transform: translateY(-8px);
box-shadow: 0 16px 30px rgba(230, 156, 98, 0.12);
border-color: #E69C62;
}

.paw-card-img-wrapper {
position: relative;
width: 100%;
height: 250px;
background-color: #fffaf5;
border-bottom: 2px solid #f2e7dd;
display: flex;
justify-content: center;
align-items: center;
overflow: hidden;
}

.paw-card-img {
width: 100%;
height: 100%;
object-fit: cover;
transition: transform 0.4s ease;
}

.paw-card:hover .paw-card-img {
transform: scale(1.05);
}

.paw-card-body {
padding: 18px;
flex-grow: 1;
display: flex;
flex-direction: column;
text-align: center;
}

.paw-book-title {
font-size: 1.05rem;
font-weight: 700;
line-height: 1.3;
color: #4a3c31;
margin-bottom: 6px;
display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
height: 2.6rem; 
}

.paw-book-author {
font-size: 0.85rem;
color: #8c7b70;
font-weight: 500;
margin-bottom: 15px;
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
}

/* Action Buttons */
.paw-actions {
display: flex;
gap: 8px;
margin-top: auto;
}

.btn-paw {
flex: 1;
padding: 10px 12px;
border-radius: 30px;
font-size: 0.85rem;
font-weight: 700;
text-decoration: none !important;
transition: all 0.2s ease;
display: inline-flex;
align-items: center;
justify-content: center;
gap: 6px;
border: none;
cursor: pointer;
}

.btn-paw-primary {
background: #E69C62;
color: white !important;
box-shadow: 0 4px 10px rgba(230, 156, 98, 0.15);
}

.btn-paw-primary:hover:not(:disabled) {
background: #c8814a;
transform: translateY(-1px);
}

.btn-paw-primary:disabled {
background: #ebdcd0;
color: #a69b90;
cursor: not-allowed;
box-shadow: none;
}

.btn-paw-secondary {
background: #fdf6ee;
color: #E69C62 !important;
border: 2px solid #ebd5c5;
}

.btn-paw-secondary:hover {
background: #FFF0E0;
transform: translateY(-1px);
}

/* Tombol Favorit floating di atas Cover */
.paw-favorite-btn {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 2;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(74, 60, 49, 0.1);
    color: #c0b3a7; /* Warna default 🤍 */
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: 2px solid #f2e7dd;
    cursor: pointer;
}
.paw-favorite-btn:hover {
    transform: scale(1.1);
    color: #E74C3C;
}
.paw-favorite-btn.favorited {
    color: #E74C3C; /* Warna aktif ❤️ */
    background: #fff5f5;
    border-color: #ffcdd2;
}

/* Tombol Wishlist floating di atas Cover */
.paw-wishlist-btn {
    position: absolute;
    top: 12px;
    left: 56px;
    z-index: 2;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(74, 60, 49, 0.1);
    color: #c0b3a7; /* Warna default 🤍 */
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: 2px solid #f2e7dd;
    cursor: pointer;
}
.paw-wishlist-btn:hover {
    transform: scale(1.1);
    color: #F1C40F;
}
.paw-wishlist-btn.saved {
    color: #F1C40F; /* Warna aktif ⭐ */
    background: #fffdf0;
    border-color: #fceea7;
}

/* Footer Card (Tombol Aksi) */
.paw-card-footer {
    padding: 0 15px 15px 15px;
    display: flex;
    gap: 8px;
    margin-top: auto;
}

.btn-action {
    flex: 1;
    padding: 10px 12px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 700;
    text-decoration: none;
    text-align: center;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-family: 'Quicksand', sans-serif;
    transition: all 0.2s ease;
}

.btn-action-detail {
    background: #f0e2d3;
    color: #4a3c31;
}

.btn-action-detail:hover {
    background: #e0d0bf;
    color: #4a3c31;
    text-decoration: none;
}

.btn-action-pinjam {
    background: #E69C62;
    color: white;
    box-shadow: 0 4px 10px rgba(230, 156, 98, 0.15);
}

.btn-action-pinjam:hover:not(:disabled) {
    background: #c8814a;
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.btn-action-pinjam:disabled {
    background: #ebdcd0;
    color: #a69b90;
    cursor: not-allowed;
    box-shadow: none;
}

/* Status Badge di atas Cover */
.paw-status-badge {
position: absolute;
top: 12px;
right: 12px;
z-index: 2;
font-size: 0.75rem;
font-weight: 700;
padding: 5px 12px;
border-radius: 20px;
box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
text-transform: uppercase;
}

.badge-tersedia {
background-color: #e2f9e1;
color: #1e6b26;
border: 1px solid rgba(30, 107, 38, 0.15);
}

.badge-habis {
background-color: #ffebee;
color: #c62828;
border: 1px solid rgba(198, 40, 40, 0.15);
}

/* Stats Layout */
.stats-grid {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
gap: 24px;
margin-bottom: 40px;
}

.stat-card {
background: white;
border: 2px solid #f2e7dd;
border-radius: 24px;
padding: 24px;
display: flex;
align-items: center;
gap: 20px;
box-shadow: 0 6px 15px rgba(74, 60, 49, 0.03);
transition: transform 0.2s ease;
}

.stat-card:hover {
transform: translateY(-2px);
}

.stat-icon-wrapper {
width: 65px;
height: 65px;
border-radius: 20px;
display: flex;
align-items: center;
justify-content: center;
font-size: 26px;
}

.icon-purple {
background-color: #f3effc;
color: #8E44AD;
}

.icon-blue {
background-color: #eaf2fc;
color: #4A90E2;
}

.icon-orange {
background-color: #fff2e8;
color: #E69C62;
}

.icon-green {
background-color: #eafcf0;
color: #2ECC71;
}

.stat-info {
display: flex;
flex-direction: column;
}

.stat-num {
font-size: 1.8rem;
font-weight: 700;
color: #2E2118;
line-height: 1.1;
}

.stat-label {
font-size: 0.85rem;
color: #8c7b70;
font-weight: 600;
margin-top: 4px;
}

/* DDC List Styling */
.ddc-stats-card {
background: white;
border: 2px solid #f2e7dd;
border-radius: 24px;
padding: 30px;
box-shadow: 0 8px 18px rgba(74, 60, 49, 0.03);
margin-bottom: 40px;
}

.ddc-list {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
gap: 15px;
}

.ddc-item {
background: #FFFBF7;
border: 1px solid #f2e7dd;
border-radius: 16px;
padding: 15px 20px;
display: flex;
justify-content: space-between;
align-items: center;
transition: all 0.2s ease;
}

.ddc-item:hover {
background: #FFF5EB;
border-color: #ebd5c5;
transform: translateX(3px);
}

.ddc-info {
display: flex;
flex-direction: column;
gap: 2px;
}

.ddc-code {
font-weight: 700;
color: #E69C62;
font-size: 0.95rem;
}

.ddc-name {
font-size: 0.85rem;
color: #8c7b70;
font-weight: 600;
}

.ddc-count {
background: #ebd5c5;
color: #4a3c31;
padding: 6px 14px;
border-radius: 20px;
font-size: 0.8rem;
font-weight: 700;
}

/* Activity Card Styling */
.activity-card {
background: white;
border: 2px solid #f2e7dd;
border-radius: 24px;
padding: 30px;
box-shadow: 0 8px 18px rgba(74, 60, 49, 0.03);
margin-bottom: 40px;
}

.activity-list {
display: flex;
flex-direction: column;
gap: 15px;
}

.activity-item {
display: flex;
align-items: center;
gap: 15px;
padding-bottom: 15px;
border-bottom: 1px dashed #f2e7dd;
}

.activity-item:last-child {
border-bottom: none;
padding-bottom: 0;
}

.activity-badge {
padding: 6px 14px;
border-radius: 20px;
font-size: 0.75rem;
font-weight: 700;
text-transform: uppercase;
display: inline-flex;
align-items: center;
gap: 5px;
width: 120px;
justify-content: center;
flex-shrink: 0;
box-sizing: border-box;
}

.badge-borrowed {
background: #FFF2E8;
color: #E69C62;
border: 1px solid rgba(230, 156, 98, 0.2);
}

.badge-returned {
background: #EAFCF0;
color: #2ECC71;
border: 1px solid rgba(46, 204, 113, 0.2);
}

.activity-details {
flex-grow: 1;
font-size: 0.95rem;
color: #5c4c3f;
line-height: 1.4;
overflow-wrap: break-word;
word-break: break-word;
}

.activity-details strong {
color: #2E2118;
}

.activity-time {
font-size: 0.8rem;
color: #a89a8e;
font-weight: 500;
display: inline-flex;
align-items: center;
gap: 4px;
flex-shrink: 0;
}

/* Empty State Card */
.empty-state-card {
background: white;
border: 2px dashed #ebd5c5;
border-radius: 24px;
padding: 45px 30px;
text-align: center;
box-shadow: 0 4px 12px rgba(74, 60, 49, 0.01);
color: #8c7b70;
margin-bottom: 40px;
}

.empty-state-icon {
font-size: 45px;
color: #ebd5c5;
margin-bottom: 15px;
}

.empty-state-text {
font-size: 1rem;
font-weight: 600;
margin: 0;
line-height: 1.5;
}

/* Borrow Active Card */
.borrow-card {
background: white;
border: 2px solid #f2e7dd;
border-radius: 24px;
padding: 20px;
display: flex;
gap: 20px;
align-items: center;
box-shadow: 0 6px 15px rgba(74, 60, 49, 0.03);
transition: transform 0.2s ease;
}

.borrow-card:hover {
transform: translateY(-3px);
border-color: #ebd5c5;
}

.borrow-cover {
width: 75px;
height: 105px;
border-radius: 12px;
object-fit: cover;
border: 1px solid #ebd5c5;
flex-shrink: 0;
}

.borrow-details {
flex-grow: 1;
display: flex;
flex-direction: column;
}

.borrow-title {
font-size: 1.05rem;
font-weight: 700;
color: #2E2118;
margin: 0 0 4px 0;
display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
}

.borrow-author {
font-size: 0.85rem;
color: #8c7b70;
font-weight: 500;
margin: 0 0 12px 0;
}

.borrow-due {
font-size: 0.8rem;
background: #FFF2E8;
color: #E69C62;
padding: 6px 14px;
border-radius: 20px;
width: fit-content;
font-weight: 700;
display: inline-flex;
align-items: center;
gap: 6px;
}

/* Popular Borrow Badge */
.popular-badge {
position: absolute;
top: 12px;
right: 12px;
background: rgba(231, 76, 60, 0.9);
color: white;
padding: 5px 12px;
border-radius: 20px;
font-size: 0.75rem;
font-weight: 700;
z-index: 2;
box-shadow: 0 4px 8px rgba(231, 76, 60, 0.25);
display: inline-flex;
align-items: center;
gap: 5px;
}

.default-cover-svg {
width: 100%;
height: 100%;
}

/* ==================================== */
/* CAROUSEL STYLE                       */
/* ==================================== */
.paw-carousel-container {
position: relative;
width: 100%;
margin-bottom: 40px;
}

.paw-carousel-track-wrapper {
overflow: hidden;
width: 100%;
padding: 10px 0;
}

.paw-carousel-track {
display: flex;
transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
gap: 24px;
}

.paw-carousel-slide {
flex: 0 0 calc(33.333% - 16px);
box-sizing: border-box;
}

@media (max-width: 992px) {
.paw-carousel-slide {
flex: 0 0 calc(50% - 12px);
}
}

@media (max-width: 576px) {
.paw-carousel-slide {
flex: 0 0 100%;
}
}

.carousel-btn {
position: absolute;
top: 50%;
transform: translateY(-50%);
width: 48px;
height: 48px;
border-radius: 50%;
background: white;
border: 2px solid #f2e7dd;
color: #E69C62;
font-size: 1.1rem;
cursor: pointer;
display: flex;
align-items: center;
justify-content: center;
box-shadow: 0 4px 12px rgba(74, 60, 49, 0.08);
transition: all 0.2s ease;
z-index: 10;
}

.carousel-btn:hover {
background: #FFF9F3;
border-color: #E69C62;
color: #c8814a;
box-shadow: 0 6px 16px rgba(230, 156, 98, 0.15);
}

.prev-btn {
left: -24px;
}

.next-btn {
right: -24px;
}

.carousel-btn.disabled {
opacity: 0;
pointer-events: none;
}

/* Styling Search Card (Subtle & Lengkap) */
.paw-search-subtle-card {
background: #fffdfb;
border: 2px solid #f2e7dd;
border-radius: 20px;
padding: 16px 20px;
margin-bottom: 25px;
box-shadow: 0 4px 12px rgba(74, 60, 49, 0.02);
}

.paw-search-subtle-form {
display: flex;
gap: 12px;
align-items: center;
flex-wrap: wrap;
}

.paw-search-subtle-input {
padding: 10px 15px;
border-radius: 12px;
border: 2px solid #ebd5c5;
font-family: 'Quicksand', sans-serif;
font-weight: 600;
color: #4a3c31;
background-color: #ffffff;
transition: all 0.3s ease;
box-sizing: border-box;
font-size: 0.9rem;
height: 42px;
}

.paw-search-subtle-input:focus {
outline: none;
border-color: #E69C62 !important;
background-color: #ffffff !important;
box-shadow: 0 0 0 3px rgba(230, 156, 98, 0.12);
}

.btn-paw-subtle-search {
background: #E69C62;
color: white;
padding: 0 24px;
border: none;
border-radius: 12px;
font-family: 'Quicksand', sans-serif;
font-weight: bold;
cursor: pointer;
display: inline-flex;
align-items: center;
justify-content: center;
gap: 6px;
box-shadow: 0 3px 8px rgba(230,156,98,0.15);
transition: all 0.2s ease;
font-size: 0.9rem;
height: 42px;
}

.btn-paw-subtle-search:hover {
background: #c8814a;
transform: translateY(-1px);
}

/* Hero Carousel Styling */
.hero-carousel-container {
position: relative;
width: 100%;
margin-bottom: 25px;
border-radius: 28px;
overflow: hidden;
}

.hero-carousel-track {
display: flex;
transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
width: 100%;
}

.hero-carousel-slide {
flex: 0 0 100%;
width: 100%;
box-sizing: border-box;
margin-bottom: 0 !important;
display: flex !important;
align-items: center;
gap: 30px;
justify-content: space-between;
}

.hero-slide-content {
flex: 1;
}

/* News Slide Specifics */
.news-slide {
background: linear-gradient(135deg, #FFFDFB 0%, #F5EBE1 100%) !important;
}

.news-badge {
background: #FFF0E0;
color: #E69C62;
padding: 6px 14px;
border-radius: 20px;
font-size: 0.8rem;
font-weight: 700;
text-transform: uppercase;
display: inline-flex;
align-items: center;
gap: 6px;
margin-bottom: 12px;
border: 1px solid rgba(230, 156, 98, 0.2);
}

.news-title {
font-size: 22px !important;
line-height: 1.3 !important;
margin-top: 0 !important;
margin-bottom: 10px !important;
display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
height: 3.6rem;
color: #2E2118;
font-weight: 700;
}

.news-desc {
font-size: 0.95rem !important;
line-height: 1.4 !important;
color: #756456 !important;
display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
margin: 0 !important;
}

.news-date {
font-size: 0.8rem;
color: #8c7b70;
font-weight: 600;
display: inline-flex;
align-items: center;
gap: 5px;
}

.btn-news-read {
background: #E69C62;
color: white !important;
padding: 8px 16px;
border-radius: 12px;
font-size: 0.8rem;
font-weight: 700;
text-decoration: none !important;
display: inline-flex;
align-items: center;
gap: 6px;
box-shadow: 0 3px 8px rgba(230, 156, 98, 0.15);
transition: all 0.2s ease;
}

.btn-news-read:hover {
background: #c8814a;
transform: translateY(-1px);
}

.hero-slide-image-wrapper {
width: 220px;
height: 140px;
border-radius: 18px;
overflow: hidden;
flex-shrink: 0;
box-shadow: 0 6px 15px rgba(74, 60, 49, 0.08);
border: 2px solid #ebd5c5;
}

.hero-slide-image {
width: 100%;
height: 100%;
object-fit: cover;
}

/* Dots Navigation */
.hero-carousel-dots {
position: absolute;
bottom: 15px;
left: 50%;
transform: translateX(-50%);
display: flex;
gap: 8px;
z-index: 10;
}

.hero-dot {
width: 8px;
height: 8px;
border-radius: 50%;
background: rgba(140, 123, 112, 0.3);
cursor: pointer;
transition: all 0.3s ease;
}

.hero-dot.active {
background: #E69C62;
width: 20px;
border-radius: 10px;
}

.hero-dot-welcome {
width: 16px !important;
height: 16px !important;
background: transparent !important;
border-radius: 0 !important;
color: rgba(140, 123, 112, 0.4);
font-size: 14px;
display: inline-flex;
align-items: center;
justify-content: center;
margin-top: -4px; /* Align vertically with round dots */
}

.hero-dot-welcome.active {
color: #E69C62 !important;
transform: scale(1.25);
background: transparent !important;
width: 16px !important;
border-radius: 0 !important;
}

@media (max-width: 768px) {
.hero-slide-image-wrapper {
display: none;
}
.news-title {
font-size: 18px !important;
}
}
</style>

<div class="paw-container">
    
    <?php if ($role === 'admin'): ?>
        <!-- ========================================== -->
        <!-- DASHBOARD ADMIN PERPUSTAKAAN              -->
        <!-- ========================================== -->
        
        <!-- Hero & News Carousel Section (Admin) -->
        <div class="hero-carousel-container">
            <div class="hero-carousel-track">
                <!-- Slide 1: Welcome Banner -->
                <div class="hero-carousel-slide hero-box">
                    <div class="hero-slide-content">
                        <h1>Welcome back, Admin! 🐾</h1>
                        <p>Kelola seluruh koleksi dan aktivitas PawLib dengan mudah.</p>
                    </div>
                </div>

                <!-- Slides 2+: News Banners -->
                <?php if ($showNews): ?>
                    <?php foreach ($newsItems as $item): ?>
                        <div class="hero-carousel-slide hero-box news-slide">
                            <div class="hero-slide-content">
                                <span class="news-badge"><i class="far fa-newspaper"></i> <?= esc($item['source']) ?></span>
                                <h1 class="news-title" title="<?= esc($item['title']) ?>"><?= esc($item['title']) ?></h1>
                                <p class="news-desc"><?= esc($item['desc']) ?></p>
                                <div style="margin-top: 15px; display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                    <span class="news-date"><i class="far fa-clock"></i> <?= esc($item['date']) ?></span>
                                    <a href="<?= esc($item['link']) ?>" target="_blank" class="btn-news-read">
                                        Baca Selengkapnya <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                            <?php if (!empty($item['image'])): ?>
                                <div class="hero-slide-image-wrapper">
                                    <img src="<?= esc($item['image']) ?>" alt="Thumbnail Berita" class="hero-slide-image">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Carousel Pagination Dots -->
            <?php if ($showNews): ?>
                <div class="hero-carousel-dots">
                    <span class="hero-dot active hero-dot-welcome" data-slide="0"><i class="fas fa-paw"></i></span>
                    <?php foreach ($newsItems as $index => $item): ?>
                        <span class="hero-dot" data-slide="<?= $index + 1 ?>"></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Cards Statistik -->
        <div class="stats-grid">
            <!-- Total Buku -->
            <div class="stat-card">
                <div class="stat-icon-wrapper icon-purple">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-num"><?= $totalBuku ?></span>
                    <span class="stat-label">Total Buku</span>
                </div>
            </div>

            <!-- Total Anggota -->
            <div class="stat-card">
                <div class="stat-icon-wrapper icon-blue">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-num"><?= $totalAnggota ?></span>
                    <span class="stat-label">Total Anggota</span>
                </div>
            </div>

            <!-- Buku Sedang Dipinjam -->
            <div class="stat-card">
                <div class="stat-icon-wrapper icon-orange">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-num"><?= $totalDipinjam ?></span>
                    <span class="stat-label">Sedang Dipinjam</span>
                </div>
            </div>

            <!-- Total Denda -->
            <div class="stat-card">
                <div class="stat-icon-wrapper icon-green">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-num">Rp <?= number_format($totalDenda, 0, ',', '.') ?></span>
                    <span class="stat-label">Total Denda</span>
                </div>
            </div>
        </div>

        <!-- Section: Buku Paling Sering Dipinjam -->
        <h2><i class="fas fa-fire text-danger" style="color: #E74C3C;"></i> Buku Paling Sering Dipinjam</h2>
        <?php if (empty($bukuTerpopuler)): ?>
            <div class="empty-state-card">
                <div class="empty-state-icon"><i class="fas fa-book-open"></i></div>
                <p class="empty-state-text">Belum ada data aktivitas peminjaman buku.</p>
            </div>
        <?php else: ?>
            <?php if (count($bukuTerpopuler) > 3): ?>
                <!-- Render Carousel untuk Buku Terpopuler -->
                <div class="paw-carousel-container" id="carousel-popular">
                    <div class="paw-carousel-track-wrapper">
                        <div class="paw-carousel-track">
                            <?php foreach($bukuTerpopuler as $b): ?>
                                <?php 
                                    $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
                                    $coverPath = '/images/default_cover.svg';
                                    if (!empty($coverField)) {
                                        if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                            $coverPath = '/uploads/' . $coverField;
                                        } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                                            $coverPath = '/uploads/cover/' . $coverField;
                                        } else {
                                            $coverPath = '/uploads/' . $coverField; 
                                        }
                                    }
                                ?>
                                <div class="paw-carousel-slide">
                                    <div class="paw-card">
                                        <div class="paw-card-img-wrapper">
                                            <span class="popular-badge">
                                                <i class="fas fa-chart-line"></i> <?= $b['total_pinjam'] ?>x
                                            </span>
                                            <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                                <svg class="default-cover-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                                  <rect width="100%" height="100%" fill="#fff5ec"/>
                                                  <rect x="10" y="10" width="280" height="380" fill="none" stroke="#f2e7dd" stroke-width="2" rx="10"/>
                                                  <g transform="translate(150, 180)">
                                                    <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                                  </g>
                                                  <text x="150" y="270" font-family="'Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                                                </svg>
                                            <?php else: ?>
                                                <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                                            <?php endif; ?>
                                        </div>
                                        <div class="paw-card-body">
                                            <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                                            <p class="paw-book-author">Oleh: <?= esc($b['penulis']); ?></p>
                                            <div class="paw-actions">
                                                <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-paw btn-paw-secondary">
                                                    <i class="fas fa-book-open"></i> Detail
                                                </a>
                                                <a href="/buku/edit/<?= $b['id'] ?>" class="btn-paw btn-paw-primary" style="background-color: #4A90E2; box-shadow: 0 4px 10px rgba(74, 144, 226, 0.2);">
                                                    <i class="fas fa-cog"></i> Kelola
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button class="carousel-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
                    <button class="carousel-btn next-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
            <?php else: ?>
                <!-- Render normal Grid jika <= 3 -->
                <div class="paw-grid">
                    <?php foreach($bukuTerpopuler as $b): ?>
                        <?php 
                            $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
                            $coverPath = '/images/default_cover.svg';
                            if (!empty($coverField)) {
                                if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                    $coverPath = '/uploads/' . $coverField;
                                } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                                    $coverPath = '/uploads/cover/' . $coverField;
                                } else {
                                    $coverPath = '/uploads/' . $coverField; 
                                }
                            }
                        ?>
                        <div class="paw-card">
                            <div class="paw-card-img-wrapper">
                                <span class="popular-badge">
                                    <i class="fas fa-chart-line"></i> <?= $b['total_pinjam'] ?>x
                                </span>
                                <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                    <svg class="default-cover-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                      <rect width="100%" height="100%" fill="#fff5ec"/>
                                      <rect x="10" y="10" width="280" height="380" fill="none" stroke="#f2e7dd" stroke-width="2" rx="10"/>
                                      <g transform="translate(150, 180)">
                                        <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                                        <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                        <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                        <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                        <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                      </g>
                                      <text x="150" y="270" font-family="'Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                                    </svg>
                                <?php else: ?>
                                    <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                                <?php endif; ?>
                            </div>
                            <div class="paw-card-body">
                                <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                                <p class="paw-book-author">Oleh: <?= esc($b['penulis']); ?></p>
                                <div class="paw-actions">
                                    <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-paw btn-paw-secondary">
                                        <i class="fas fa-book-open"></i> Detail
                                    </a>
                                    <a href="/buku/edit/<?= $b['id'] ?>" class="btn-paw btn-paw-primary" style="background-color: #4A90E2; box-shadow: 0 4px 10px rgba(74, 144, 226, 0.2);">
                                        <i class="fas fa-cog"></i> Kelola
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Section: Statistik Koleksi Berdasarkan DDC -->
        <h2><i class="fas fa-chart-bar text-primary" style="color: #4A90E2;"></i> Statistik Koleksi Berdasarkan DDC</h2>
        <div class="ddc-stats-card">
            <div class="ddc-list">
                <?php foreach($ddcStats as $ds): ?>
                    <div class="ddc-item">
                        <div class="ddc-info">
                            <span class="ddc-code"><?= esc($ds['kode_ddc']) ?></span>
                            <span class="ddc-name"><?= esc($ds['nama_rak']) ?></span>
                        </div>
                        <span class="ddc-count"><?= $ds['jumlah_buku'] ?> buku</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- AKTIVITAS RATING & ULASAN TERBARU (ADMIN) -->
        <div class="row">
            <div class="col-md-6" style="margin-bottom: 25px;">
                <div class="activity-card" style="height: 100%; box-sizing: border-box; margin-bottom: 0;">
                    <h4 class="font-weight-bold mb-3" style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #2E2118; margin-top: 0; display: flex; align-items: center; gap: 8px;"><i class="fas fa-star" style="color: #F1C40F;"></i> Rating Terbaru</h4>
                    <?php if (empty($ratingTerbaru)): ?>
                        <p class="text-muted text-center py-4" style="margin: 0;">Belum ada aktivitas rating masuk.</p>
                    <?php else: ?>
                        <div class="activity-list">
                            <?php foreach ($ratingTerbaru as $rt): ?>
                                <div class="activity-item" style="padding-bottom: 12px; margin-bottom: 12px;">
                                    <div class="activity-details" style="font-size: 0.9rem;">
                                        <strong><?= esc($rt['nama_anggota']) ?></strong> menilai buku <strong>"<?= esc($rt['judul_buku']) ?>"</strong>
                                        <div style="color: #F1C40F; font-size: 0.85rem; margin-top: 4px;">
                                            <?= str_repeat('★', $rt['rating']) . str_repeat('☆', 5 - $rt['rating']) ?>
                                        </div>
                                    </div>
                                    <div class="activity-time">
                                        <i class="far fa-clock"></i> <?= date('d M Y', strtotime($rt['created_at'])) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-6" style="margin-bottom: 25px;">
                <div class="activity-card" style="height: 100%; box-sizing: border-box; margin-bottom: 0;">
                    <h4 class="font-weight-bold mb-3" style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #2E2118; margin-top: 0; display: flex; align-items: center; gap: 8px;"><i class="far fa-comments" style="color: #E69C62;"></i> Ulasan Terbaru</h4>
                    <?php if (empty($ulasanTerbaru)): ?>
                        <p class="text-muted text-center py-4" style="margin: 0;">Belum ada ulasan pembaca masuk.</p>
                    <?php else: ?>
                        <div class="activity-list">
                            <?php foreach ($ulasanTerbaru as $ut): ?>
                                <div class="activity-item" style="padding-bottom: 12px; margin-bottom: 12px;">
                                    <div class="activity-details" style="font-size: 0.9rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                            <strong><?= esc($ut['nama_anggota']) ?></strong>
                                            <span style="color: #F1C40F; font-size: 0.75rem;">
                                                <?= str_repeat('★', $ut['rating'] ?? 5) ?>
                                            </span>
                                        </div>
                                        <small class="text-muted" style="display: block; margin-top: 2px;">Buku: <strong>"<?= esc($ut['judul_buku']) ?>"</strong></small>
                                        <p style="margin: 6px 0 0 0; font-size: 0.8rem; color: #8c7b70; line-height: 1.4; font-style: italic;">
                                            "<?= strlen($ut['ulasan']) > 80 ? esc(substr($ut['ulasan'], 0, 80)) . '...' : esc($ut['ulasan']) ?>"
                                        </p>
                                    </div>
                                    <div class="activity-time">
                                        <i class="far fa-clock"></i> <?= date('d M Y', strtotime($ut['created_at'])) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 30px;"></div>

        <!-- Section: Aktivitas Perpustakaan Terbaru -->
        <h2><i class="fas fa-history text-warning" style="color: #E69C62;"></i> Aktivitas Perpustakaan Terbaru</h2>
        <div class="activity-card">
            <?php if (empty($aktivitasTerbaru)): ?>
                <div class="empty-state-card" style="border: none; padding: 15px; margin: 0;">
                    <div class="empty-state-icon" style="font-size: 30px;"><i class="fas fa-circle-info"></i></div>
                    <p class="empty-state-text" style="font-size: 0.95rem;">Belum ada riwayat aktivitas di perpustakaan saat ini.</p>
                </div>
            <?php else: ?>
                <div class="activity-list">
                    <?php foreach($aktivitasTerbaru as $at): ?>
                        <div class="activity-item">
                            <!-- Badge Status -->
                            <?php if (strtolower($at['status']) == 'dipinjam'): ?>
                                <span class="activity-badge badge-borrowed">
                                    <i class="fas fa-book"></i> Dipinjam
                                </span>
                            <?php else: ?>
                                <span class="activity-badge badge-returned">
                                    <i class="fas fa-check"></i> Kembali
                                </span>
                            <?php endif; ?>
                            
                            <!-- Rincian Aktivitas -->
                            <div class="activity-details">
                                Anggota <strong><?= esc($at['nama_anggota']) ?></strong> 
                                <?php if (strtolower($at['status']) == 'dipinjam'): ?>
                                    meminjam buku
                                <?php else: ?>
                                    mengembalikan buku
                                <?php endif; ?>
                                <strong>"<?= esc($at['judul_buku']) ?>"</strong>
                            </div>
                            
                            <!-- Batas Waktu / Tanggal Pinjam -->
                            <div class="activity-time">
                                <i class="far fa-clock"></i> 
                                <?= date('d M Y', strtotime(strtolower($at['status']) == 'dipinjam' ? $at['tanggal_pinjam'] : ($at['tanggal_dikembalikan'] ?? date('Y-m-d')))) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Section: Buku Terbaru -->
        <h2><i class="fas fa-clock text-info" style="color: #3498DB;"></i> Buku Terbaru</h2>
        <?php if (empty($bukuTerbaru)): ?>
            <div class="empty-state-card">
                <div class="empty-state-icon"><i class="fas fa-book"></i></div>
                <p class="empty-state-text">Belum ada buku yang didaftarkan.</p>
            </div>
        <?php else: ?>
            <?php if (count($bukuTerbaru) > 3): ?>
                <!-- Render Carousel untuk Buku Terbaru -->
                <div class="paw-carousel-container" id="carousel-new-admin">
                    <div class="paw-carousel-track-wrapper">
                        <div class="paw-carousel-track">
                            <?php foreach($bukuTerbaru as $b): ?>
                                <?php 
                                    $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
                                    $coverPath = '/images/default_cover.svg';
                                    if (!empty($coverField)) {
                                        if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                            $coverPath = '/uploads/' . $coverField;
                                        } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                                            $coverPath = '/uploads/cover/' . $coverField;
                                        } else {
                                            $coverPath = '/uploads/' . $coverField; 
                                        }
                                    }
                                ?>
                                <div class="paw-carousel-slide">
                                    <div class="paw-card">
                                        <div class="paw-card-img-wrapper">
                                            <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                                <svg class="default-cover-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                                  <rect width="100%" height="100%" fill="#fff5ec"/>
                                                  <rect x="10" y="10" width="280" height="380" fill="none" stroke="#f2e7dd" stroke-width="2" rx="10"/>
                                                  <g transform="translate(150, 180)">
                                                    <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                                  </g>
                                                  <text x="150" y="270" font-family="'Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                                                </svg>
                                            <?php else: ?>
                                                <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                                            <?php endif; ?>
                                        </div>
                                        <div class="paw-card-body">
                                            <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                                            <p class="paw-book-author">Oleh: <?= esc($b['penulis']); ?></p>
                                            
                                            <div class="paw-actions">
                                                <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-paw btn-paw-secondary">
                                                    <i class="fas fa-book-open"></i> Detail
                                                </a>
                                                <a href="/buku/edit/<?= $b['id'] ?>" class="btn-paw btn-paw-primary" style="background-color: #4A90E2; box-shadow: 0 4px 10px rgba(74, 144, 226, 0.2);">
                                                    <i class="fas fa-cog"></i> Kelola
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button class="carousel-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
                    <button class="carousel-btn next-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
            <?php else: ?>
                <div class="paw-grid">
                    <?php foreach($bukuTerbaru as $b): ?>
                        <?php 
                            $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
                            $coverPath = '/images/default_cover.svg';
                            if (!empty($coverField)) {
                                if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                    $coverPath = '/uploads/' . $coverField;
                                } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                                    $coverPath = '/uploads/cover/' . $coverField;
                                } else {
                                    $coverPath = '/uploads/' . $coverField; 
                                }
                            }
                        ?>
                        <div class="paw-card">
                            <div class="paw-card-img-wrapper">
                                <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                    <svg class="default-cover-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                      <rect width="100%" height="100%" fill="#fff5ec"/>
                                      <rect x="10" y="10" width="280" height="380" fill="none" stroke="#f2e7dd" stroke-width="2" rx="10"/>
                                      <g transform="translate(150, 180)">
                                        <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                                        <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                        <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                        <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                        <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                      </g>
                                      <text x="150" y="270" font-family="'Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                                    </svg>
                                <?php else: ?>
                                    <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                                <?php endif; ?>
                            </div>
                            <div class="paw-card-body">
                                <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                                <p class="paw-book-author">Oleh: <?= esc($b['penulis']); ?></p>
                                
                                <div class="paw-actions">
                                    <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-paw btn-paw-secondary">
                                        <i class="fas fa-book-open"></i> Detail
                                    </a>
                                    <a href="/buku/edit/<?= $b['id'] ?>" class="btn-paw btn-paw-primary" style="background-color: #4A90E2; box-shadow: 0 4px 10px rgba(74, 144, 226, 0.2);">
                                        <i class="fas fa-cog"></i> Kelola
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    <?php else: ?>
        <!-- ========================================== -->
        <!-- DASHBOARD ANGGOTA PERPUSTAKAAN            -->
        <!-- ========================================== -->
        
        <!-- Hero & News Carousel Section -->
        <div class="hero-carousel-container">
            <div class="hero-carousel-track">
                <!-- Slide 1: Welcome Banner -->
                <div class="hero-carousel-slide hero-box">
                    <div class="hero-slide-content">
                        <h1>Welcome to PawLib 🐾</h1>
                        <p>Temukan buku favoritmu dan nikmati pengalaman membaca yang nyaman.</p>
                    </div>
                </div>

                <!-- Slides 2+: News Banners -->
                <?php if ($showNews): ?>
                    <?php foreach ($newsItems as $item): ?>
                        <div class="hero-carousel-slide hero-box news-slide">
                            <div class="hero-slide-content">
                                <span class="news-badge"><i class="far fa-newspaper"></i> <?= esc($item['source']) ?></span>
                                <h1 class="news-title" title="<?= esc($item['title']) ?>"><?= esc($item['title']) ?></h1>
                                <p class="news-desc"><?= esc($item['desc']) ?></p>
                                <div style="margin-top: 15px; display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                    <span class="news-date"><i class="far fa-clock"></i> <?= esc($item['date']) ?></span>
                                    <a href="<?= esc($item['link']) ?>" target="_blank" class="btn-news-read">
                                        Baca Selengkapnya <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                            <?php if (!empty($item['image'])): ?>
                                <div class="hero-slide-image-wrapper">
                                    <img src="<?= esc($item['image']) ?>" alt="Thumbnail Berita" class="hero-slide-image">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Carousel Pagination Dots -->
            <?php if ($showNews): ?>
                <div class="hero-carousel-dots">
                    <span class="hero-dot active hero-dot-welcome" data-slide="0"><i class="fas fa-paw"></i></span>
                    <?php foreach ($newsItems as $index => $item): ?>
                        <span class="hero-dot" data-slide="<?= $index + 1 ?>"></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Standalone Subtle Search Card (Lengkap) -->
        <?php
            $db = \Config\Database::connect();
            // Fetch languages
            $standardLanguages = ['Indonesia', 'Inggris', 'Arab', 'Mandarin', 'Jepang', 'Korea', 'Jerman', 'Prancis'];
            $dbLanguages = $db->table('buku')
                              ->select('bahasa')
                              ->where('bahasa IS NOT NULL')
                              ->where("bahasa != ''")
                              ->distinct()
                              ->get()
                              ->getResultArray();
            
            $languages = $standardLanguages;
            foreach ($dbLanguages as $row) {
                $lang = trim($row['bahasa']);
                if ($lang !== '' && !in_array($lang, $languages)) {
                    $languages[] = $lang;
                }
            }
            sort($languages);
            
            // Fetch DDC rak
            $rakList = $db->table('rak')->orderBy('kode_ddc', 'ASC')->get()->getResultArray();
        ?>
        <div class="paw-search-subtle-card">
            <form action="/katalog" method="get" class="paw-search-subtle-form">
                <!-- Input Keyword -->
                <div style="flex: 2 1 250px; position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #8c7b70; opacity: 0.6; font-size: 0.85rem;"></i>
                    <input type="text" name="keyword" class="paw-search-subtle-input" placeholder="Cari judul, penulis..." style="width: 100%; padding-left: 36px;">
                </div>

                <!-- Dropdown Filter Type -->
                <select id="dash_filter_type_select" class="paw-search-subtle-input" style="flex: 1 1 180px;">
                    <option value="">🔍 Filter Berdasarkan</option>
                    <option value="bahasa">🌐 Bahasa</option>
                    <option value="jenis_koleksi">📚 Jenis Koleksi</option>
                    <option value="ddc">📂 Klasifikasi DDC</option>
                </select>

                <!-- Dropdown Bahasa -->
                <select name="bahasa" id="dash_filter_bahasa_select" class="paw-search-subtle-input" style="display: none; flex: 1 1 180px;" disabled>
                    <option value="">Pilih Bahasa</option>
                    <?php foreach ($languages as $lang): ?>
                        <option value="<?= esc($lang) ?>">🌐 <?= esc($lang) ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Dropdown Jenis Koleksi -->
                <select name="jenis_koleksi" id="dash_filter_jenis_select" class="paw-search-subtle-input" style="display: none; flex: 1 1 180px;" disabled>
                    <option value="">Pilih Jenis</option>
                    <option value="fisik">📚 Buku Fisik</option>
                    <option value="ebook">📱 E-Book</option>
                </select>

                <!-- Dropdown DDC -->
                <select name="ddc" id="dash_filter_ddc_select" class="paw-search-subtle-input" style="display: none; flex: 1 1 200px;" disabled>
                    <option value="">Pilih Klasifikasi DDC</option>
                    <?php foreach($rakList as $r): ?>
                        <option value="<?= $r['id'] ?>">
                            📂 <?= esc($r['kode_ddc']) ?> - <?= esc($r['nama_rak']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Tombol Submit -->
                <button type="submit" class="btn-paw-subtle-search" style="flex: 0 1 auto;">
                    <i class="fas fa-paw"></i> Cari
                </button>
            </form>
        </div>

        <!-- Quotes Section -->
        <div class="paw-quote-card">
            <div class="paw-quote-icon">
                <i class="fas fa-quote-left"></i>
            </div>
            <div class="paw-quote-content">
                <p class="paw-quote-text">"<?= $selectedQuote['text'] ?>"</p>
                <span class="paw-quote-author">— <?= $selectedQuote['author'] ?></span>
            </div>
        </div>

        <!-- Section: Rekomendasi Buku -->
        <h2><i class="fas fa-star text-warning" style="color: #F1C40F;"></i> Rekomendasi Buku</h2>
        <?php if (empty($rekomendasi)): ?>
            <div class="empty-state-card">
                <div class="empty-state-icon"><i class="fas fa-book-open"></i></div>
                <p class="empty-state-text">Belum ada rekomendasi buku saat ini.</p>
            </div>
        <?php else: ?>
            <?php if (count($rekomendasi) > 3): ?>
                <!-- Render Carousel untuk Rekomendasi Buku -->
                <div class="paw-carousel-container" id="carousel-recommend">
                    <div class="paw-carousel-track-wrapper">
                        <div class="paw-carousel-track">
                            <?php foreach($rekomendasi as $b): ?>
                                <div class="paw-carousel-slide">
                                    <?php 
                                        $db = \Config\Database::connect();
                                        $rak = null;
                                        if (!empty($b['rak_id'])) {
                                            $rak = $db->table('rak')->where('id', $b['rak_id'])->get()->getRowArray();
                                        }
                                        
                                        // Fetch Rating Info
                                        $ratingInfo = $db->table('rating_buku')
                                                         ->select('COUNT(id) as total_rating, AVG(rating) as rata_rata')
                                                         ->where('buku_id', $b['id'])
                                                         ->get()
                                                         ->getRowArray();
                                        $totalRating = (int)($ratingInfo['total_rating'] ?? 0);
                                        $ratingRataRata = $totalRating > 0 ? number_format((float)$ratingInfo['rata_rata'], 1, '.', '') : '0';

                                        // Path cover
                                        $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
                                        $coverPath = '/images/default_cover.svg';
                                        if (!empty($coverField)) {
                                            if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                                $coverPath = '/uploads/' . $coverField;
                                            } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                                                $coverPath = '/uploads/cover/' . $coverField;
                                            } else {
                                                $coverPath = '/uploads/' . $coverField; 
                                            }
                                        }
                                        $stok = (int)$b['stok'];
                                    ?>
                                    <div class="paw-card">
                                        <div class="paw-card-img-wrapper">
                                            <!-- Tombol Favorit (Tampil Hanya untuk Anggota yang Login) -->
                                            <?php if (session()->get('role') == 'anggota'): ?>
                                                <a href="/favorit/toggle/<?= $b['id'] ?>" class="paw-favorite-btn <?= in_array($b['id'], $favoritIds) ? 'favorited' : '' ?>" title="Favorit">
                                                    <i class="fas fa-heart"></i>
                                                </a>
                                                
                                                <?php if (in_array($b['id'], $wishlistIds)): ?>
                                                    <a href="javascript:void(0);" class="paw-wishlist-btn saved" title="Tersimpan di Wishlist" style="cursor: default;">
                                                        <i class="fas fa-star"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="/wishlist/tambah/<?= $b['id'] ?>" class="paw-wishlist-btn" title="Tambah ke Wishlist">
                                                        <i class="fas fa-star"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                                <span class="paw-status-badge" style="background-color: #ffe8d6; color: #a0522d; border: 1px solid rgba(160, 82, 45, 0.15);">
                                                    <i class="fas fa-mobile-alt mr-1"></i> E-Book
                                                </span>
                                            <?php elseif ($stok > 0): ?>
                                                <span class="paw-status-badge badge-tersedia">
                                                    <i class="fas fa-book mr-1"></i> Buku Fisik (<?= $stok ?>)
                                                </span>
                                            <?php else: ?>
                                                <span class="paw-status-badge badge-habis">
                                                    <i class="fas fa-times-circle mr-1"></i> Habis
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                                <svg class="default-cover-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                                  <rect width="100%" height="100%" fill="#fff5ec"/>
                                                  <rect x="10" y="10" width="280" height="380" fill="none" stroke="#f2e7dd" stroke-width="2" rx="10"/>
                                                  <g transform="translate(150, 180)">
                                                    <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                                  </g>
                                                  <text x="150" y="270" font-family="'Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                                                  <text x="150" y="290" font-family="'Quicksand', sans-serif" font-size="11" fill="#c0b3a7" text-anchor="middle" font-weight="600">No Cover</text>
                                                </svg>
                                            <?php else: ?>
                                                <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                                            <?php endif; ?>
                                        </div>
                                        <div class="paw-card-body">
                                            <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                                            <p class="paw-book-author" style="margin-bottom: 10px;">Oleh: <?= esc($b['penulis']); ?></p>

                                            <!-- Rating & Statistik Row -->
                                            <div style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem; font-weight: 700; color: #8c7b70; margin-bottom: 12px; border-top: 1px dashed #f2e7dd; padding-top: 10px; margin-top: auto;">
                                                <span style="display: flex; align-items: center; gap: 4px;">
                                                    <i class="fas fa-star" style="color: #F1C40F;"></i> 
                                                    <?= $ratingRataRata ?>/5.0 (<?= $totalRating ?>)
                                                </span>
                                                <span style="color: #ebd5c5;">|</span>
                                                <span style="display: flex; align-items: center; gap: 4px;">
                                                    <i class="fas fa-eye" style="color: #e07a5f;"></i> 
                                                    <?= esc($b['dibaca_count'] ?? 0) ?> Kali
                                                </span>
                                            </div>
                                        </div>
                                        <div class="paw-card-footer">
                                            <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-action btn-action-detail">
                                                <i class="fas fa-info-circle"></i> Detail
                                            </a>
                                            <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                                <a href="/ebook/baca/<?= $b['id'] ?>" class="btn-action btn-action-pinjam" style="background: #e07a5f; box-shadow: 0 4px 10px rgba(224, 122, 95, 0.15);">
                                                    <i class="fas fa-book-open"></i> Baca Sekarang
                                                </a>
                                            <?php elseif ($stok > 0): ?>
                                                <a href="/peminjaman/tambah/<?= $b['id'] ?>" class="btn-action btn-action-pinjam">
                                                    <i class="fas fa-paw"></i> Pinjam
                                                </a>
                                            <?php else: ?>
                                                <button class="btn-action btn-action-pinjam" disabled>
                                                    <i class="fas fa-paw"></i> Habis
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
<?php endforeach; ?>
                        </div>
                    </div>
                    <button class="carousel-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
                    <button class="carousel-btn next-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
            <?php else: ?>
                <div class="paw-grid">
                    <?php foreach($rekomendasi as $b): ?>
                            <?php 
                                $db = \Config\Database::connect();
                                $rak = null;
                                if (!empty($b['rak_id'])) {
                                    $rak = $db->table('rak')->where('id', $b['rak_id'])->get()->getRowArray();
                                }
                                
                                // Fetch Rating Info
                                $ratingInfo = $db->table('rating_buku')
                                                 ->select('COUNT(id) as total_rating, AVG(rating) as rata_rata')
                                                 ->where('buku_id', $b['id'])
                                                 ->get()
                                                 ->getRowArray();
                                $totalRating = (int)($ratingInfo['total_rating'] ?? 0);
                                $ratingRataRata = $totalRating > 0 ? number_format((float)$ratingInfo['rata_rata'], 1, '.', '') : '0';

                                // Path cover
                                $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
                                $coverPath = '/images/default_cover.svg';
                                if (!empty($coverField)) {
                                    if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                        $coverPath = '/uploads/' . $coverField;
                                    } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                                        $coverPath = '/uploads/cover/' . $coverField;
                                    } else {
                                        $coverPath = '/uploads/' . $coverField; 
                                    }
                                }
                                $stok = (int)$b['stok'];
                            ?>
                            <div class="paw-card">
                                <div class="paw-card-img-wrapper">
                                    <!-- Tombol Favorit (Tampil Hanya untuk Anggota yang Login) -->
                                    <?php if (session()->get('role') == 'anggota'): ?>
                                        <a href="/favorit/toggle/<?= $b['id'] ?>" class="paw-favorite-btn <?= in_array($b['id'], $favoritIds) ? 'favorited' : '' ?>" title="Favorit">
                                            <i class="fas fa-heart"></i>
                                        </a>
                                        
                                        <?php if (in_array($b['id'], $wishlistIds)): ?>
                                            <a href="javascript:void(0);" class="paw-wishlist-btn saved" title="Tersimpan di Wishlist" style="cursor: default;">
                                                <i class="fas fa-star"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="/wishlist/tambah/<?= $b['id'] ?>" class="paw-wishlist-btn" title="Tambah ke Wishlist">
                                                <i class="fas fa-star"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                        <span class="paw-status-badge" style="background-color: #ffe8d6; color: #a0522d; border: 1px solid rgba(160, 82, 45, 0.15);">
                                            <i class="fas fa-mobile-alt mr-1"></i> E-Book
                                        </span>
                                    <?php elseif ($stok > 0): ?>
                                        <span class="paw-status-badge badge-tersedia">
                                            <i class="fas fa-book mr-1"></i> Buku Fisik (<?= $stok ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="paw-status-badge badge-habis">
                                            <i class="fas fa-times-circle mr-1"></i> Habis
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                        <svg class="default-cover-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                          <rect width="100%" height="100%" fill="#fff5ec"/>
                                          <rect x="10" y="10" width="280" height="380" fill="none" stroke="#f2e7dd" stroke-width="2" rx="10"/>
                                          <g transform="translate(150, 180)">
                                            <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                          </g>
                                          <text x="150" y="270" font-family="'Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                                          <text x="150" y="290" font-family="'Quicksand', sans-serif" font-size="11" fill="#c0b3a7" text-anchor="middle" font-weight="600">No Cover</text>
                                        </svg>
                                    <?php else: ?>
                                        <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                                    <?php endif; ?>
                                </div>
                                <div class="paw-card-body">
                                    <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                                    <p class="paw-book-author" style="margin-bottom: 10px;">Oleh: <?= esc($b['penulis']); ?></p>

                                    <!-- Rating & Statistik Row -->
                                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem; font-weight: 700; color: #8c7b70; margin-bottom: 12px; border-top: 1px dashed #f2e7dd; padding-top: 10px; margin-top: auto;">
                                        <span style="display: flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-star" style="color: #F1C40F;"></i> 
                                            <?= $ratingRataRata ?>/5.0 (<?= $totalRating ?>)
                                        </span>
                                        <span style="color: #ebd5c5;">|</span>
                                        <span style="display: flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-eye" style="color: #e07a5f;"></i> 
                                            <?= esc($b['dibaca_count'] ?? 0) ?> Kali
                                        </span>
                                    </div>
                                </div>
                                <div class="paw-card-footer">
                                    <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-action btn-action-detail">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                        <a href="/ebook/baca/<?= $b['id'] ?>" class="btn-action btn-action-pinjam" style="background: #e07a5f; box-shadow: 0 4px 10px rgba(224, 122, 95, 0.15);">
                                            <i class="fas fa-book-open"></i> Baca Sekarang
                                        </a>
                                    <?php elseif ($stok > 0): ?>
                                        <a href="/peminjaman/tambah/<?= $b['id'] ?>" class="btn-action btn-action-pinjam">
                                            <i class="fas fa-paw"></i> Pinjam
                                        </a>
                                    <?php else: ?>
                                        <button class="btn-action btn-action-pinjam" disabled>
                                            <i class="fas fa-paw"></i> Habis
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
<?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Section: Koleksi Terbaru -->
        <h2><i class="fas fa-sparkles" style="color: #E69C62;"></i> Koleksi Terbaru</h2>
        <?php if (empty($koleksiTerbaru)): ?>
            <div class="empty-state-card">
                <div class="empty-state-icon"><i class="fas fa-book"></i></div>
                <p class="empty-state-text">Belum ada buku baru ditambahkan.</p>
            </div>
        <?php else: ?>
            <?php if (count($koleksiTerbaru) > 3): ?>
                <!-- Render Carousel untuk Koleksi Terbaru -->
                <div class="paw-carousel-container" id="carousel-new-anggota">
                    <div class="paw-carousel-track-wrapper">
                        <div class="paw-carousel-track">
                            <?php foreach($koleksiTerbaru as $b): ?>
                                <div class="paw-carousel-slide">
                                    <?php 
                                        $db = \Config\Database::connect();
                                        $rak = null;
                                        if (!empty($b['rak_id'])) {
                                            $rak = $db->table('rak')->where('id', $b['rak_id'])->get()->getRowArray();
                                        }
                                        
                                        // Fetch Rating Info
                                        $ratingInfo = $db->table('rating_buku')
                                                         ->select('COUNT(id) as total_rating, AVG(rating) as rata_rata')
                                                         ->where('buku_id', $b['id'])
                                                         ->get()
                                                         ->getRowArray();
                                        $totalRating = (int)($ratingInfo['total_rating'] ?? 0);
                                        $ratingRataRata = $totalRating > 0 ? number_format((float)$ratingInfo['rata_rata'], 1, '.', '') : '0';

                                        // Path cover
                                        $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
                                        $coverPath = '/images/default_cover.svg';
                                        if (!empty($coverField)) {
                                            if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                                $coverPath = '/uploads/' . $coverField;
                                            } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                                                $coverPath = '/uploads/cover/' . $coverField;
                                            } else {
                                                $coverPath = '/uploads/' . $coverField; 
                                            }
                                        }
                                        $stok = (int)$b['stok'];
                                    ?>
                                    <div class="paw-card">
                                        <div class="paw-card-img-wrapper">
                                            <!-- Tombol Favorit (Tampil Hanya untuk Anggota yang Login) -->
                                            <?php if (session()->get('role') == 'anggota'): ?>
                                                <a href="/favorit/toggle/<?= $b['id'] ?>" class="paw-favorite-btn <?= in_array($b['id'], $favoritIds) ? 'favorited' : '' ?>" title="Favorit">
                                                    <i class="fas fa-heart"></i>
                                                </a>
                                                
                                                <?php if (in_array($b['id'], $wishlistIds)): ?>
                                                    <a href="javascript:void(0);" class="paw-wishlist-btn saved" title="Tersimpan di Wishlist" style="cursor: default;">
                                                        <i class="fas fa-star"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="/wishlist/tambah/<?= $b['id'] ?>" class="paw-wishlist-btn" title="Tambah ke Wishlist">
                                                        <i class="fas fa-star"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                                <span class="paw-status-badge" style="background-color: #ffe8d6; color: #a0522d; border: 1px solid rgba(160, 82, 45, 0.15);">
                                                    <i class="fas fa-mobile-alt mr-1"></i> E-Book
                                                </span>
                                            <?php elseif ($stok > 0): ?>
                                                <span class="paw-status-badge badge-tersedia">
                                                    <i class="fas fa-book mr-1"></i> Buku Fisik (<?= $stok ?>)
                                                </span>
                                            <?php else: ?>
                                                <span class="paw-status-badge badge-habis">
                                                    <i class="fas fa-times-circle mr-1"></i> Habis
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                                <svg class="default-cover-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                                  <rect width="100%" height="100%" fill="#fff5ec"/>
                                                  <rect x="10" y="10" width="280" height="380" fill="none" stroke="#f2e7dd" stroke-width="2" rx="10"/>
                                                  <g transform="translate(150, 180)">
                                                    <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                                    <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                                  </g>
                                                  <text x="150" y="270" font-family="'Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                                                  <text x="150" y="290" font-family="'Quicksand', sans-serif" font-size="11" fill="#c0b3a7" text-anchor="middle" font-weight="600">No Cover</text>
                                                </svg>
                                            <?php else: ?>
                                                <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                                            <?php endif; ?>
                                        </div>
                                        <div class="paw-card-body">
                                            <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                                            <p class="paw-book-author" style="margin-bottom: 10px;">Oleh: <?= esc($b['penulis']); ?></p>

                                            <!-- Rating & Statistik Row -->
                                            <div style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem; font-weight: 700; color: #8c7b70; margin-bottom: 12px; border-top: 1px dashed #f2e7dd; padding-top: 10px; margin-top: auto;">
                                                <span style="display: flex; align-items: center; gap: 4px;">
                                                    <i class="fas fa-star" style="color: #F1C40F;"></i> 
                                                    <?= $ratingRataRata ?>/5.0 (<?= $totalRating ?>)
                                                </span>
                                                <span style="color: #ebd5c5;">|</span>
                                                <span style="display: flex; align-items: center; gap: 4px;">
                                                    <i class="fas fa-eye" style="color: #e07a5f;"></i> 
                                                    <?= esc($b['dibaca_count'] ?? 0) ?> Kali
                                                </span>
                                            </div>
                                        </div>
                                        <div class="paw-card-footer">
                                            <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-action btn-action-detail">
                                                <i class="fas fa-info-circle"></i> Detail
                                            </a>
                                            <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                                <a href="/ebook/baca/<?= $b['id'] ?>" class="btn-action btn-action-pinjam" style="background: #e07a5f; box-shadow: 0 4px 10px rgba(224, 122, 95, 0.15);">
                                                    <i class="fas fa-book-open"></i> Baca Sekarang
                                                </a>
                                            <?php elseif ($stok > 0): ?>
                                                <a href="/peminjaman/tambah/<?= $b['id'] ?>" class="btn-action btn-action-pinjam">
                                                    <i class="fas fa-paw"></i> Pinjam
                                                </a>
                                            <?php else: ?>
                                                <button class="btn-action btn-action-pinjam" disabled>
                                                    <i class="fas fa-paw"></i> Habis
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
<?php endforeach; ?>
                        </div>
                    </div>
                    <button class="carousel-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
                    <button class="carousel-btn next-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
            <?php else: ?>
                <div class="paw-grid">
                    <?php foreach($koleksiTerbaru as $b): ?>
                            <?php 
                                $db = \Config\Database::connect();
                                $rak = null;
                                if (!empty($b['rak_id'])) {
                                    $rak = $db->table('rak')->where('id', $b['rak_id'])->get()->getRowArray();
                                }
                                
                                // Fetch Rating Info
                                $ratingInfo = $db->table('rating_buku')
                                                 ->select('COUNT(id) as total_rating, AVG(rating) as rata_rata')
                                                 ->where('buku_id', $b['id'])
                                                 ->get()
                                                 ->getRowArray();
                                $totalRating = (int)($ratingInfo['total_rating'] ?? 0);
                                $ratingRataRata = $totalRating > 0 ? number_format((float)$ratingInfo['rata_rata'], 1, '.', '') : '0';

                                // Path cover
                                $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
                                $coverPath = '/images/default_cover.svg';
                                if (!empty($coverField)) {
                                    if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                        $coverPath = '/uploads/' . $coverField;
                                    } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                                        $coverPath = '/uploads/cover/' . $coverField;
                                    } else {
                                        $coverPath = '/uploads/' . $coverField; 
                                    }
                                }
                                $stok = (int)$b['stok'];
                            ?>
                            <div class="paw-card">
                                <div class="paw-card-img-wrapper">
                                    <!-- Tombol Favorit (Tampil Hanya untuk Anggota yang Login) -->
                                    <?php if (session()->get('role') == 'anggota'): ?>
                                        <a href="/favorit/toggle/<?= $b['id'] ?>" class="paw-favorite-btn <?= in_array($b['id'], $favoritIds) ? 'favorited' : '' ?>" title="Favorit">
                                            <i class="fas fa-heart"></i>
                                        </a>
                                        
                                        <?php if (in_array($b['id'], $wishlistIds)): ?>
                                            <a href="javascript:void(0);" class="paw-wishlist-btn saved" title="Tersimpan di Wishlist" style="cursor: default;">
                                                <i class="fas fa-star"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="/wishlist/tambah/<?= $b['id'] ?>" class="paw-wishlist-btn" title="Tambah ke Wishlist">
                                                <i class="fas fa-star"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                        <span class="paw-status-badge" style="background-color: #ffe8d6; color: #a0522d; border: 1px solid rgba(160, 82, 45, 0.15);">
                                            <i class="fas fa-mobile-alt mr-1"></i> E-Book
                                        </span>
                                    <?php elseif ($stok > 0): ?>
                                        <span class="paw-status-badge badge-tersedia">
                                            <i class="fas fa-book mr-1"></i> Buku Fisik (<?= $stok ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="paw-status-badge badge-habis">
                                            <i class="fas fa-times-circle mr-1"></i> Habis
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                        <svg class="default-cover-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                          <rect width="100%" height="100%" fill="#fff5ec"/>
                                          <rect x="10" y="10" width="280" height="380" fill="none" stroke="#f2e7dd" stroke-width="2" rx="10"/>
                                          <g transform="translate(150, 180)">
                                            <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                          </g>
                                          <text x="150" y="270" font-family="'Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                                          <text x="150" y="290" font-family="'Quicksand', sans-serif" font-size="11" fill="#c0b3a7" text-anchor="middle" font-weight="600">No Cover</text>
                                        </svg>
                                    <?php else: ?>
                                        <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                                    <?php endif; ?>
                                </div>
                                <div class="paw-card-body">
                                    <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                                    <p class="paw-book-author" style="margin-bottom: 10px;">Oleh: <?= esc($b['penulis']); ?></p>

                                    <!-- Rating & Statistik Row -->
                                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem; font-weight: 700; color: #8c7b70; margin-bottom: 12px; border-top: 1px dashed #f2e7dd; padding-top: 10px; margin-top: auto;">
                                        <span style="display: flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-star" style="color: #F1C40F;"></i> 
                                            <?= $ratingRataRata ?>/5.0 (<?= $totalRating ?>)
                                        </span>
                                        <span style="color: #ebd5c5;">|</span>
                                        <span style="display: flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-eye" style="color: #e07a5f;"></i> 
                                            <?= esc($b['dibaca_count'] ?? 0) ?> Kali
                                        </span>
                                    </div>
                                </div>
                                <div class="paw-card-footer">
                                    <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-action btn-action-detail">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                        <a href="/ebook/baca/<?= $b['id'] ?>" class="btn-action btn-action-pinjam" style="background: #e07a5f; box-shadow: 0 4px 10px rgba(224, 122, 95, 0.15);">
                                            <i class="fas fa-book-open"></i> Baca Sekarang
                                        </a>
                                    <?php elseif ($stok > 0): ?>
                                        <a href="/peminjaman/tambah/<?= $b['id'] ?>" class="btn-action btn-action-pinjam">
                                            <i class="fas fa-paw"></i> Pinjam
                                        </a>
                                    <?php else: ?>
                                        <button class="btn-action btn-action-pinjam" disabled>
                                            <i class="fas fa-paw"></i> Habis
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
<?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Section: Buku Favorit Saya -->
        <h2><i class="fas fa-heart text-danger" style="color: #E74C3C;"></i> Buku Favorit Saya</h2>
        <?php if (empty($favoritSaya)): ?>
            <div class="empty-state-card">
                <div class="empty-state-icon"><i class="fas fa-heart-broken" style="color: #ebd5c5;"></i></div>
                <p class="empty-state-text">Belum ada buku favorit. Yuk jelajahi katalog dan simpan buku yang kamu sukai!</p>
            </div>
        <?php else: ?>
            <div class="paw-grid">
                <?php foreach($favoritSaya as $b): ?>
                            <?php 
                                $db = \Config\Database::connect();
                                $rak = null;
                                if (!empty($b['rak_id'])) {
                                    $rak = $db->table('rak')->where('id', $b['rak_id'])->get()->getRowArray();
                                }
                                
                                // Fetch Rating Info
                                $ratingInfo = $db->table('rating_buku')
                                                 ->select('COUNT(id) as total_rating, AVG(rating) as rata_rata')
                                                 ->where('buku_id', $b['id'])
                                                 ->get()
                                                 ->getRowArray();
                                $totalRating = (int)($ratingInfo['total_rating'] ?? 0);
                                $ratingRataRata = $totalRating > 0 ? number_format((float)$ratingInfo['rata_rata'], 1, '.', '') : '0';

                                // Path cover
                                $coverField = !empty($b['foto']) ? $b['foto'] : (!empty($b['cover']) ? $b['cover'] : '');
                                $coverPath = '/images/default_cover.svg';
                                if (!empty($coverField)) {
                                    if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                        $coverPath = '/uploads/' . $coverField;
                                    } elseif (file_exists(FCPATH . 'uploads/cover/' . $coverField)) {
                                        $coverPath = '/uploads/cover/' . $coverField;
                                    } else {
                                        $coverPath = '/uploads/' . $coverField; 
                                    }
                                }
                                $stok = (int)$b['stok'];
                            ?>
                            <div class="paw-card">
                                <div class="paw-card-img-wrapper">
                                    <!-- Tombol Favorit (Tampil Hanya untuk Anggota yang Login) -->
                                    <?php if (session()->get('role') == 'anggota'): ?>
                                        <a href="/favorit/toggle/<?= $b['id'] ?>" class="paw-favorite-btn <?= in_array($b['id'], $favoritIds) ? 'favorited' : '' ?>" title="Favorit">
                                            <i class="fas fa-heart"></i>
                                        </a>
                                        
                                        <?php if (in_array($b['id'], $wishlistIds)): ?>
                                            <a href="javascript:void(0);" class="paw-wishlist-btn saved" title="Tersimpan di Wishlist" style="cursor: default;">
                                                <i class="fas fa-star"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="/wishlist/tambah/<?= $b['id'] ?>" class="paw-wishlist-btn" title="Tambah ke Wishlist">
                                                <i class="fas fa-star"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                        <span class="paw-status-badge" style="background-color: #ffe8d6; color: #a0522d; border: 1px solid rgba(160, 82, 45, 0.15);">
                                            <i class="fas fa-mobile-alt mr-1"></i> E-Book
                                        </span>
                                    <?php elseif ($stok > 0): ?>
                                        <span class="paw-status-badge badge-tersedia">
                                            <i class="fas fa-book mr-1"></i> Buku Fisik (<?= $stok ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="paw-status-badge badge-habis">
                                            <i class="fas fa-times-circle mr-1"></i> Habis
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($coverPath == '/images/default_cover.svg'): ?>
                                        <svg class="default-cover-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400">
                                          <rect width="100%" height="100%" fill="#fff5ec"/>
                                          <rect x="10" y="10" width="280" height="380" fill="none" stroke="#f2e7dd" stroke-width="2" rx="10"/>
                                          <g transform="translate(150, 180)">
                                            <path d="M -20 10 C -20 -5, -10 -15, 0 -15 C 10 -15, 20 -5, 20 10 C 20 20, 10 25, 0 25 C -10 25, -20 20, -20 10 Z" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="-20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="-7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="7" cy="-28" r="8" fill="#E69C62" opacity="0.6"/>
                                            <circle cx="20" cy="-20" r="7" fill="#E69C62" opacity="0.6"/>
                                          </g>
                                          <text x="150" y="270" font-family="'Quicksand', sans-serif" font-weight="bold" font-size="16" fill="#8c7b70" text-anchor="middle">PAWLIB</text>
                                          <text x="150" y="290" font-family="'Quicksand', sans-serif" font-size="11" fill="#c0b3a7" text-anchor="middle" font-weight="600">No Cover</text>
                                        </svg>
                                    <?php else: ?>
                                        <img src="<?= $coverPath ?>" alt="<?= esc($b['judul']); ?>" class="paw-card-img">
                                    <?php endif; ?>
                                </div>
                                <div class="paw-card-body">
                                    <h5 class="paw-book-title" title="<?= esc($b['judul']); ?>"><?= esc($b['judul']); ?></h5>
                                    <p class="paw-book-author" style="margin-bottom: 10px;">Oleh: <?= esc($b['penulis']); ?></p>

                                    <!-- Rating & Statistik Row -->
                                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem; font-weight: 700; color: #8c7b70; margin-bottom: 12px; border-top: 1px dashed #f2e7dd; padding-top: 10px; margin-top: auto;">
                                        <span style="display: flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-star" style="color: #F1C40F;"></i> 
                                            <?= $ratingRataRata ?>/5.0 (<?= $totalRating ?>)
                                        </span>
                                        <span style="color: #ebd5c5;">|</span>
                                        <span style="display: flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-eye" style="color: #e07a5f;"></i> 
                                            <?= esc($b['dibaca_count'] ?? 0) ?> Kali
                                        </span>
                                    </div>
                                </div>
                                <div class="paw-card-footer">
                                    <a href="/katalog/detail/<?= $b['id'] ?>" class="btn-action btn-action-detail">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </a>
                                    <?php if (isset($b['jenis_koleksi']) && $b['jenis_koleksi'] === 'ebook'): ?>
                                        <a href="/ebook/baca/<?= $b['id'] ?>" class="btn-action btn-action-pinjam" style="background: #e07a5f; box-shadow: 0 4px 10px rgba(224, 122, 95, 0.15);">
                                            <i class="fas fa-book-open"></i> Baca Sekarang
                                        </a>
                                    <?php elseif ($stok > 0): ?>
                                        <a href="/peminjaman/tambah/<?= $b['id'] ?>" class="btn-action btn-action-pinjam">
                                            <i class="fas fa-paw"></i> Pinjam
                                        </a>
                                    <?php else: ?>
                                        <button class="btn-action btn-action-pinjam" disabled>
                                            <i class="fas fa-paw"></i> Habis
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
<?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Section: Sedang Dipinjam -->
        <h2><i class="fas fa-book-reader text-warning" style="color: #F1C40F;"></i> Sedang Dipinjam</h2>
        <?php if (empty($sedangDipinjam)): ?>
            <div class="empty-state-card">
                <div class="empty-state-icon"><i class="far fa-face-smile" style="color: #ebd5c5;"></i></div>
                <p class="empty-state-text">Kamu tidak memiliki peminjaman aktif saat ini. Yuk cari buku menarik untuk dibaca! 🐾</p>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px;">
                <?php foreach($sedangDipinjam as $sp): ?>
                    <?php 
                        $coverField = !empty($sp['foto']) ? $sp['foto'] : (!empty($sp['cover']) ? $sp['cover'] : '');
                        $coverPath = '/images/default_cover.svg';
                        if (!empty($coverField)) {
                            if (file_exists(FCPATH . 'uploads/' . $coverField)) {
                                $coverPath = '/uploads/' . $coverField;
                            } elseif (file_exists(FCPATH . 'uploads/cover/' . $sp['cover'])) {
                                $coverPath = '/uploads/cover/' . $sp['cover'];
                            } else {
                                $coverPath = '/uploads/' . $coverField; 
                            }
                        }
                    ?>
                    <div class="borrow-card">
                        <?php if ($coverPath == '/images/default_cover.svg'): ?>
                            <div class="borrow-cover" style="display:flex; align-items:center; justify-content:center; background:#fff5ec;">
                                <i class="fas fa-paw" style="color:#E69C62; font-size:24px;"></i>
                            </div>
                        <?php else: ?>
                            <img src="<?= $coverPath ?>" alt="<?= esc($sp['judul']) ?>" class="borrow-cover">
                        <?php endif; ?>
                        
                        <div class="borrow-details">
                            <h5 class="borrow-title" title="<?= esc($sp['judul']) ?>"><?= esc($sp['judul']) ?></h5>
                            <p class="borrow-author">Oleh: <?= esc($sp['penulis']) ?></p>
                            <span class="borrow-due">
                                <i class="far fa-calendar-alt"></i> Kembali: <?= date('d M Y', strtotime($sp['tanggal_kembali'])) ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>

</div>

<!-- Vanilla JS Carousel logic -->
<script>
function initCarousels() {
    const carousels = document.querySelectorAll('.paw-carousel-container');
    carousels.forEach(container => {
        const track = container.querySelector('.paw-carousel-track');
        const slides = container.querySelectorAll('.paw-carousel-slide');
        const prevBtn = container.querySelector('.prev-btn');
        const nextBtn = container.querySelector('.next-btn');
        
        if (!track || slides.length === 0 || !prevBtn || !nextBtn) return;
        
        let index = 0;
        
        function updateCarousel() {
            // Lebar item + gap
            const slideWidth = slides[0].getBoundingClientRect().width;
            const gap = 24; 
            
            // Tentukan jumlah item yang muat di layar
            let itemsToShow = 3;
            if (window.innerWidth <= 576) {
                itemsToShow = 1;
            } else if (window.innerWidth <= 992) {
                itemsToShow = 2;
            }
            
            const maxIndex = slides.length - itemsToShow;
            if (index < 0) index = 0;
            if (index > maxIndex) index = maxIndex;
            
            // Pergeseran track
            const amountToMove = index * (slideWidth + gap);
            track.style.transform = `translateX(-${amountToMove}px)`;
            
            // Toggle status tombol disabled
            if (index === 0) {
                prevBtn.classList.add('disabled');
            } else {
                prevBtn.classList.remove('disabled');
            }
            
            if (index >= maxIndex) {
                nextBtn.classList.add('disabled');
            } else {
                nextBtn.classList.remove('disabled');
            }
        }
        
        prevBtn.addEventListener('click', () => {
            if (index > 0) {
                index--;
                updateCarousel();
            }
        });
        
        nextBtn.addEventListener('click', () => {
            let itemsToShow = 3;
            if (window.innerWidth <= 576) {
                itemsToShow = 1;
            } else if (window.innerWidth <= 992) {
                itemsToShow = 2;
            }
            const maxIndex = slides.length - itemsToShow;
            if (index < maxIndex) {
                index++;
                updateCarousel();
            }
        });
        
        window.addEventListener('resize', updateCarousel);
        updateCarousel();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initCarousels();
    initHeroCarousel();
    
    // JS Logic untuk form pencarian lengkap di Dashboard
    const dashTypeSelect = document.getElementById('dash_filter_type_select');
    if (dashTypeSelect) {
        const dashBahasaSelect = document.getElementById('dash_filter_bahasa_select');
        const dashJenisSelect = document.getElementById('dash_filter_jenis_select');
        const dashDdcSelect = document.getElementById('dash_filter_ddc_select');

        function updateDashFilterDropdowns() {
            const selectedType = dashTypeSelect.value;

            // Sembunyikan & nonaktifkan semua dulu
            if (dashBahasaSelect) { dashBahasaSelect.style.display = 'none'; dashBahasaSelect.disabled = true; }
            if (dashJenisSelect) { dashJenisSelect.style.display = 'none'; dashJenisSelect.disabled = true; }
            if (dashDdcSelect) { dashDdcSelect.style.display = 'none'; dashDdcSelect.disabled = true; }

            // Tampilkan & aktifkan sub-filter yang dipilih
            if (selectedType === 'bahasa' && dashBahasaSelect) {
                dashBahasaSelect.style.display = 'inline-block';
                dashBahasaSelect.disabled = false;
            } else if (selectedType === 'jenis_koleksi' && dashJenisSelect) {
                dashJenisSelect.style.display = 'inline-block';
                dashJenisSelect.disabled = false;
            } else if (selectedType === 'ddc' && dashDdcSelect) {
                dashDdcSelect.style.display = 'inline-block';
                dashDdcSelect.disabled = false;
            }
        }

        dashTypeSelect.addEventListener('change', function() {
            // Reset nilai saat pilihan kategori filter berubah
            if (dashBahasaSelect) dashBahasaSelect.value = '';
            if (dashJenisSelect) dashJenisSelect.value = '';
            if (dashDdcSelect) dashDdcSelect.value = '';
            updateDashFilterDropdowns();
        });

        // Inisialisasi awal
        updateDashFilterDropdowns();
    }
});

// Carousel Logic untuk Welcome & News Banner di Dashboard
function initHeroCarousel() {
    const container = document.querySelector('.hero-carousel-container');
    if (!container) return;

    const track = container.querySelector('.hero-carousel-track');
    const slides = container.querySelectorAll('.hero-carousel-slide');
    const dots = container.querySelectorAll('.hero-dot');
    
    if (!track || slides.length <= 1) return;

    let currentSlide = 0;
    const slideCount = slides.length;
    let autoPlayInterval;

    function goToSlide(index) {
        currentSlide = index;
        if (currentSlide < 0) currentSlide = slideCount - 1;
        if (currentSlide >= slideCount) currentSlide = 0;

        track.style.transform = `translateX(-${currentSlide * 100}%)`;

        // Update dots
        dots.forEach((dot, idx) => {
            if (idx === currentSlide) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function startAutoPlay() {
        clearInterval(autoPlayInterval); // Bersihkan interval yang ada agar tidak menumpuk/double
        autoPlayInterval = setInterval(() => {
            goToSlide(currentSlide + 1);
        }, 7000); // Geser setiap 7 detik
    }

    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    // Set listener untuk tombol navigasi bulatan
    dots.forEach((dot, idx) => {
        dot.addEventListener('click', () => {
            stopAutoPlay();
            goToSlide(idx);
            startAutoPlay();
        });
    });

    // Pause saat mouse masuk, play kembali saat mouse keluar
    container.addEventListener('mouseenter', stopAutoPlay);
    container.addEventListener('mouseleave', startAutoPlay);

    // Navigasi dengan Touch Swipe untuk HP
    let startX = 0;
    let isSwiping = false;

    container.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isSwiping = true;
        stopAutoPlay();
    }, { passive: true });

    container.addEventListener('touchend', (e) => {
        if (!isSwiping) return;
        const endX = e.changedTouches[0].clientX;
        const diffX = startX - endX;

        if (Math.abs(diffX) > 50) {
            if (diffX > 0) {
                goToSlide(currentSlide + 1);
            } else {
                goToSlide(currentSlide - 1);
            }
        }
        isSwiping = false;
        startAutoPlay();
    }, { passive: true });

    // Mulai Auto Play
    startAutoPlay();
}
</script>

<?= $this->include('layout/footer'); ?>