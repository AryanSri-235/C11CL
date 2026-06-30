<?php
ini_set('display_errors', 0);
error_reporting(0);
include '../db.php';

$images = [];
if ($con) {
    $stmt = $con->prepare("SELECT image_url, caption FROM gallery ORDER BY sort_order ASC, id ASC");
    if ($stmt) {
        $stmt->execute();
        $r = $stmt->get_result();
        while ($row = $r->fetch_assoc()) { $images[] = $row; }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Relive the Excitement of C11CL Matches and Special Moments</title>
<meta name="robots" content="index,follow">
<meta name="description" content="In this gallery, explore captivating photographs from matches, events, and unforgettable moments that capture the spirit of C11CL – Champions 11 Cricket League">
<meta name="keywords" content="Champions 11 Cricket League photos, cricket league highlights, cricket league gallery, cricket match moments">
<link rel="canonical" href="https://c11clchampionscricketleague.infinityfree.net/gallery/">
<link rel="icon" href="/wp-content/uploads/2025/05/favicon-3.png">
<style>
/* Page layout */
body { margin: 0; padding: 0; background: #fff; font-family: 'Segoe UI', Roboto, Arial, sans-serif; }

/* Page intro block */
.gallery-intro {
    text-align: center;
    padding: 36px 20px 10px;
    background: #fff;
}
.gallery-league-name {
    font-size: 0.82rem;
    font-weight: 700;
    color: #111;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin: 0 0 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
}
.gallery-league-name .line {
    height: 1px;
    width: 28px;
    background: #ccc;
    display: inline-block;
}
.gallery-breadcrumb {
    font-size: 0.72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #999;
    margin-bottom: 22px;
}
.gallery-breadcrumb a {
    color: #999;
    text-decoration: none;
}
.gallery-breadcrumb a:hover { color: #e31e24; }
.gallery-breadcrumb .sep {
    color: #e31e24;
    margin: 0 8px;
    font-weight: 700;
    font-size: 0.6rem;
}

/* Main heading */
.gallery-heading {
    font-size: clamp(2rem, 5vw, 2.8rem);
    font-weight: 900;
    color: #1a1a1a;
    margin: 0 0 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    line-height: 1.1;
}
.gallery-heading span { color: #e31e24; }

.gallery-divider {
    width: 52px;
    height: 4px;
    background: #e31e24;
    margin: 0 auto 18px;
    border-radius: 2px;
}
.gallery-subtitle {
    color: #666;
    font-size: 1rem;
    max-width: 520px;
    margin: 0 auto 36px;
    line-height: 1.65;
}

/* Grid */
.gallery-grid-wrap {
    max-width: 1150px;
    margin: 0 auto;
    padding: 0 20px 60px;
}
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}
.gal-item {
    position: relative;
    overflow: hidden;
    border-radius: 4px;
    background: #111;
    height: 220px;
    cursor: pointer;
}
.gal-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    opacity: 0.92;
    transition: transform 0.35s ease, opacity 0.3s ease;
}
.gal-item:hover img {
    transform: scale(1.06);
    opacity: 1;
}

/* Lightbox */
#galleryModal {
    display: none;
    position: fixed;
    z-index: 10000;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.92);
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
#galleryModal.open { display: flex; }
#lb-close {
    position: fixed;
    top: 16px; right: 22px;
    color: #fff;
    font-size: 38px;
    cursor: pointer;
    line-height: 1;
    background: none;
    border: none;
    opacity: 0.85;
    z-index: 10001;
}
#lb-close:hover { opacity: 1; }
#modalImg {
    max-width: 92vw;
    max-height: 74vh;
    object-fit: contain;
    border: 2px solid #333;
    border-radius: 3px;
}
.lb-controls {
    display: flex;
    gap: 24px;
    margin-top: 22px;
}
.lb-btn {
    background: transparent;
    color: #fff;
    border: 1px solid #e31e24;
    padding: 8px 22px;
    cursor: pointer;
    border-radius: 2px;
    font-size: 0.9rem;
    transition: background 0.2s;
}
.lb-btn.next-btn { background: #e31e24; border-color: #e31e24; }
.lb-btn:hover { background: #c41a1a; border-color: #c41a1a; }
#imageCaption {
    color: #999;
    margin-top: 14px;
    font-size: 0.9rem;
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .gallery-grid { grid-template-columns: repeat(2, 1fr); }
    .gal-item { height: 160px; }
}
@media (max-width: 480px) {
    .gallery-grid { grid-template-columns: 1fr; }
    .gal-item { height: 200px; }
}
</style>
</head>
<body>

<?php include '../head.php'; ?>

<!-- Intro Section -->
<div class="gallery-intro">
    <h2 class="gallery-league-name">
        <span class="line"></span>
        Champions 11 Cricket League
        <span class="line"></span>
    </h2>
    <nav class="gallery-breadcrumb">
        <a href="/">Home</a>
        <span class="sep">•</span>
        <span>Our Gallery</span>
    </nav>
    <h1 class="gallery-heading">Our <span>Gallery</span></h1>
    <div class="gallery-divider"></div>
    <p class="gallery-subtitle">Captured on the field, cherished off it. Relive the moments that made history.</p>
</div>

<!-- Image Grid -->
<div class="gallery-grid-wrap">
    <div class="gallery-grid" id="c11-gallery-grid">
        <?php if (empty($images)): ?>
            <p style="grid-column:1/-1;text-align:center;color:#888;padding:40px 0;">No images found.</p>
        <?php else: ?>
            <?php foreach ($images as $i => $img): ?>
            <div class="gal-item" onclick="openLightbox(<?php echo $i; ?>)">
                <img src="<?php echo htmlspecialchars($img['image_url']); ?>"
                     alt="<?php echo htmlspecialchars($img['caption']); ?>"
                     loading="<?php echo $i < 3 ? 'eager' : 'lazy'; ?>"
                     onerror="this.closest('.gal-item').style.display='none'">
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Lightbox -->
<div id="galleryModal">
    <button id="lb-close" onclick="closeLightbox()">&times;</button>
    <img id="modalImg" src="" alt="">
    <div class="lb-controls">
        <button class="lb-btn" onclick="changeImage(-1)">&#8592; Prev</button>
        <button class="lb-btn next-btn" onclick="changeImage(1)">Next &#8594;</button>
    </div>
    <p id="imageCaption"></p>
</div>

<script>
const imgs = document.querySelectorAll('#c11-gallery-grid img');
let cur = 0;

function openLightbox(i) {
    cur = i;
    document.getElementById('modalImg').src = imgs[cur].src;
    document.getElementById('imageCaption').innerText = imgs[cur].alt;
    document.getElementById('galleryModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('galleryModal').classList.remove('open');
    document.getElementById('modalImg').src = '';
    document.body.style.overflow = '';
}
function changeImage(step) {
    cur = (cur + step + imgs.length) % imgs.length;
    document.getElementById('modalImg').src = imgs[cur].src;
    document.getElementById('imageCaption').innerText = imgs[cur].alt;
}
document.addEventListener('keydown', e => {
    if (!document.getElementById('galleryModal').classList.contains('open')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') changeImage(1);
    if (e.key === 'ArrowLeft') changeImage(-1);
});
document.getElementById('galleryModal').addEventListener('click', function(e) {
    if (e.target === this) closeLightbox();
});
</script>

<?php include '../foot.php'; ?>
</body>
</html>
