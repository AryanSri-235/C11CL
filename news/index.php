<?php
include "../db.php";

// URL se slug lo aur extra slashes hatao
$slug = $_GET['slug'] ?? '';
$slug = trim($slug, '/'); // Ye "slug-name/" ko "slug-name" bana dega

if (empty($slug)) {
    // Default slug agar URL khali ho
    $slug = 'rise-of-women-inclusive-cricket-india';
}

$sql = "SELECT * FROM blog WHERE slug = ? LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

if (!$blog) {
    header("HTTP/1.1 404 Not Found");
    echo "<h1>Post Not Found!</h1>";
    exit;
}
?>



<!DOCTYPE html>
<html lang="en-US" prefix="og: https://ogp.me/ns#" prefix="og: http://ogp.me/ns#">

<!-- Mirrored from c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Mar 2026 16:54:27 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<meta charset="UTF-8">
<title><?php echo $blog['meta_title']; ?></title>


<!-- SEO by Squirrly SEO 12.4.15 - https://plugin.squirrly.co/ -->
<meta name="robots" content="<?php echo $blog['robots'] ?: 'index,follow'; ?>">
<meta name="googlebot" content="<?php echo $blog['robots'] ?: 'index,follow'; ?>,max-snippet:-1,max-image-preview:large,max-video-preview:-1">
<meta name="bingbot" content="<?php echo $blog['robots'] ?: 'index,follow'; ?>,max-snippet:-1,max-image-preview:large,max-video-preview:-1">

<meta name="description" content="<?php echo addslashes($blog['meta_desc']); ?>" />
<link rel="canonical" href="<?php echo $blog['canonical_url']; ?>"/>
<link rel="alternate" type="application/rss+xml" href="../sitemap.xml" />

<meta name="dc.language" content="en" />
<meta name="dc.publisher" content="<?php echo $blog['author']; ?>" />
<meta name="dc.title" content="<?php echo $blog['meta_title']; ?>" />
<meta name="dc.description" content="<?php echo addslashes($blog['meta_desc']); ?>" />
<meta name="dc.date.issued" content="<?php echo date('Y-m-d', strtotime($blog['publish_date'])); ?>" />
<meta name="dc.date.updated" content="<?php echo date('Y-m-d H:i:s', strtotime($blog['created_at'])); ?>" />

<meta property="og:url" content="https://c11cl.com/blog/<?php echo $blog['slug']; ?>" />
<meta property="og:title" content="<?php echo $blog['og_title'] ?: $blog['meta_title']; ?>" />
<meta property="og:description" content="<?php echo addslashes($blog['og_desc'] ?: $blog['meta_desc']); ?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="https://c11cl.com/admin/<?php echo $blog['og_img'] ?: $blog['featured_img']; ?>" />
<meta property="og:site_name" content="C11CL" />
<meta property="og:locale" content="en_US" />
<meta property="article:published_time" content="<?php echo date('c', strtotime($blog['publish_date'])); ?>" />
<meta property="article:section" content="<?php echo $blog['category']; ?>" />
<meta property="article:author" content="<?php echo $blog['author']; ?>" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?php echo $blog['og_title'] ?: $blog['meta_title']; ?>" />
<meta name="twitter:description" content="<?php echo addslashes($blog['og_desc'] ?: $blog['meta_desc']); ?>" />
<meta name="twitter:image" content="https://c11cl.com/admin/<?php echo $blog['og_img'] ?: $blog['featured_img']; ?>" />
<meta name="twitter:site" content="@champions11cl" />

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "NewsArticle",
      "headline": "<?php echo addslashes($blog['title']); ?>",
      "description": "<?php echo addslashes($blog['meta_desc']); ?>",
      "datePublished": "<?php echo date('c', strtotime($blog['publish_date'])); ?>",
      "dateModified": "<?php echo date('c', strtotime($blog['created_at'])); ?>",
      "image": {
        "@type": "ImageObject",
        "url": "https://c11cl.com/admin/<?php echo $blog['featured_img']; ?>"
      },
      "author": {
        "@type": "Person",
        "name": "<?php echo $blog['author']; ?>",
        "url": "https://c11cl.com/author/<?php echo strtolower(str_replace(' ', '-', $blog['author'])); ?>/"
      },
      "publisher": {
        "@type": "Organization",
        "name": "C11CL",
        "logo": {
          "@type": "ImageObject",
          "url": "https://c11cl.com/wp-content/uploads/2025/05/favicon-2.png"
        }
      }
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://c11cl.com"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "<?php echo $blog['category']; ?>",
          "item": "https://c11cl.com/category/<?php echo strtolower(str_replace(' ', '-', $blog['category'])); ?>/"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "<?php echo addslashes($blog['title']); ?>"
        }
      ]
    }
  ]
}
</script>

<?php if(!empty($blog['schema_markup'])): ?>
    <?php echo $blog['schema_markup']; ?>
<?php endif; ?>
<!-- /SEO by Squirrly SEO - WordPress SEO Plugin -->




<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11"> 
	
<!-- Search Engine Optimization by Rank Math - https://rankmath.com/ -->

<script type="application/ld+json" class="rank-math-schema">{"@context":"https://schema.org","@graph":[{"@type":"Organization","@id":"https://c11cl.com/#organization","name":"C11CL","url":"https://c11cl.com","logo":{"@type":"ImageObject","@id":"https://c11cl.com/#logo","url":"https://c11cl.com/wp-content/uploads/2025/05/favicon-2.png","contentUrl":"https://c11cl.com/wp-content/uploads/2025/05/favicon-2.png","caption":"C11CL","inLanguage":"en-US","width":"675","height":"675"}},{"@type":"WebSite","@id":"https://c11cl.com/#website","url":"https://c11cl.com","name":"C11CL","publisher":{"@id":"https://c11cl.com/#organization"},"inLanguage":"en-US"},{"@type":"ImageObject","@id":"https://c11cl.com/wp-content/uploads/2026/02/Leagues-are-changing-Indian-Cricket.jpeg","url":"https://c11cl.com/wp-content/uploads/2026/02/Leagues-are-changing-Indian-Cricket.jpeg","width":"986","height":"422","caption":"Leagues Are Changing Indian Cricket","inLanguage":"en-US"},{"@type":"BreadcrumbList","@id":"https://c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/#breadcrumb","itemListElement":[{"@type":"ListItem","position":"1","item":{"@id":"https://c11cl.com","name":"Home"}},{"@type":"ListItem","position":"2","item":{"@id":"https://c11cl.com/category/c11cl-news/","name":"C11CL News"}},{"@type":"ListItem","position":"3","item":{"@id":"https://c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/","name":"The Business of Cricket: How Leagues Are Changing India\u2019s Sports Landscape"}}]},{"@type":"WebPage","@id":"https://c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/#webpage","url":"https://c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/","name":"The Business of Cricket: How Leagues Are Changing India\u2019s Sports Landscape - C11CL","datePublished":"2026-02-11T07:05:11+00:00","dateModified":"2026-02-11T07:08:36+00:00","isPartOf":{"@id":"https://c11cl.com/#website"},"primaryImageOfPage":{"@id":"https://c11cl.com/wp-content/uploads/2026/02/Leagues-are-changing-Indian-Cricket.jpeg"},"inLanguage":"en-US","breadcrumb":{"@id":"https://c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/#breadcrumb"}},{"@type":"Person","@id":"https://c11cl.com/author/c11cl/","name":"Admin","url":"https://c11cl.com/author/c11cl/","image":{"@type":"ImageObject","@id":"https://secure.gravatar.com/avatar/a833c98732ae0e331220d26a43190bef527592bd2ec99864de06a77e392e9368?s=96&amp;d=mm&amp;r=g","url":"https://secure.gravatar.com/avatar/a833c98732ae0e331220d26a43190bef527592bd2ec99864de06a77e392e9368?s=96&amp;d=mm&amp;r=g","caption":"Admin","inLanguage":"en-US"},"worksFor":{"@id":"https://c11cl.com/#organization"}},{"@type":"BlogPosting","headline":"The Business of Cricket: How Leagues Are Changing India\u2019s Sports Landscape - C11CL","datePublished":"2026-02-11T07:05:11+00:00","dateModified":"2026-02-11T07:08:36+00:00","articleSection":"C11CL News","author":{"@id":"https://c11cl.com/author/c11cl/","name":"Admin"},"publisher":{"@id":"https://c11cl.com/#organization"},"description":"Cricket League India boosts the gentleman\u2019s game development not only in India but also abroad. It offers financial support and global opportunities for emerging talents.","name":"The Business of Cricket: How Leagues Are Changing India\u2019s Sports Landscape - C11CL","@id":"https://c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/#richSnippet","isPartOf":{"@id":"https://c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/#webpage"},"image":{"@id":"https://c11cl.com/wp-content/uploads/2026/02/Leagues-are-changing-Indian-Cricket.jpeg"},"inLanguage":"en-US","mainEntityOfPage":{"@id":"https://c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/#webpage"}}]}</script>
<!-- /Rank Math WordPress SEO plugin -->

<link rel='dns-prefetch' href='http://fonts.googleapis.com/' />
<link rel="alternate" type="application/rss+xml" title="C11CL &raquo; Feed" href="../feed/index.html" />
<link rel="alternate" type="application/rss+xml" title="C11CL &raquo; Comments Feed" href="../comments/feed/index.html" />
<link rel="alternate" type="application/rss+xml" title="C11CL &raquo; The Business of Cricket: How Leagues Are Changing India’s Sports Landscape Comments Feed" href="feed/index.html" />
<link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed" href="../wp-json/oembed/1.0/embed3e55.html?url=https%3A%2F%2Fc11cl.com%2Fthe-business-of-cricket-how-leagues-are-changing-indias-sports-landscape%2F" />
<link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed" href="../wp-json/oembed/1.0/embed9d90.html?url=https%3A%2F%2Fc11cl.com%2Fthe-business-of-cricket-how-leagues-are-changing-indias-sports-landscape%2F&amp;format=xml" />
<style id='wp-img-auto-sizes-contain-inline-css'>
img:is([sizes=auto i],[sizes^="auto," i]){contain-intrinsic-size:3000px 1500px}
/*# sourceURL=wp-img-auto-sizes-contain-inline-css */
</style>

<link rel='stylesheet' id='elementor-frontend-css' href='../wp-content/plugins/elementor/assets/css/frontend.min5be5.css?ver=3.35.3' media='all' />
<link rel='stylesheet' id='elementor-post-1240-css' href='../wp-content/uploads/elementor/css/post-12409f0d.css?ver=1770644316' media='all' />
<link rel='stylesheet' id='elementor-post-1400-css' href='../wp-content/uploads/elementor/css/post-14009f0d.css?ver=1770644316' media='all' />
<link rel='stylesheet' id='astra-theme-css-css' href='../wp-content/themes/astra/assets/css/minified/main.minb925.css?ver=4.12.0' media='all' />
<style id='astra-theme-css-inline-css'>
:root{--ast-post-nav-space:0;--ast-container-default-xlg-padding:6.67em;--ast-container-default-lg-padding:5.67em;--ast-container-default-slg-padding:4.34em;--ast-container-default-md-padding:3.34em;--ast-container-default-sm-padding:6.67em;--ast-container-default-xs-padding:2.4em;--ast-container-default-xxs-padding:1.4em;--ast-code-block-background:#EEEEEE;--ast-comment-inputs-background:#FAFAFA;--ast-normal-container-width:1200px;--ast-narrow-container-width:750px;--ast-blog-title-font-weight:normal;--ast-blog-meta-weight:inherit;--ast-global-color-primary:var(--ast-global-color-5);--ast-global-color-secondary:var(--ast-global-color-4);--ast-global-color-alternate-background:var(--ast-global-color-7);--ast-global-color-subtle-background:var(--ast-global-color-6);--ast-bg-style-guide:var( --ast-global-color-secondary,--ast-global-color-5 );--ast-shadow-style-guide:0px 0px 4px 0 #00000057;--ast-global-dark-bg-style:#fff;--ast-global-dark-lfs:#fbfbfb;--ast-widget-bg-color:#fafafa;--ast-wc-container-head-bg-color:#fbfbfb;--ast-title-layout-bg:#eeeeee;--ast-search-border-color:#e7e7e7;--ast-lifter-hover-bg:#e6e6e6;--ast-gallery-block-color:#000;--srfm-color-input-label:var(--ast-global-color-2);}html{font-size:100%;}a,.page-title{color:var(--ast-global-color-2);}a:hover,a:focus{color:var(--ast-global-color-1);}body,button,input,select,textarea,.ast-button,.ast-custom-button{font-family:'Lato',sans-serif;font-weight:400;font-size:16px;font-size:1rem;line-height:var(--ast-body-line-height,1.65em);}blockquote{color:var(--ast-global-color-3);}p,.entry-content p{margin-bottom:1em;}h1,h2,h3,h4,h5,h6,.entry-content :where(h1,h2,h3,h4,h5,h6),.site-title,.site-title a{font-family:'Heebo',sans-serif;font-weight:700;line-height:1em;}.site-title{font-size:35px;font-size:2.1875rem;display:none;}header .custom-logo-link img{max-width:120px;width:120px;}.astra-logo-svg{width:120px;}.site-header .site-description{font-size:15px;font-size:0.9375rem;display:none;}.entry-title{font-size:26px;font-size:1.625rem;}.archive .ast-article-post .ast-article-inner,.blog .ast-article-post .ast-article-inner,.archive .ast-article-post .ast-article-inner:hover,.blog .ast-article-post .ast-article-inner:hover{overflow:hidden;}h1,.entry-content :where(h1){font-size:80px;font-size:5rem;font-weight:500;font-family:'Heebo',sans-serif;line-height:1em;}h2,.entry-content :where(h2){font-size:48px;font-size:3rem;font-weight:500;font-family:'Heebo',sans-serif;line-height:1em;}h3,.entry-content :where(h3){font-size:32px;font-size:2rem;font-weight:500;font-family:'Heebo',sans-serif;line-height:1em;}h4,.entry-content :where(h4){font-size:22px;font-size:1.375rem;line-height:1.2em;font-family:'Heebo',sans-serif;}h5,.entry-content :where(h5){font-size:18px;font-size:1.125rem;line-height:1.2em;font-family:'Heebo',sans-serif;}h6,.entry-content :where(h6){font-size:13px;font-size:0.8125rem;line-height:1.25em;font-family:'Heebo',sans-serif;}::selection{background-color:var(--ast-global-color-0);color:#ffffff;}body,h1,h2,h3,h4,h5,h6,.entry-title a,.entry-content :where(h1,h2,h3,h4,h5,h6){color:var(--ast-global-color-3);}.tagcloud a:hover,.tagcloud a:focus,.tagcloud a.current-item{color:#ffffff;border-color:var(--ast-global-color-2);background-color:var(--ast-global-color-2);}input:focus,input[type="text"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="password"]:focus,input[type="reset"]:focus,input[type="search"]:focus,textarea:focus{border-color:var(--ast-global-color-2);}input[type="radio"]:checked,input[type=reset],input[type="checkbox"]:checked,input[type="checkbox"]:hover:checked,input[type="checkbox"]:focus:checked,input[type=range]::-webkit-slider-thumb{border-color:var(--ast-global-color-2);background-color:var(--ast-global-color-2);box-shadow:none;}.site-footer a:hover + .post-count,.site-footer a:focus + .post-count{background:var(--ast-global-color-2);border-color:var(--ast-global-color-2);}.single .nav-links .nav-previous,.single .nav-links .nav-next{color:var(--ast-global-color-2);}.entry-meta,.entry-meta *{line-height:1.45;color:var(--ast-global-color-2);}.entry-meta a:not(.ast-button):hover,.entry-meta a:not(.ast-button):hover *,.entry-meta a:not(.ast-button):focus,.entry-meta a:not(.ast-button):focus *,.page-links > .page-link,.page-links .page-link:hover,.post-navigation a:hover{color:var(--ast-global-color-1);}#cat option,.secondary .calendar_wrap thead a,.secondary .calendar_wrap thead a:visited{color:var(--ast-global-color-2);}.secondary .calendar_wrap #today,.ast-progress-val span{background:var(--ast-global-color-2);}.secondary a:hover + .post-count,.secondary a:focus + .post-count{background:var(--ast-global-color-2);border-color:var(--ast-global-color-2);}.calendar_wrap #today > a{color:#ffffff;}.page-links .page-link,.single .post-navigation a{color:var(--ast-global-color-2);}.ast-search-menu-icon .search-form button.search-submit{padding:0 4px;}.ast-search-menu-icon form.search-form{padding-right:0;}.ast-search-menu-icon.slide-search input.search-field{width:0;}.ast-header-search .ast-search-menu-icon.ast-dropdown-active .search-form,.ast-header-search .ast-search-menu-icon.ast-dropdown-active .search-field:focus{transition:all 0.2s;}.search-form input.search-field:focus{outline:none;}.wp-block-latest-posts > li > a{color:var(--ast-global-color-2);}.widget-title,.widget .wp-block-heading{font-size:22px;font-size:1.375rem;color:var(--ast-global-color-3);}.ast-search-menu-icon.slide-search a:focus-visible:focus-visible,.astra-search-icon:focus-visible,#close:focus-visible,a:focus-visible,.ast-menu-toggle:focus-visible,.site .skip-link:focus-visible,.wp-block-loginout input:focus-visible,.wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper,.ast-header-navigation-arrow:focus-visible,.ast-orders-table__row .ast-orders-table__cell:focus-visible,a#ast-apply-coupon:focus-visible,#ast-apply-coupon:focus-visible,#close:focus-visible,.button.search-submit:focus-visible,#search_submit:focus,.normal-search:focus-visible,.ast-header-account-wrap:focus-visible,.astra-cart-drawer-close:focus,.ast-single-variation:focus,.ast-button:focus,.ast-builder-button-wrap:has(.ast-custom-button-link:focus),.ast-builder-button-wrap .ast-custom-button-link:focus{outline-style:dotted;outline-color:inherit;outline-width:thin;}input:focus,input[type="text"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="password"]:focus,input[type="reset"]:focus,input[type="search"]:focus,input[type="number"]:focus,textarea:focus,.wp-block-search__input:focus,[data-section="section-header-mobile-trigger"] .ast-button-wrap .ast-mobile-menu-trigger-minimal:focus,.ast-mobile-popup-drawer.active .menu-toggle-close:focus,#ast-scroll-top:focus,#coupon_code:focus,#ast-coupon-code:focus{border-style:dotted;border-color:inherit;border-width:thin;}input{outline:none;}.ast-logo-title-inline .site-logo-img{padding-right:1em;}.site-logo-img img{ transition:all 0.2s linear;}body .ast-oembed-container *{position:absolute;top:0;width:100%;height:100%;left:0;}body .wp-block-embed-pocket-casts .ast-oembed-container *{position:unset;}.ast-single-post-featured-section + article {margin-top: 2em;}.site-content .ast-single-post-featured-section img {width: 100%;overflow: hidden;object-fit: cover;}.site > .ast-single-related-posts-container {margin-top: 0;}@media (min-width: 922px) {.ast-desktop .ast-container--narrow {max-width: var(--ast-narrow-container-width);margin: 0 auto;}}@media (max-width:921.9px){#ast-desktop-header{display:none;}}@media (min-width:922px){#ast-mobile-header{display:none;}}@media( max-width: 420px ) {.single .nav-links .nav-previous,.single .nav-links .nav-next {width: 100%;text-align: center;}}.wp-block-buttons.aligncenter{justify-content:center;}@media (max-width:921px){.ast-theme-transparent-header #primary,.ast-theme-transparent-header #secondary{padding:0;}}@media (max-width:921px){.ast-plain-container.ast-no-sidebar #primary{padding:0;}}.ast-plain-container.ast-no-sidebar #primary{margin-top:0;margin-bottom:0;}.wp-block-button.is-style-outline .wp-block-button__link{border-color:var(--ast-global-color-0);border-top-width:2px;border-right-width:2px;border-bottom-width:2px;border-left-width:2px;}div.wp-block-button.is-style-outline > .wp-block-button__link:not(.has-text-color),div.wp-block-button.wp-block-button__link.is-style-outline:not(.has-text-color){color:var(--ast-global-color-0);}.wp-block-button.is-style-outline .wp-block-button__link:hover,.wp-block-buttons .wp-block-button.is-style-outline .wp-block-button__link:focus,.wp-block-buttons .wp-block-button.is-style-outline > .wp-block-button__link:not(.has-text-color):hover,.wp-block-buttons .wp-block-button.wp-block-button__link.is-style-outline:not(.has-text-color):hover{color:#ffffff;background-color:var(--ast-global-color-0);border-color:var(--ast-global-color-0);}.post-page-numbers.current .page-link,.ast-pagination .page-numbers.current{color:#ffffff;border-color:var(--ast-global-color-0);background-color:var(--ast-global-color-0);}.wp-block-buttons .wp-block-button.is-style-outline .wp-block-button__link.wp-element-button,.ast-outline-button,.wp-block-uagb-buttons-child .uagb-buttons-repeater.ast-outline-button{border-color:var(--ast-global-color-0);border-top-width:2px;border-right-width:2px;border-bottom-width:2px;border-left-width:2px;font-family:inherit;font-weight:700;font-size:13px;font-size:0.8125rem;line-height:1em;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-right-radius:0px;border-bottom-left-radius:0px;}.wp-block-buttons .wp-block-button.is-style-outline > .wp-block-button__link:not(.has-text-color),.wp-block-buttons .wp-block-button.wp-block-button__link.is-style-outline:not(.has-text-color),.ast-outline-button{color:var(--ast-global-color-0);}.wp-block-button.is-style-outline .wp-block-button__link:hover,.wp-block-buttons .wp-block-button.is-style-outline .wp-block-button__link:focus,.wp-block-buttons .wp-block-button.is-style-outline > .wp-block-button__link:not(.has-text-color):hover,.wp-block-buttons .wp-block-button.wp-block-button__link.is-style-outline:not(.has-text-color):hover,.ast-outline-button:hover,.ast-outline-button:focus,.wp-block-uagb-buttons-child .uagb-buttons-repeater.ast-outline-button:hover,.wp-block-uagb-buttons-child .uagb-buttons-repeater.ast-outline-button:focus{color:#ffffff;background-color:var(--ast-global-color-0);border-color:var(--ast-global-color-0);}.wp-block-button .wp-block-button__link.wp-element-button.is-style-outline:not(.has-background),.wp-block-button.is-style-outline>.wp-block-button__link.wp-element-button:not(.has-background),.ast-outline-button{background-color:rgba(242,57,44,0);}.entry-content[data-ast-blocks-layout] > figure{margin-bottom:1em;}@media (max-width:921px){.ast-left-sidebar #content > .ast-container{display:flex;flex-direction:column-reverse;width:100%;}.ast-separate-container .ast-article-post,.ast-separate-container .ast-article-single{padding:1.5em 2.14em;}.ast-author-box img.avatar{margin:20px 0 0 0;}}@media (min-width:922px){.ast-separate-container.ast-right-sidebar #primary,.ast-separate-container.ast-left-sidebar #primary{border:0;}.search-no-results.ast-separate-container #primary{margin-bottom:4em;}}.elementor-widget-button .elementor-button{border-style:solid;text-decoration:none;border-top-width:2px;border-right-width:2px;border-left-width:2px;border-bottom-width:2px;}body .elementor-button.elementor-size-sm,body .elementor-button.elementor-size-xs,body .elementor-button.elementor-size-md,body .elementor-button.elementor-size-lg,body .elementor-button.elementor-size-xl,body .elementor-button{border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-right-radius:0px;border-bottom-left-radius:0px;padding-top:14px;padding-right:22px;padding-bottom:14px;padding-left:22px;}@media (max-width:921px){.elementor-widget-button .elementor-button.elementor-size-sm,.elementor-widget-button .elementor-button.elementor-size-xs,.elementor-widget-button .elementor-button.elementor-size-md,.elementor-widget-button .elementor-button.elementor-size-lg,.elementor-widget-button .elementor-button.elementor-size-xl,.elementor-widget-button .elementor-button{padding-top:14px;padding-right:20px;padding-bottom:14px;padding-left:20px;}}@media (max-width:544px){.elementor-widget-button .elementor-button.elementor-size-sm,.elementor-widget-button .elementor-button.elementor-size-xs,.elementor-widget-button .elementor-button.elementor-size-md,.elementor-widget-button .elementor-button.elementor-size-lg,.elementor-widget-button .elementor-button.elementor-size-xl,.elementor-widget-button .elementor-button{padding-top:12px;padding-right:20px;padding-bottom:12px;padding-left:20px;}}.elementor-widget-button .elementor-button{border-color:var(--ast-global-color-0);background-color:rgba(242,57,44,0);}.elementor-widget-button .elementor-button:hover,.elementor-widget-button .elementor-button:focus{color:#ffffff;background-color:var(--ast-global-color-0);border-color:var(--ast-global-color-0);}.wp-block-button .wp-block-button__link ,.elementor-widget-button .elementor-button,.elementor-widget-button .elementor-button:visited{color:var(--ast-global-color-0);}.elementor-widget-button .elementor-button{font-weight:700;font-size:13px;font-size:0.8125rem;line-height:1em;text-transform:uppercase;letter-spacing:2px;}body .elementor-button.elementor-size-sm,body .elementor-button.elementor-size-xs,body .elementor-button.elementor-size-md,body .elementor-button.elementor-size-lg,body .elementor-button.elementor-size-xl,body .elementor-button{font-size:13px;font-size:0.8125rem;}.wp-block-button .wp-block-button__link:hover,.wp-block-button .wp-block-button__link:focus{color:#ffffff;background-color:var(--ast-global-color-0);border-color:var(--ast-global-color-0);}.elementor-widget-heading h1.elementor-heading-title{line-height:1em;}.elementor-widget-heading h2.elementor-heading-title{line-height:1em;}.elementor-widget-heading h3.elementor-heading-title{line-height:1em;}.elementor-widget-heading h4.elementor-heading-title{line-height:1.2em;}.elementor-widget-heading h5.elementor-heading-title{line-height:1.2em;}.elementor-widget-heading h6.elementor-heading-title{line-height:1.25em;}.wp-block-button .wp-block-button__link,.wp-block-search .wp-block-search__button,body .wp-block-file .wp-block-file__button{border-style:solid;border-top-width:2px;border-right-width:2px;border-left-width:2px;border-bottom-width:2px;border-color:var(--ast-global-color-0);background-color:rgba(242,57,44,0);color:var(--ast-global-color-0);font-family:inherit;font-weight:700;line-height:1em;text-transform:uppercase;letter-spacing:2px;font-size:13px;font-size:0.8125rem;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-right-radius:0px;border-bottom-left-radius:0px;padding-top:14px;padding-right:22px;padding-bottom:14px;padding-left:22px;}@media (max-width:921px){.wp-block-button .wp-block-button__link,.wp-block-search .wp-block-search__button,body .wp-block-file .wp-block-file__button{padding-top:14px;padding-right:20px;padding-bottom:14px;padding-left:20px;}}@media (max-width:544px){.wp-block-button .wp-block-button__link,.wp-block-search .wp-block-search__button,body .wp-block-file .wp-block-file__button{padding-top:12px;padding-right:20px;padding-bottom:12px;padding-left:20px;}}.menu-toggle,button,.ast-button,.ast-custom-button,.button,input#submit,input[type="button"],input[type="submit"],input[type="reset"],form[CLASS*="wp-block-search__"].wp-block-search .wp-block-search__inside-wrapper .wp-block-search__button,body .wp-block-file .wp-block-file__button{border-style:solid;border-top-width:2px;border-right-width:2px;border-left-width:2px;border-bottom-width:2px;color:var(--ast-global-color-0);border-color:var(--ast-global-color-0);background-color:rgba(242,57,44,0);padding-top:14px;padding-right:22px;padding-bottom:14px;padding-left:22px;font-family:inherit;font-weight:700;font-size:13px;font-size:0.8125rem;line-height:1em;text-transform:uppercase;letter-spacing:2px;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-right-radius:0px;border-bottom-left-radius:0px;}button:focus,.menu-toggle:hover,button:hover,.ast-button:hover,.ast-custom-button:hover .button:hover,.ast-custom-button:hover ,input[type=reset]:hover,input[type=reset]:focus,input#submit:hover,input#submit:focus,input[type="button"]:hover,input[type="button"]:focus,input[type="submit"]:hover,input[type="submit"]:focus,form[CLASS*="wp-block-search__"].wp-block-search .wp-block-search__inside-wrapper .wp-block-search__button:hover,form[CLASS*="wp-block-search__"].wp-block-search .wp-block-search__inside-wrapper .wp-block-search__button:focus,body .wp-block-file .wp-block-file__button:hover,body .wp-block-file .wp-block-file__button:focus{color:#ffffff;background-color:var(--ast-global-color-0);border-color:var(--ast-global-color-0);}@media (max-width:921px){.menu-toggle,button,.ast-button,.ast-custom-button,.button,input#submit,input[type="button"],input[type="submit"],input[type="reset"],form[CLASS*="wp-block-search__"].wp-block-search .wp-block-search__inside-wrapper .wp-block-search__button,body .wp-block-file .wp-block-file__button{padding-top:14px;padding-right:20px;padding-bottom:14px;padding-left:20px;}}@media (max-width:544px){.menu-toggle,button,.ast-button,.ast-custom-button,.button,input#submit,input[type="button"],input[type="submit"],input[type="reset"],form[CLASS*="wp-block-search__"].wp-block-search .wp-block-search__inside-wrapper .wp-block-search__button,body .wp-block-file .wp-block-file__button{padding-top:12px;padding-right:20px;padding-bottom:12px;padding-left:20px;}}@media (max-width:921px){.ast-mobile-header-stack .main-header-bar .ast-search-menu-icon{display:inline-block;}.ast-header-break-point.ast-header-custom-item-outside .ast-mobile-header-stack .main-header-bar .ast-search-icon{margin:0;}.ast-comment-avatar-wrap img{max-width:2.5em;}.ast-comment-meta{padding:0 1.8888em 1.3333em;}.ast-separate-container .ast-comment-list li.depth-1{padding:1.5em 2.14em;}.ast-separate-container .comment-respond{padding:2em 2.14em;}}@media (min-width:544px){.ast-container{max-width:100%;}}@media (max-width:544px){.ast-separate-container .ast-article-post,.ast-separate-container .ast-article-single,.ast-separate-container .comments-title,.ast-separate-container .ast-archive-description{padding:1.5em 1em;}.ast-separate-container #content .ast-container{padding-left:0.54em;padding-right:0.54em;}.ast-separate-container .ast-comment-list .bypostauthor{padding:.5em;}.ast-search-menu-icon.ast-dropdown-active .search-field{width:170px;}} #ast-mobile-header .ast-site-header-cart-li a{pointer-events:none;}body,.ast-separate-container{background-color:var(--ast-global-color-4);background-image:none;}@media (max-width:921px){.widget-title{font-size:22px;font-size:1.375rem;}body,button,input,select,textarea,.ast-button,.ast-custom-button{font-size:16px;font-size:1rem;}#secondary,#secondary button,#secondary input,#secondary select,#secondary textarea{font-size:16px;font-size:1rem;}.site-title{display:none;}.site-header .site-description{display:none;}h1,.entry-content :where(h1){font-size:48px;}h2,.entry-content :where(h2){font-size:32px;}h3,.entry-content :where(h3){font-size:28px;}h4,.entry-content :where(h4){font-size:20px;font-size:1.25rem;}h5,.entry-content :where(h5){font-size:17px;font-size:1.0625rem;}.astra-logo-svg{width:144px;}header .custom-logo-link img,.ast-header-break-point .site-logo-img .custom-mobile-logo-link img{max-width:144px;width:144px;}}@media (max-width:544px){.widget-title{font-size:21px;font-size:1.4rem;}body,button,input,select,textarea,.ast-button,.ast-custom-button{font-size:15px;font-size:0.9375rem;}#secondary,#secondary button,#secondary input,#secondary select,#secondary textarea{font-size:15px;font-size:0.9375rem;}.site-title{display:none;}.site-header .site-description{display:none;}h1,.entry-content :where(h1){font-size:40px;}h2,.entry-content :where(h2){font-size:28px;}h3,.entry-content :where(h3){font-size:24px;}h5,.entry-content :where(h5){font-size:16px;font-size:1rem;}header .custom-logo-link img,.ast-header-break-point .site-branding img,.ast-header-break-point .custom-logo-link img{max-width:120px;width:120px;}.astra-logo-svg{width:120px;}.ast-header-break-point .site-logo-img .custom-mobile-logo-link img{max-width:120px;}}@media (max-width:544px){html{font-size:100%;}}@media (min-width:922px){.ast-container{max-width:1240px;}}@media (min-width:922px){.site-content .ast-container{display:flex;}}@media (max-width:921px){.site-content .ast-container{flex-direction:column;}}@media (min-width:922px){.main-header-menu .sub-menu .menu-item.ast-left-align-sub-menu:hover > .sub-menu,.main-header-menu .sub-menu .menu-item.ast-left-align-sub-menu.focus > .sub-menu{margin-left:-0px;}}.site .comments-area{padding-bottom:3em;}.wp-block-file {display: flex;align-items: center;flex-wrap: wrap;justify-content: space-between;}.wp-block-pullquote {border: none;}.wp-block-pullquote blockquote::before {content: "\201D";font-family: "Helvetica",sans-serif;display: flex;transform: rotate( 180deg );font-size: 6rem;font-style: normal;line-height: 1;font-weight: bold;align-items: center;justify-content: center;}.has-text-align-right > blockquote::before {justify-content: flex-start;}.has-text-align-left > blockquote::before {justify-content: flex-end;}figure.wp-block-pullquote.is-style-solid-color blockquote {max-width: 100%;text-align: inherit;}:root {--wp--custom--ast-default-block-top-padding: 3em;--wp--custom--ast-default-block-right-padding: 3em;--wp--custom--ast-default-block-bottom-padding: 3em;--wp--custom--ast-default-block-left-padding: 3em;--wp--custom--ast-container-width: 1200px;--wp--custom--ast-content-width-size: 1200px;--wp--custom--ast-wide-width-size: calc(1200px + var(--wp--custom--ast-default-block-left-padding) + var(--wp--custom--ast-default-block-right-padding));}.ast-narrow-container {--wp--custom--ast-content-width-size: 750px;--wp--custom--ast-wide-width-size: 750px;}@media(max-width: 921px) {:root {--wp--custom--ast-default-block-top-padding: 3em;--wp--custom--ast-default-block-right-padding: 2em;--wp--custom--ast-default-block-bottom-padding: 3em;--wp--custom--ast-default-block-left-padding: 2em;}}@media(max-width: 544px) {:root {--wp--custom--ast-default-block-top-padding: 3em;--wp--custom--ast-default-block-right-padding: 1.5em;--wp--custom--ast-default-block-bottom-padding: 3em;--wp--custom--ast-default-block-left-padding: 1.5em;}}.entry-content > .wp-block-group,.entry-content > .wp-block-cover,.entry-content > .wp-block-columns {padding-top: var(--wp--custom--ast-default-block-top-padding);padding-right: var(--wp--custom--ast-default-block-right-padding);padding-bottom: var(--wp--custom--ast-default-block-bottom-padding);padding-left: var(--wp--custom--ast-default-block-left-padding);}.ast-plain-container.ast-no-sidebar .entry-content > .alignfull,.ast-page-builder-template .ast-no-sidebar .entry-content > .alignfull {margin-left: calc( -50vw + 50%);margin-right: calc( -50vw + 50%);max-width: 100vw;width: 100vw;}.ast-plain-container.ast-no-sidebar .entry-content .alignfull .alignfull,.ast-page-builder-template.ast-no-sidebar .entry-content .alignfull .alignfull,.ast-plain-container.ast-no-sidebar .entry-content .alignfull .alignwide,.ast-page-builder-template.ast-no-sidebar .entry-content .alignfull .alignwide,.ast-plain-container.ast-no-sidebar .entry-content .alignwide .alignfull,.ast-page-builder-template.ast-no-sidebar .entry-content .alignwide .alignfull,.ast-plain-container.ast-no-sidebar .entry-content .alignwide .alignwide,.ast-page-builder-template.ast-no-sidebar .entry-content .alignwide .alignwide,.ast-plain-container.ast-no-sidebar .entry-content .wp-block-column .alignfull,.ast-page-builder-template.ast-no-sidebar .entry-content .wp-block-column .alignfull,.ast-plain-container.ast-no-sidebar .entry-content .wp-block-column .alignwide,.ast-page-builder-template.ast-no-sidebar .entry-content .wp-block-column .alignwide {margin-left: auto;margin-right: auto;width: 100%;}[data-ast-blocks-layout] .wp-block-separator:not(.is-style-dots) {height: 0;}[data-ast-blocks-layout] .wp-block-separator {margin: 20px auto;}[data-ast-blocks-layout] .wp-block-separator:not(.is-style-wide):not(.is-style-dots) {max-width: 100px;}[data-ast-blocks-layout] .wp-block-separator.has-background {padding: 0;}.entry-content[data-ast-blocks-layout] > * {max-width: var(--wp--custom--ast-content-width-size);margin-left: auto;margin-right: auto;}.entry-content[data-ast-blocks-layout] > .alignwide {max-width: var(--wp--custom--ast-wide-width-size);}.entry-content[data-ast-blocks-layout] .alignfull {max-width: none;}.entry-content .wp-block-columns {margin-bottom: 0;}blockquote {margin: 1.5em;border-color: rgba(0,0,0,0.05);}.wp-block-quote:not(.has-text-align-right):not(.has-text-align-center) {border-left: 5px solid rgba(0,0,0,0.05);}.has-text-align-right > blockquote,blockquote.has-text-align-right {border-right: 5px solid rgba(0,0,0,0.05);}.has-text-align-left > blockquote,blockquote.has-text-align-left {border-left: 5px solid rgba(0,0,0,0.05);}.wp-block-site-tagline,.wp-block-latest-posts .read-more {margin-top: 15px;}.wp-block-loginout p label {display: block;}.wp-block-loginout p:not(.login-remember):not(.login-submit) input {width: 100%;}.wp-block-loginout input:focus {border-color: transparent;}.wp-block-loginout input:focus {outline: thin dotted;}.entry-content .wp-block-media-text .wp-block-media-text__content {padding: 0 0 0 8%;}.entry-content .wp-block-media-text.has-media-on-the-right .wp-block-media-text__content {padding: 0 8% 0 0;}.entry-content .wp-block-media-text.has-background .wp-block-media-text__content {padding: 8%;}.entry-content .wp-block-cover:not([class*="background-color"]):not(.has-text-color.has-link-color) .wp-block-cover__inner-container,.entry-content .wp-block-cover:not([class*="background-color"]) .wp-block-cover-image-text,.entry-content .wp-block-cover:not([class*="background-color"]) .wp-block-cover-text,.entry-content .wp-block-cover-image:not([class*="background-color"]) .wp-block-cover__inner-container,.entry-content .wp-block-cover-image:not([class*="background-color"]) .wp-block-cover-image-text,.entry-content .wp-block-cover-image:not([class*="background-color"]) .wp-block-cover-text {color: var(--ast-global-color-primary,var(--ast-global-color-5));}.wp-block-loginout .login-remember input {width: 1.1rem;height: 1.1rem;margin: 0 5px 4px 0;vertical-align: middle;}.wp-block-latest-posts > li > *:first-child,.wp-block-latest-posts:not(.is-grid) > li:first-child {margin-top: 0;}.entry-content > .wp-block-buttons,.entry-content > .wp-block-uagb-buttons {margin-bottom: 1.5em;}.wp-block-search__inside-wrapper .wp-block-search__input {padding: 0 10px;color: var(--ast-global-color-3);background: var(--ast-global-color-primary,var(--ast-global-color-5));border-color: var(--ast-border-color);}.wp-block-latest-posts .read-more {margin-bottom: 1.5em;}.wp-block-search__no-button .wp-block-search__inside-wrapper .wp-block-search__input {padding-top: 5px;padding-bottom: 5px;}.wp-block-latest-posts .wp-block-latest-posts__post-date,.wp-block-latest-posts .wp-block-latest-posts__post-author {font-size: 1rem;}.wp-block-latest-posts > li > *,.wp-block-latest-posts:not(.is-grid) > li {margin-top: 12px;margin-bottom: 12px;}.ast-page-builder-template .entry-content[data-ast-blocks-layout] > .alignwide:where(:not(.uagb-is-root-container):not(.spectra-is-root-container)) > * {max-width: var(--wp--custom--ast-wide-width-size);}.ast-page-builder-template .entry-content[data-ast-blocks-layout] > .inherit-container-width > *,.ast-page-builder-template .entry-content[data-ast-blocks-layout] > *:not(.wp-block-group):where(:not(.uagb-is-root-container):not(.spectra-is-root-container)) > *,.entry-content[data-ast-blocks-layout] > .wp-block-cover .wp-block-cover__inner-container {max-width: var(--wp--custom--ast-content-width-size) ;margin-left: auto;margin-right: auto;}.ast-page-builder-template .entry-content[data-ast-blocks-layout] > *,.ast-page-builder-template .entry-content[data-ast-blocks-layout] > .alignfull:where(:not(.wp-block-group):not(.uagb-is-root-container):not(.spectra-is-root-container)) > * {max-width: none;}.entry-content[data-ast-blocks-layout] .wp-block-cover:not(.alignleft):not(.alignright) {width: auto;}@media(max-width: 1200px) {.ast-separate-container .entry-content > .alignfull,.ast-separate-container .entry-content[data-ast-blocks-layout] > .alignwide,.ast-plain-container .entry-content[data-ast-blocks-layout] > .alignwide,.ast-plain-container .entry-content .alignfull {margin-left: calc(-1 * min(var(--ast-container-default-xlg-padding),20px)) ;margin-right: calc(-1 * min(var(--ast-container-default-xlg-padding),20px));}}@media(min-width: 1201px) {.ast-separate-container .entry-content > .alignfull {margin-left: calc(-1 * var(--ast-container-default-xlg-padding) );margin-right: calc(-1 * var(--ast-container-default-xlg-padding) );}.ast-separate-container .entry-content[data-ast-blocks-layout] > .alignwide,.ast-plain-container .entry-content[data-ast-blocks-layout] > .alignwide {margin-left: calc(-1 * var(--wp--custom--ast-default-block-left-padding) );margin-right: calc(-1 * var(--wp--custom--ast-default-block-right-padding) );}}@media(min-width: 921px) {.ast-separate-container .entry-content .wp-block-group.alignwide:not(.inherit-container-width) > :where(:not(.alignleft):not(.alignright)),.ast-plain-container .entry-content .wp-block-group.alignwide:not(.inherit-container-width) > :where(:not(.alignleft):not(.alignright)) {max-width: calc( var(--wp--custom--ast-content-width-size) + 80px );}.ast-plain-container.ast-right-sidebar .entry-content[data-ast-blocks-layout] .alignfull,.ast-plain-container.ast-left-sidebar .entry-content[data-ast-blocks-layout] .alignfull {margin-left: -60px;margin-right: -60px;}}@media(min-width: 544px) {.entry-content > .alignleft {margin-right: 20px;}.entry-content > .alignright {margin-left: 20px;}}@media (max-width:544px){.wp-block-columns .wp-block-column:not(:last-child){margin-bottom:20px;}.wp-block-latest-posts{margin:0;}}@media( max-width: 600px ) {.entry-content .wp-block-media-text .wp-block-media-text__content,.entry-content .wp-block-media-text.has-media-on-the-right .wp-block-media-text__content {padding: 8% 0 0;}.entry-content .wp-block-media-text.has-background .wp-block-media-text__content {padding: 8%;}}.ast-page-builder-template .entry-header {padding-left: 0;}.ast-narrow-container .site-content .wp-block-uagb-image--align-full .wp-block-uagb-image__figure {max-width: 100%;margin-left: auto;margin-right: auto;}:root .has-ast-global-color-0-color{color:var(--ast-global-color-0);}:root .has-ast-global-color-0-background-color{background-color:var(--ast-global-color-0);}:root .wp-block-button .has-ast-global-color-0-color{color:var(--ast-global-color-0);}:root .wp-block-button .has-ast-global-color-0-background-color{background-color:var(--ast-global-color-0);}:root .has-ast-global-color-1-color{color:var(--ast-global-color-1);}:root .has-ast-global-color-1-background-color{background-color:var(--ast-global-color-1);}:root .wp-block-button .has-ast-global-color-1-color{color:var(--ast-global-color-1);}:root .wp-block-button .has-ast-global-color-1-background-color{background-color:var(--ast-global-color-1);}:root .has-ast-global-color-2-color{color:var(--ast-global-color-2);}:root .has-ast-global-color-2-background-color{background-color:var(--ast-global-color-2);}:root .wp-block-button .has-ast-global-color-2-color{color:var(--ast-global-color-2);}:root .wp-block-button .has-ast-global-color-2-background-color{background-color:var(--ast-global-color-2);}:root .has-ast-global-color-3-color{color:var(--ast-global-color-3);}:root .has-ast-global-color-3-background-color{background-color:var(--ast-global-color-3);}:root .wp-block-button .has-ast-global-color-3-color{color:var(--ast-global-color-3);}:root .wp-block-button .has-ast-global-color-3-background-color{background-color:var(--ast-global-color-3);}:root .has-ast-global-color-4-color{color:var(--ast-global-color-4);}:root .has-ast-global-color-4-background-color{background-color:var(--ast-global-color-4);}:root .wp-block-button .has-ast-global-color-4-color{color:var(--ast-global-color-4);}:root .wp-block-button .has-ast-global-color-4-background-color{background-color:var(--ast-global-color-4);}:root .has-ast-global-color-5-color{color:var(--ast-global-color-5);}:root .has-ast-global-color-5-background-color{background-color:var(--ast-global-color-5);}:root .wp-block-button .has-ast-global-color-5-color{color:var(--ast-global-color-5);}:root .wp-block-button .has-ast-global-color-5-background-color{background-color:var(--ast-global-color-5);}:root .has-ast-global-color-6-color{color:var(--ast-global-color-6);}:root .has-ast-global-color-6-background-color{background-color:var(--ast-global-color-6);}:root .wp-block-button .has-ast-global-color-6-color{color:var(--ast-global-color-6);}:root .wp-block-button .has-ast-global-color-6-background-color{background-color:var(--ast-global-color-6);}:root .has-ast-global-color-7-color{color:var(--ast-global-color-7);}:root .has-ast-global-color-7-background-color{background-color:var(--ast-global-color-7);}:root .wp-block-button .has-ast-global-color-7-color{color:var(--ast-global-color-7);}:root .wp-block-button .has-ast-global-color-7-background-color{background-color:var(--ast-global-color-7);}:root .has-ast-global-color-8-color{color:var(--ast-global-color-8);}:root .has-ast-global-color-8-background-color{background-color:var(--ast-global-color-8);}:root .wp-block-button .has-ast-global-color-8-color{color:var(--ast-global-color-8);}:root .wp-block-button .has-ast-global-color-8-background-color{background-color:var(--ast-global-color-8);}:root{--ast-global-color-0:#f2382c;--ast-global-color-1:#dc2618;--ast-global-color-2:#25272d;--ast-global-color-3:#565a61;--ast-global-color-4:#f7f7f8;--ast-global-color-5:#ffffff;--ast-global-color-6:#f7f7f8;--ast-global-color-7:#25272d;--ast-global-color-8:#bfd1ff;}:root {--ast-border-color : #dddddd;}.ast-single-entry-banner {-js-display: flex;display: flex;flex-direction: column;justify-content: center;text-align: center;position: relative;background: var(--ast-title-layout-bg);}.ast-single-entry-banner[data-banner-layout="layout-1"] {max-width: 1200px;background: inherit;padding: 20px 0;}.ast-single-entry-banner[data-banner-width-type="custom"] {margin: 0 auto;width: 100%;}.ast-single-entry-banner + .site-content .entry-header {margin-bottom: 0;}.site .ast-author-avatar {--ast-author-avatar-size: ;}a.ast-underline-text {text-decoration: underline;}.ast-container > .ast-terms-link {position: relative;display: block;}a.ast-button.ast-badge-tax {padding: 4px 8px;border-radius: 3px;font-size: inherit;}header.entry-header{text-align:left;}header.entry-header > *:not(:last-child){margin-bottom:10px;}@media (max-width:921px){header.entry-header{text-align:left;}}@media (max-width:544px){header.entry-header{text-align:left;}}.ast-archive-entry-banner {-js-display: flex;display: flex;flex-direction: column;justify-content: center;text-align: center;position: relative;background: var(--ast-title-layout-bg);}.ast-archive-entry-banner[data-banner-width-type="custom"] {margin: 0 auto;width: 100%;}.ast-archive-entry-banner[data-banner-layout="layout-1"] {background: inherit;padding: 20px 0;text-align: left;}body.archive .ast-archive-description{max-width:1200px;width:100%;text-align:left;padding-top:3em;padding-right:3em;padding-bottom:3em;padding-left:3em;}body.archive .ast-archive-description .ast-archive-title,body.archive .ast-archive-description .ast-archive-title *{font-size:40px;font-size:2.5rem;}body.archive .ast-archive-description > *:not(:last-child){margin-bottom:10px;}@media (max-width:921px){body.archive .ast-archive-description{text-align:left;}}@media (max-width:544px){body.archive .ast-archive-description{text-align:left;}}.ast-breadcrumbs .trail-browse,.ast-breadcrumbs .trail-items,.ast-breadcrumbs .trail-items li{display:inline-block;margin:0;padding:0;border:none;background:inherit;text-indent:0;text-decoration:none;}.ast-breadcrumbs .trail-browse{font-size:inherit;font-style:inherit;font-weight:inherit;color:inherit;}.ast-breadcrumbs .trail-items{list-style:none;}.trail-items li::after{padding:0 0.3em;content:"\00bb";}.trail-items li:last-of-type::after{display:none;}h1,h2,h3,h4,h5,h6,.entry-content :where(h1,h2,h3,h4,h5,h6){color:var(--ast-global-color-2);}@media (max-width:921px){.ast-builder-grid-row-container.ast-builder-grid-row-tablet-3-firstrow .ast-builder-grid-row > *:first-child,.ast-builder-grid-row-container.ast-builder-grid-row-tablet-3-lastrow .ast-builder-grid-row > *:last-child{grid-column:1 / -1;}}@media (max-width:544px){.ast-builder-grid-row-container.ast-builder-grid-row-mobile-3-firstrow .ast-builder-grid-row > *:first-child,.ast-builder-grid-row-container.ast-builder-grid-row-mobile-3-lastrow .ast-builder-grid-row > *:last-child{grid-column:1 / -1;}}.ast-builder-layout-element[data-section="title_tagline"]{display:flex;}@media (max-width:921px){.ast-header-break-point .ast-builder-layout-element[data-section="title_tagline"]{display:flex;}}@media (max-width:544px){.ast-header-break-point .ast-builder-layout-element[data-section="title_tagline"]{display:flex;}}.ast-builder-menu-1{font-family:inherit;font-weight:500;text-transform:uppercase;}.ast-builder-menu-1 .menu-item > .menu-link{font-size:14px;font-size:0.875rem;padding-left:24px;padding-right:24px;}.ast-builder-menu-1 .sub-menu,.ast-builder-menu-1 .inline-on-mobile .sub-menu{border-top-width:2px;border-bottom-width:0px;border-right-width:0px;border-left-width:0px;border-color:var(--ast-global-color-0);border-style:solid;}.ast-builder-menu-1 .sub-menu .sub-menu{top:-2px;}.ast-builder-menu-1 .main-header-menu > .menu-item > .sub-menu,.ast-builder-menu-1 .main-header-menu > .menu-item > .astra-full-megamenu-wrapper{margin-top:0px;}.ast-desktop .ast-builder-menu-1 .main-header-menu > .menu-item > .sub-menu:before,.ast-desktop .ast-builder-menu-1 .main-header-menu > .menu-item > .astra-full-megamenu-wrapper:before{height:calc( 0px + 2px + 5px );}.ast-builder-menu-1 .menu-item.menu-item-has-children > .ast-menu-toggle{right:calc( 24px - 0.907em );}.ast-desktop .ast-builder-menu-1 .menu-item .sub-menu .menu-link{border-style:none;}@media (max-width:921px){.ast-header-break-point .ast-builder-menu-1 .menu-item.menu-item-has-children > .ast-menu-toggle{top:0;}.ast-builder-menu-1 .inline-on-mobile .menu-item.menu-item-has-children > .ast-menu-toggle{right:-15px;}.ast-builder-menu-1 .menu-item-has-children > .menu-link:after{content:unset;}.ast-builder-menu-1 .main-header-menu > .menu-item > .sub-menu,.ast-builder-menu-1 .main-header-menu > .menu-item > .astra-full-megamenu-wrapper{margin-top:0;}}@media (max-width:544px){.ast-header-break-point .ast-builder-menu-1 .menu-item.menu-item-has-children > .ast-menu-toggle{top:0;}.ast-builder-menu-1 .main-header-menu > .menu-item > .sub-menu,.ast-builder-menu-1 .main-header-menu > .menu-item > .astra-full-megamenu-wrapper{margin-top:0;}}.ast-builder-menu-1{display:flex;}@media (max-width:921px){.ast-header-break-point .ast-builder-menu-1{display:flex;}}@media (max-width:544px){.ast-header-break-point .ast-builder-menu-1{display:flex;}}.ast-builder-html-element img.alignnone{display:inline-block;}.ast-builder-html-element p:first-child{margin-top:0;}.ast-builder-html-element p:last-child{margin-bottom:0;}.ast-header-break-point .main-header-bar .ast-builder-html-element{line-height:1.85714285714286;}.ast-header-html-1 .ast-builder-html-element{font-size:15px;font-size:0.9375rem;}.ast-header-html-1{font-size:15px;font-size:0.9375rem;}.ast-header-html-1{display:flex;}@media (max-width:921px){.ast-header-break-point .ast-header-html-1{display:flex;}}@media (max-width:544px){.ast-header-break-point .ast-header-html-1{display:flex;}}.site-footer{background-color:var(--ast-global-color-2);background-image:none;}.elementor-posts-container [CLASS*="ast-width-"]{width:100%;}.elementor-template-full-width .ast-container{display:block;}.elementor-screen-only,.screen-reader-text,.screen-reader-text span,.ui-helper-hidden-accessible{top:0 !important;}@media (max-width:544px){.elementor-element .elementor-wc-products .woocommerce[class*="columns-"] ul.products li.product{width:auto;margin:0;}.elementor-element .woocommerce .woocommerce-result-count{float:none;}}.ast-header-break-point .main-header-bar{border-bottom-width:1px;}@media (min-width:922px){.main-header-bar{border-bottom-width:1px;}}.main-header-menu .menu-item, #astra-footer-menu .menu-item, .main-header-bar .ast-masthead-custom-menu-items{-js-display:flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;-moz-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-moz-box-orient:vertical;-moz-box-direction:normal;-ms-flex-direction:column;flex-direction:column;}.main-header-menu > .menu-item > .menu-link, #astra-footer-menu > .menu-item > .menu-link{height:100%;-webkit-box-align:center;-webkit-align-items:center;-moz-box-align:center;-ms-flex-align:center;align-items:center;-js-display:flex;display:flex;}.ast-header-break-point .main-navigation ul .menu-item .menu-link .icon-arrow:first-of-type svg{top:.2em;margin-top:0px;margin-left:0px;width:.65em;transform:translate(0, -2px) rotateZ(270deg);}.ast-mobile-popup-content .ast-submenu-expanded > .ast-menu-toggle{transform:rotateX(180deg);overflow-y:auto;}@media (min-width:922px){.ast-builder-menu .main-navigation > ul > li:last-child a{margin-right:0;}}.ast-separate-container .ast-article-inner{background-color:transparent;background-image:none;}.ast-separate-container .ast-article-post{background-color:var(--ast-global-color-5);background-image:none;}@media (max-width:921px){.ast-separate-container .ast-article-post{background-color:var(--ast-global-color-5);background-image:none;}}@media (max-width:544px){.ast-separate-container .ast-article-post{background-color:var(--ast-global-color-5);background-image:none;}}.ast-separate-container .ast-article-single:not(.ast-related-post), .ast-separate-container .error-404, .ast-separate-container .no-results, .single.ast-separate-container  .ast-author-meta, .ast-separate-container .related-posts-title-wrapper, .ast-separate-container .comments-count-wrapper, .ast-box-layout.ast-plain-container .site-content, .ast-padded-layout.ast-plain-container .site-content, .ast-separate-container .ast-archive-description, .ast-separate-container .comments-area .comment-respond, .ast-separate-container .comments-area .ast-comment-list li, .ast-separate-container .comments-area .comments-title{background-color:var(--ast-global-color-5);background-image:none;}@media (max-width:921px){.ast-separate-container .ast-article-single:not(.ast-related-post), .ast-separate-container .error-404, .ast-separate-container .no-results, .single.ast-separate-container  .ast-author-meta, .ast-separate-container .related-posts-title-wrapper, .ast-separate-container .comments-count-wrapper, .ast-box-layout.ast-plain-container .site-content, .ast-padded-layout.ast-plain-container .site-content, .ast-separate-container .ast-archive-description{background-color:var(--ast-global-color-5);background-image:none;}}@media (max-width:544px){.ast-separate-container .ast-article-single:not(.ast-related-post), .ast-separate-container .error-404, .ast-separate-container .no-results, .single.ast-separate-container  .ast-author-meta, .ast-separate-container .related-posts-title-wrapper, .ast-separate-container .comments-count-wrapper, .ast-box-layout.ast-plain-container .site-content, .ast-padded-layout.ast-plain-container .site-content, .ast-separate-container .ast-archive-description{background-color:var(--ast-global-color-5);background-image:none;}}.ast-separate-container.ast-two-container #secondary .widget{background-color:var(--ast-global-color-5);background-image:none;}@media (max-width:921px){.ast-separate-container.ast-two-container #secondary .widget{background-color:var(--ast-global-color-5);background-image:none;}}@media (max-width:544px){.ast-separate-container.ast-two-container #secondary .widget{background-color:var(--ast-global-color-5);background-image:none;}}.ast-mobile-header-content > *,.ast-desktop-header-content > * {padding: 10px 0;height: auto;}.ast-mobile-header-content > *:first-child,.ast-desktop-header-content > *:first-child {padding-top: 10px;}.ast-mobile-header-content > .ast-builder-menu,.ast-desktop-header-content > .ast-builder-menu {padding-top: 0;}.ast-mobile-header-content > *:last-child,.ast-desktop-header-content > *:last-child {padding-bottom: 0;}.ast-mobile-header-content .ast-search-menu-icon.ast-inline-search label,.ast-desktop-header-content .ast-search-menu-icon.ast-inline-search label {width: 100%;}.ast-desktop-header-content .main-header-bar-navigation .ast-submenu-expanded > .ast-menu-toggle::before {transform: rotateX(180deg);}#ast-desktop-header .ast-desktop-header-content,.ast-mobile-header-content .ast-search-icon,.ast-desktop-header-content .ast-search-icon,.ast-mobile-header-wrap .ast-mobile-header-content,.ast-main-header-nav-open.ast-popup-nav-open .ast-mobile-header-wrap .ast-mobile-header-content,.ast-main-header-nav-open.ast-popup-nav-open .ast-desktop-header-content {display: none;}.ast-main-header-nav-open.ast-header-break-point #ast-desktop-header .ast-desktop-header-content,.ast-main-header-nav-open.ast-header-break-point .ast-mobile-header-wrap .ast-mobile-header-content {display: block;}.ast-desktop .ast-desktop-header-content .astra-menu-animation-slide-up > .menu-item > .sub-menu,.ast-desktop .ast-desktop-header-content .astra-menu-animation-slide-up > .menu-item .menu-item > .sub-menu,.ast-desktop .ast-desktop-header-content .astra-menu-animation-slide-down > .menu-item > .sub-menu,.ast-desktop .ast-desktop-header-content .astra-menu-animation-slide-down > .menu-item .menu-item > .sub-menu,.ast-desktop .ast-desktop-header-content .astra-menu-animation-fade > .menu-item > .sub-menu,.ast-desktop .ast-desktop-header-content .astra-menu-animation-fade > .menu-item .menu-item > .sub-menu {opacity: 1;visibility: visible;}.ast-hfb-header.ast-default-menu-enable.ast-header-break-point .ast-mobile-header-wrap .ast-mobile-header-content .main-header-bar-navigation {width: unset;margin: unset;}.ast-mobile-header-content.content-align-flex-end .main-header-bar-navigation .menu-item-has-children > .ast-menu-toggle,.ast-desktop-header-content.content-align-flex-end .main-header-bar-navigation .menu-item-has-children > .ast-menu-toggle {left: calc( 20px - 0.907em);right: auto;}.ast-mobile-header-content .ast-search-menu-icon,.ast-mobile-header-content .ast-search-menu-icon.slide-search,.ast-desktop-header-content .ast-search-menu-icon,.ast-desktop-header-content .ast-search-menu-icon.slide-search {width: 100%;position: relative;display: block;right: auto;transform: none;}.ast-mobile-header-content .ast-search-menu-icon.slide-search .search-form,.ast-mobile-header-content .ast-search-menu-icon .search-form,.ast-desktop-header-content .ast-search-menu-icon.slide-search .search-form,.ast-desktop-header-content .ast-search-menu-icon .search-form {right: 0;visibility: visible;opacity: 1;position: relative;top: auto;transform: none;padding: 0;display: block;overflow: hidden;}.ast-mobile-header-content .ast-search-menu-icon.ast-inline-search .search-field,.ast-mobile-header-content .ast-search-menu-icon .search-field,.ast-desktop-header-content .ast-search-menu-icon.ast-inline-search .search-field,.ast-desktop-header-content .ast-search-menu-icon .search-field {width: 100%;padding-right: 5.5em;}.ast-mobile-header-content .ast-search-menu-icon .search-submit,.ast-desktop-header-content .ast-search-menu-icon .search-submit {display: block;position: absolute;height: 100%;top: 0;right: 0;padding: 0 1em;border-radius: 0;}.ast-hfb-header.ast-default-menu-enable.ast-header-break-point .ast-mobile-header-wrap .ast-mobile-header-content .main-header-bar-navigation ul .sub-menu .menu-link {padding-left: 30px;}.ast-hfb-header.ast-default-menu-enable.ast-header-break-point .ast-mobile-header-wrap .ast-mobile-header-content .main-header-bar-navigation .sub-menu .menu-item .menu-item .menu-link {padding-left: 40px;}.ast-mobile-popup-drawer.active .ast-mobile-popup-inner{background-color:;;}.ast-mobile-header-wrap .ast-mobile-header-content, .ast-desktop-header-content{background-color:;;}.ast-mobile-popup-content > *, .ast-mobile-header-content > *, .ast-desktop-popup-content > *, .ast-desktop-header-content > *{padding-top:8px;padding-bottom:8px;}.content-align-flex-start .ast-builder-layout-element{justify-content:flex-start;}.content-align-flex-start .main-header-menu{text-align:left;}.ast-mobile-popup-drawer.active .menu-toggle-close{color:#3a3a3a;}.ast-mobile-header-wrap .ast-primary-header-bar,.ast-primary-header-bar .site-primary-header-wrap{min-height:104px;}.ast-desktop .ast-primary-header-bar .main-header-menu > .menu-item{line-height:104px;}.ast-header-break-point #masthead .ast-mobile-header-wrap .ast-primary-header-bar,.ast-header-break-point #masthead .ast-mobile-header-wrap .ast-below-header-bar,.ast-header-break-point #masthead .ast-mobile-header-wrap .ast-above-header-bar{padding-left:20px;padding-right:20px;}.ast-header-break-point .ast-primary-header-bar{border-bottom-width:1px;border-bottom-color:#eaeaea;border-bottom-style:solid;}@media (min-width:922px){.ast-primary-header-bar{border-bottom-width:1px;border-bottom-color:#eaeaea;border-bottom-style:solid;}}.ast-primary-header-bar{background-image:none;}@media (max-width:921px){.ast-mobile-header-wrap .ast-primary-header-bar,.ast-primary-header-bar .site-primary-header-wrap{min-height:88px;}}@media (max-width:544px){.ast-mobile-header-wrap .ast-primary-header-bar ,.ast-primary-header-bar .site-primary-header-wrap{min-height:72px;}}.ast-primary-header-bar{display:block;}@media (max-width:921px){.ast-header-break-point .ast-primary-header-bar{display:grid;}}@media (max-width:544px){.ast-header-break-point .ast-primary-header-bar{display:grid;}}[data-section="section-header-mobile-trigger"] .ast-button-wrap .ast-mobile-menu-trigger-minimal{color:var(--ast-global-color-0);border:none;background:transparent;}[data-section="section-header-mobile-trigger"] .ast-button-wrap .mobile-menu-toggle-icon .ast-mobile-svg{width:20px;height:20px;fill:var(--ast-global-color-0);}[data-section="section-header-mobile-trigger"] .ast-button-wrap .mobile-menu-wrap .mobile-menu{color:var(--ast-global-color-0);}.ast-builder-menu-mobile .main-navigation .menu-item.menu-item-has-children > .ast-menu-toggle{top:0;}.ast-builder-menu-mobile .main-navigation .menu-item-has-children > .menu-link:after{content:unset;}.ast-hfb-header .ast-builder-menu-mobile .main-header-menu, .ast-hfb-header .ast-builder-menu-mobile .main-navigation .menu-item .menu-link, .ast-hfb-header .ast-builder-menu-mobile .main-navigation .menu-item .sub-menu .menu-link{border-style:none;}.ast-builder-menu-mobile .main-navigation .menu-item.menu-item-has-children > .ast-menu-toggle{top:0;}@media (max-width:921px){.ast-builder-menu-mobile .main-navigation .menu-item.menu-item-has-children > .ast-menu-toggle{top:0;}.ast-builder-menu-mobile .main-navigation .menu-item-has-children > .menu-link:after{content:unset;}}@media (max-width:544px){.ast-builder-menu-mobile .main-navigation .menu-item.menu-item-has-children > .ast-menu-toggle{top:0;}}.ast-builder-menu-mobile .main-navigation{display:block;}@media (max-width:921px){.ast-header-break-point .ast-builder-menu-mobile .main-navigation{display:block;}}@media (max-width:544px){.ast-header-break-point .ast-builder-menu-mobile .main-navigation{display:block;}}:root{--e-global-color-astglobalcolor0:#f2382c;--e-global-color-astglobalcolor1:#dc2618;--e-global-color-astglobalcolor2:#25272d;--e-global-color-astglobalcolor3:#565a61;--e-global-color-astglobalcolor4:#f7f7f8;--e-global-color-astglobalcolor5:#ffffff;--e-global-color-astglobalcolor6:#f7f7f8;--e-global-color-astglobalcolor7:#25272d;--e-global-color-astglobalcolor8:#bfd1ff;}.comment-reply-title{font-size:26px;font-size:1.625rem;}.ast-comment-meta{line-height:1.666666667;color:var(--ast-global-color-2);font-size:13px;font-size:0.8125rem;}.ast-comment-list #cancel-comment-reply-link{font-size:16px;font-size:1rem;}.comments-title {padding: 2em 0;}.comments-title {word-wrap: break-word;font-weight: normal;}.ast-comment-list {margin: 0;word-wrap: break-word;padding-bottom: 0.5em;list-style: none;}.ast-comment-list li {list-style: none;}.ast-comment-list .ast-comment-edit-reply-wrap {-js-display: flex;display: flex;justify-content: flex-end;}.ast-comment-list .comment-awaiting-moderation {margin-bottom: 0;}.ast-comment {padding: 1em 0 ;}.ast-comment-info img {border-radius: 50%;}.ast-comment-cite-wrap cite {font-style: normal;}.comment-reply-title {font-weight: normal;line-height: 1.65;}.ast-comment-meta {margin-bottom: 0.5em;}.comments-area .comment-form-comment {width: 100%;border: none;margin: 0;padding: 0;}.comments-area .comment-notes,.comments-area .comment-textarea,.comments-area .form-allowed-tags {margin-bottom: 1.5em;}.comments-area .form-submit {margin-bottom: 0;}.comments-area textarea#comment,.comments-area .ast-comment-formwrap input[type="text"] {width: 100%;border-radius: 0;vertical-align: middle;margin-bottom: 10px;}.comments-area .no-comments {margin-top: 0.5em;margin-bottom: 0.5em;}.comments-area p.logged-in-as {margin-bottom: 1em;}.ast-separate-container .ast-comment-list {padding-bottom: 0;}.ast-separate-container .ast-comment-list li.depth-1 .children li,.ast-narrow-container .ast-comment-list li.depth-1 .children li {padding-bottom: 0;padding-top: 0;margin-bottom: 0;}.ast-separate-container .ast-comment-list .comment-respond {padding-top: 0;padding-bottom: 1em;background-color: transparent;}.ast-comment-list .comment .comment-respond {padding-bottom: 2em;border-bottom: none;}.ast-separate-container .ast-comment-list .bypostauthor,.ast-narrow-container .ast-comment-list .bypostauthor {padding: 2em;margin-bottom: 1em;}.ast-separate-container .ast-comment-list .bypostauthor li,.ast-narrow-container .ast-comment-list .bypostauthor li {background: transparent;margin-bottom: 0;padding: 0 0 0 2em;}.comment-content a {word-wrap: break-word;}.comment-form-legend {margin-bottom: unset;padding: 0 0.5em;}.ast-separate-container .ast-comment-list .pingback p {margin-bottom: 0;}.ast-separate-container .ast-comment-list li.depth-1,.ast-narrow-container .ast-comment-list li.depth-1 {padding: 3em;}.ast-comment-list > .comment:last-child .ast-comment {border: none;}.ast-separate-container .ast-comment-list .comment .comment-respond,.ast-narrow-container .ast-comment-list .comment .comment-respond {padding-bottom: 0;}.ast-separate-container .comment .comment-respond {margin-top: 2em;}.ast-separate-container .ast-comment-list li.depth-1 .ast-comment,.ast-separate-container .ast-comment-list li.depth-2 .ast-comment {border-bottom: 0;}.ast-separate-container .ast-comment-list li.depth-1 {padding: 4em 6.67em;margin-bottom: 2em;}@media (max-width: 1200px) {.ast-separate-container .ast-comment-list li.depth-1 {padding: 3em 3.34em;}}.ast-separate-container .comment-respond {background-color: #fff;padding: 4em 6.67em;border-bottom: 0;}@media (max-width: 1200px) {.ast-separate-container .comment-respond {padding: 3em 2.34em;}}.ast-separate-container .comments-title {background-color: #fff;padding: 1.2em 3.99em 0;}.ast-comment-list .children {margin-left: 2em;}@media (max-width: 992px) {.ast-comment-list .children {margin-left: 1em;}}.ast-comment-list #cancel-comment-reply-link {white-space: nowrap;font-size: 13px;font-weight: normal;margin-left: 1em;}.ast-comment-info {display: flex;position: relative;}.ast-comment-meta {justify-content: right;padding: 0 3.4em 1.60em;}.comments-area #wp-comment-cookies-consent {margin-right: 10px;}.ast-page-builder-template .comments-area {padding-left: 20px;padding-right: 20px;margin-top: 0;margin-bottom: 2em;}.ast-separate-container .ast-comment-list .bypostauthor .bypostauthor {background: transparent;margin-bottom: 0;padding-right: 0;padding-bottom: 0;padding-top: 0;}@media (min-width:922px){.ast-separate-container .ast-comment-list li .comment-respond{padding-left:2.66666em;padding-right:2.66666em;}}@media (max-width:544px){.ast-separate-container .ast-comment-list li.depth-1{padding:1.5em 1em;margin-bottom:1.5em;}.ast-separate-container .ast-comment-list .bypostauthor{padding:.5em;}.ast-separate-container .comment-respond{padding:1.5em 1em;}.ast-comment-meta{font-size:12px;font-size:0.8rem;}.comment-reply-title{font-size:24px;font-size:1.6rem;}.ast-comment-list #cancel-comment-reply-link{font-size:15px;font-size:0.9375rem;}.ast-separate-container .ast-comment-list .bypostauthor li{padding:0 0 0 .5em;}.ast-comment-list .children{margin-left:0.66666em;}}
				.ast-comment-time .timendate{
					margin-right: 0.5em;
				}
				.ast-separate-container .comment-reply-title {
					padding-top: 0;
				}
				.ast-comment-list .ast-edit-link {
					flex: 1;
				}
				.comments-area {
					border-top: 1px solid var(--ast-global-color-subtle-background, var(--ast-global-color-6));
					margin-top: 2em;
				}
				.ast-separate-container .comments-area {
					border-top: 0;
				}
			@media (max-width:921px){.ast-comment-avatar-wrap img{max-width:2.5em;}.comments-area{margin-top:1.5em;}.ast-comment-meta{padding:0 1.8888em 1.3333em;}.ast-separate-container .ast-comment-list li.depth-1{padding:1.5em 2.14em;}.ast-separate-container .comment-respond{padding:2em 2.14em;}.comment-reply-title{font-size:26px;font-size:1.625rem;}.ast-comment-list #cancel-comment-reply-link{font-size:16px;font-size:1rem;}.ast-separate-container .comments-title{padding:1.43em 1.48em;}.ast-comment-avatar-wrap{margin-right:0.5em;}}
/*# sourceURL=astra-theme-css-inline-css */
</style>
<link rel='stylesheet' id='astra-google-fonts-css' href='https://fonts.googleapis.com/css?family=Lato%3A400%2C700%7CHeebo%3A700%2C500&amp;display=fallback&amp;ver=4.12.0' media='all' />
<link data-minify="1" rel='stylesheet' id='font-awesome-css' href='../wp-content/cache/min/1/wp-content/plugins/elementor/assets/lib/font-awesome/css/font-awesome.minb70c.css?ver=1771070144' media='all' />
<style id='wp-emoji-styles-inline-css'>

	img.wp-smiley, img.emoji {
		display: inline !important;
		border: none !important;
		box-shadow: none !important;
		height: 1em !important;
		width: 1em !important;
		margin: 0 0.07em !important;
		vertical-align: -0.1em !important;
		background: none !important;
		padding: 0 !important;
	}
/*# sourceURL=wp-emoji-styles-inline-css */
</style>
<link rel='stylesheet' id='wp-block-library-css' href='../wp-includes/css/dist/block-library/style.min4d80.html?ver=6.9.1' media='all' />
<style id='global-styles-inline-css'>
:root{--wp--preset--aspect-ratio--square: 1;--wp--preset--aspect-ratio--4-3: 4/3;--wp--preset--aspect-ratio--3-4: 3/4;--wp--preset--aspect-ratio--3-2: 3/2;--wp--preset--aspect-ratio--2-3: 2/3;--wp--preset--aspect-ratio--16-9: 16/9;--wp--preset--aspect-ratio--9-16: 9/16;--wp--preset--color--black: #000000;--wp--preset--color--cyan-bluish-gray: #abb8c3;--wp--preset--color--white: #ffffff;--wp--preset--color--pale-pink: #f78da7;--wp--preset--color--vivid-red: #cf2e2e;--wp--preset--color--luminous-vivid-orange: #ff6900;--wp--preset--color--luminous-vivid-amber: #fcb900;--wp--preset--color--light-green-cyan: #7bdcb5;--wp--preset--color--vivid-green-cyan: #00d084;--wp--preset--color--pale-cyan-blue: #8ed1fc;--wp--preset--color--vivid-cyan-blue: #0693e3;--wp--preset--color--vivid-purple: #9b51e0;--wp--preset--color--ast-global-color-0: var(--ast-global-color-0);--wp--preset--color--ast-global-color-1: var(--ast-global-color-1);--wp--preset--color--ast-global-color-2: var(--ast-global-color-2);--wp--preset--color--ast-global-color-3: var(--ast-global-color-3);--wp--preset--color--ast-global-color-4: var(--ast-global-color-4);--wp--preset--color--ast-global-color-5: var(--ast-global-color-5);--wp--preset--color--ast-global-color-6: var(--ast-global-color-6);--wp--preset--color--ast-global-color-7: var(--ast-global-color-7);--wp--preset--color--ast-global-color-8: var(--ast-global-color-8);--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,rgb(6,147,227) 0%,rgb(155,81,224) 100%);--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%);--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,rgb(252,185,0) 0%,rgb(255,105,0) 100%);--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,rgb(255,105,0) 0%,rgb(207,46,46) 100%);--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%);--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%);--wp--preset--gradient--blush-light-purple: linear-gradient(135deg,rgb(255,206,236) 0%,rgb(152,150,240) 100%);--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,rgb(254,205,165) 0%,rgb(254,45,45) 50%,rgb(107,0,62) 100%);--wp--preset--gradient--luminous-dusk: linear-gradient(135deg,rgb(255,203,112) 0%,rgb(199,81,192) 50%,rgb(65,88,208) 100%);--wp--preset--gradient--pale-ocean: linear-gradient(135deg,rgb(255,245,203) 0%,rgb(182,227,212) 50%,rgb(51,167,181) 100%);--wp--preset--gradient--electric-grass: linear-gradient(135deg,rgb(202,248,128) 0%,rgb(113,206,126) 100%);--wp--preset--gradient--midnight: linear-gradient(135deg,rgb(2,3,129) 0%,rgb(40,116,252) 100%);--wp--preset--font-size--small: 13px;--wp--preset--font-size--medium: 20px;--wp--preset--font-size--large: 36px;--wp--preset--font-size--x-large: 42px;--wp--preset--spacing--20: 0.44rem;--wp--preset--spacing--30: 0.67rem;--wp--preset--spacing--40: 1rem;--wp--preset--spacing--50: 1.5rem;--wp--preset--spacing--60: 2.25rem;--wp--preset--spacing--70: 3.38rem;--wp--preset--spacing--80: 5.06rem;--wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined: 6px 6px 0px -3px rgb(255, 255, 255), 6px 6px rgb(0, 0, 0);--wp--preset--shadow--crisp: 6px 6px 0px rgb(0, 0, 0);}:root { --wp--style--global--content-size: var(--wp--custom--ast-content-width-size);--wp--style--global--wide-size: var(--wp--custom--ast-wide-width-size); }:where(body) { margin: 0; }.wp-site-blocks > .alignleft { float: left; margin-right: 2em; }.wp-site-blocks > .alignright { float: right; margin-left: 2em; }.wp-site-blocks > .aligncenter { justify-content: center; margin-left: auto; margin-right: auto; }:where(.wp-site-blocks) > * { margin-block-start: 24px; margin-block-end: 0; }:where(.wp-site-blocks) > :first-child { margin-block-start: 0; }:where(.wp-site-blocks) > :last-child { margin-block-end: 0; }:root { --wp--style--block-gap: 24px; }:root :where(.is-layout-flow) > :first-child{margin-block-start: 0;}:root :where(.is-layout-flow) > :last-child{margin-block-end: 0;}:root :where(.is-layout-flow) > *{margin-block-start: 24px;margin-block-end: 0;}:root :where(.is-layout-constrained) > :first-child{margin-block-start: 0;}:root :where(.is-layout-constrained) > :last-child{margin-block-end: 0;}:root :where(.is-layout-constrained) > *{margin-block-start: 24px;margin-block-end: 0;}:root :where(.is-layout-flex){gap: 24px;}:root :where(.is-layout-grid){gap: 24px;}.is-layout-flow > .alignleft{float: left;margin-inline-start: 0;margin-inline-end: 2em;}.is-layout-flow > .alignright{float: right;margin-inline-start: 2em;margin-inline-end: 0;}.is-layout-flow > .aligncenter{margin-left: auto !important;margin-right: auto !important;}.is-layout-constrained > .alignleft{float: left;margin-inline-start: 0;margin-inline-end: 2em;}.is-layout-constrained > .alignright{float: right;margin-inline-start: 2em;margin-inline-end: 0;}.is-layout-constrained > .aligncenter{margin-left: auto !important;margin-right: auto !important;}.is-layout-constrained > :where(:not(.alignleft):not(.alignright):not(.alignfull)){max-width: var(--wp--style--global--content-size);margin-left: auto !important;margin-right: auto !important;}.is-layout-constrained > .alignwide{max-width: var(--wp--style--global--wide-size);}body .is-layout-flex{display: flex;}.is-layout-flex{flex-wrap: wrap;align-items: center;}.is-layout-flex > :is(*, div){margin: 0;}body .is-layout-grid{display: grid;}.is-layout-grid > :is(*, div){margin: 0;}body{padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;}a:where(:not(.wp-element-button)){text-decoration: none;}:root :where(.wp-element-button, .wp-block-button__link){background-color: #32373c;border-width: 0;color: #fff;font-family: inherit;font-size: inherit;font-style: inherit;font-weight: inherit;letter-spacing: inherit;line-height: inherit;padding-top: calc(0.667em + 2px);padding-right: calc(1.333em + 2px);padding-bottom: calc(0.667em + 2px);padding-left: calc(1.333em + 2px);text-decoration: none;text-transform: inherit;}.has-black-color{color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-color{color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-color{color: var(--wp--preset--color--white) !important;}.has-pale-pink-color{color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-color{color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-color{color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-color{color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-color{color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-color{color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-color{color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-color{color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-color{color: var(--wp--preset--color--vivid-purple) !important;}.has-ast-global-color-0-color{color: var(--wp--preset--color--ast-global-color-0) !important;}.has-ast-global-color-1-color{color: var(--wp--preset--color--ast-global-color-1) !important;}.has-ast-global-color-2-color{color: var(--wp--preset--color--ast-global-color-2) !important;}.has-ast-global-color-3-color{color: var(--wp--preset--color--ast-global-color-3) !important;}.has-ast-global-color-4-color{color: var(--wp--preset--color--ast-global-color-4) !important;}.has-ast-global-color-5-color{color: var(--wp--preset--color--ast-global-color-5) !important;}.has-ast-global-color-6-color{color: var(--wp--preset--color--ast-global-color-6) !important;}.has-ast-global-color-7-color{color: var(--wp--preset--color--ast-global-color-7) !important;}.has-ast-global-color-8-color{color: var(--wp--preset--color--ast-global-color-8) !important;}.has-black-background-color{background-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-background-color{background-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-background-color{background-color: var(--wp--preset--color--white) !important;}.has-pale-pink-background-color{background-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-background-color{background-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-background-color{background-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-background-color{background-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-background-color{background-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-background-color{background-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-background-color{background-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-background-color{background-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-background-color{background-color: var(--wp--preset--color--vivid-purple) !important;}.has-ast-global-color-0-background-color{background-color: var(--wp--preset--color--ast-global-color-0) !important;}.has-ast-global-color-1-background-color{background-color: var(--wp--preset--color--ast-global-color-1) !important;}.has-ast-global-color-2-background-color{background-color: var(--wp--preset--color--ast-global-color-2) !important;}.has-ast-global-color-3-background-color{background-color: var(--wp--preset--color--ast-global-color-3) !important;}.has-ast-global-color-4-background-color{background-color: var(--wp--preset--color--ast-global-color-4) !important;}.has-ast-global-color-5-background-color{background-color: var(--wp--preset--color--ast-global-color-5) !important;}.has-ast-global-color-6-background-color{background-color: var(--wp--preset--color--ast-global-color-6) !important;}.has-ast-global-color-7-background-color{background-color: var(--wp--preset--color--ast-global-color-7) !important;}.has-ast-global-color-8-background-color{background-color: var(--wp--preset--color--ast-global-color-8) !important;}.has-black-border-color{border-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-border-color{border-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-border-color{border-color: var(--wp--preset--color--white) !important;}.has-pale-pink-border-color{border-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-border-color{border-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-border-color{border-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-border-color{border-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-border-color{border-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-border-color{border-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-border-color{border-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-border-color{border-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-border-color{border-color: var(--wp--preset--color--vivid-purple) !important;}.has-ast-global-color-0-border-color{border-color: var(--wp--preset--color--ast-global-color-0) !important;}.has-ast-global-color-1-border-color{border-color: var(--wp--preset--color--ast-global-color-1) !important;}.has-ast-global-color-2-border-color{border-color: var(--wp--preset--color--ast-global-color-2) !important;}.has-ast-global-color-3-border-color{border-color: var(--wp--preset--color--ast-global-color-3) !important;}.has-ast-global-color-4-border-color{border-color: var(--wp--preset--color--ast-global-color-4) !important;}.has-ast-global-color-5-border-color{border-color: var(--wp--preset--color--ast-global-color-5) !important;}.has-ast-global-color-6-border-color{border-color: var(--wp--preset--color--ast-global-color-6) !important;}.has-ast-global-color-7-border-color{border-color: var(--wp--preset--color--ast-global-color-7) !important;}.has-ast-global-color-8-border-color{border-color: var(--wp--preset--color--ast-global-color-8) !important;}.has-vivid-cyan-blue-to-vivid-purple-gradient-background{background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;}.has-light-green-cyan-to-vivid-green-cyan-gradient-background{background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;}.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;}.has-luminous-vivid-orange-to-vivid-red-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;}.has-very-light-gray-to-cyan-bluish-gray-gradient-background{background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;}.has-cool-to-warm-spectrum-gradient-background{background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;}.has-blush-light-purple-gradient-background{background: var(--wp--preset--gradient--blush-light-purple) !important;}.has-blush-bordeaux-gradient-background{background: var(--wp--preset--gradient--blush-bordeaux) !important;}.has-luminous-dusk-gradient-background{background: var(--wp--preset--gradient--luminous-dusk) !important;}.has-pale-ocean-gradient-background{background: var(--wp--preset--gradient--pale-ocean) !important;}.has-electric-grass-gradient-background{background: var(--wp--preset--gradient--electric-grass) !important;}.has-midnight-gradient-background{background: var(--wp--preset--gradient--midnight) !important;}.has-small-font-size{font-size: var(--wp--preset--font-size--small) !important;}.has-medium-font-size{font-size: var(--wp--preset--font-size--medium) !important;}.has-large-font-size{font-size: var(--wp--preset--font-size--large) !important;}.has-x-large-font-size{font-size: var(--wp--preset--font-size--x-large) !important;}
:root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}
/*# sourceURL=global-styles-inline-css */
</style>
<link data-minify="1" rel='stylesheet' id='latepoint-main-front-css' href='../wp-content/cache/min/1/wp-content/plugins/latepoint/public/stylesheets/frontb70c.css?ver=1771070144' media='all' />
<style id='latepoint-main-front-inline-css'>
:root {--latepoint-brand-primary:#1d7bff;--latepoint-body-color:#1f222b;--latepoint-headings-color:#14161d;--latepoint-color-text-faded:#7c85a3;--latepoint-timeslot-selected-color:var(--latepoint-brand-primary);--latepoint-calendar-weekday-label-color:var(--latepoint-headings-color);--latepoint-calendar-weekday-label-bg:#fff;--latepoint-side-panel-bg:#fff;--latepoint-summary-panel-bg:#fff;--latepoint-border-radius:0px;--latepoint-border-radius-sm:0px;--latepoint-border-radius-md:0px;--latepoint-border-radius-lg:0px;}
/*# sourceURL=latepoint-main-front-inline-css */
</style>
<link data-minify="1" rel='stylesheet' id='happy-icons-css' href='../wp-content/cache/min/1/wp-content/plugins/happy-elementor-addons/assets/fonts/style.minb70c.css?ver=1771070144' media='all' />
<link rel='stylesheet' id='chaty-front-css-css' href='../wp-content/plugins/chaty/css/chaty-front.mina7d3.css?ver=3.5.11768552451' media='all' />
<link data-minify="1" rel='stylesheet' id='ekit-widget-styles-css' href='../wp-content/cache/min/1/wp-content/plugins/elementskit-lite/widgets/init/assets/css/widget-stylesb70c.css?ver=1771070144' media='all' />
<link data-minify="1" rel='stylesheet' id='ekit-responsive-css' href='../wp-content/cache/min/1/wp-content/plugins/elementskit-lite/widgets/init/assets/css/responsiveb70c.css?ver=1771070144' media='all' />
<link rel='stylesheet' id='eael-general-css' href='../wp-content/plugins/essential-addons-for-elementor-lite/assets/front-end/css/view/general.min3a22.css?ver=6.5.10' media='all' />
<link data-minify="1" rel='stylesheet' id='bdt-uikit-css' href='../wp-content/cache/min/1/wp-content/plugins/bdthemes-element-pack-lite/assets/css/bdt-uikitb70c.css?ver=1771070144' media='all' />
<link data-minify="1" rel='stylesheet' id='ep-helper-css' href='../wp-content/cache/min/1/wp-content/plugins/bdthemes-element-pack-lite/assets/css/ep-helperb70c.css?ver=1771070144' media='all' />
<link data-minify="1" rel='stylesheet' id='elementor-gf-local-roboto-css' href='../wp-content/cache/min/1/wp-content/uploads/elementor/google-fonts/css/roboto0bfb.css?ver=1771070145' media='all' />
<link data-minify="1" rel='stylesheet' id='elementor-gf-local-lato-css' href='../wp-content/cache/min/1/wp-content/uploads/elementor/google-fonts/css/lato0bfb.css?ver=1771070145' media='all' />
<link data-minify="1" rel='stylesheet' id='elementor-icons-ekiticons-css' href='../wp-content/cache/min/1/wp-content/plugins/elementskit-lite/modules/elementskit-icon-pack/assets/css/ekiticons0bfb.css?ver=1771070145' media='all' />
<link data-minify="1" rel='stylesheet' id='elementor-icons-shared-1-css' href='../wp-content/cache/min/1/wp-content/plugins/happy-elementor-addons/assets/fonts/huge-icons/huge-icons.min0bfb.css?ver=1771070145' media='all' />
<link data-minify="1" rel='stylesheet' id='elementor-icons-huge-icons-css' href='../wp-content/cache/min/1/wp-content/plugins/happy-elementor-addons/assets/fonts/huge-icons/huge-icons.min0bfb.css?ver=1771070145' media='all' />
<script src="../wp-content/themes/astra/assets/js/minified/flexibility.minb925.js?ver=4.12.0" id="astra-flexibility-js"></script>
<script id="astra-flexibility-js-after">
typeof flexibility !== "undefined" && flexibility(document.documentElement);
//# sourceURL=astra-flexibility-js-after
</script>
<script src="../wp-includes/js/jquery/jquery.minf43b.js?ver=3.7.1" id="jquery-core-js"></script>
<script src="../wp-includes/js/jquery/jquery-migrate.min5589.js?ver=3.4.1" id="jquery-migrate-js"></script>
<script data-minify="1" src="../wp-content/cache/min/1/wp-content/plugins/latepoint/public/javascripts/vendor-frontbe33.js?ver=1771070146" id="latepoint-vendor-front-js"></script>
<script src="../wp-includes/js/dist/hooks.minaf5f.js?ver=dd5603f07f9220ed27f1" id="wp-hooks-js"></script>
<script src="../wp-includes/js/dist/i18n.min1cde.js?ver=c26c3dc7bed366793375" id="wp-i18n-js"></script>
<script id="wp-i18n-js-after">
wp.i18n.setLocaleData( { 'text direction\u0004ltr': [ 'ltr' ] } );
//# sourceURL=wp-i18n-js-after
</script>
<script id="latepoint-main-front-js-extra">
var latepoint_helper = {"route_action":"latepoint_route_call","response_status":{"success":"success","error":"error"},"ajaxurl":"https://c11cl.com/wp-admin/admin-ajax.php","time_pick_style":"timebox","string_today":"Today","reload_booking_form_summary_route":"steps__reload_booking_form_summary_panel","time_system":"12","msg_not_available":"Not Available","booking_button_route":"steps__start","remove_cart_item_route":"carts__remove_item_from_cart","show_booking_end_time":"no","customer_dashboard_url":"https://c11cl.com/customer-cabinet","demo_mode":"","cancel_booking_prompt":"Are you sure you want to cancel this appointment?","single_space_message":"Space Available","many_spaces_message":"Spaces Available","body_font_family":"\"latepoint\", -apple-system, system-ui, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif ","headings_font_family":"\"latepoint\", -apple-system, system-ui, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif ","currency_symbol_before":"$","currency_symbol_after":"","thousand_separator":",","decimal_separator":".","number_of_decimals":"2","included_phone_countries":"[]","default_phone_country":"us","is_timezone_selected":"","start_from_order_intent_route":"steps__start_from_order_intent","start_from_order_intent_key":"","is_enabled_show_dial_code_with_flag":"1","mask_phone_number_fields":"1","msg_validation_presence":"can not be blank","msg_validation_presence_checkbox":"has to be checked","msg_validation_invalid":"is invalid","msg_minutes_suffix":" minutes","is_stripe_connect_enabled":"","check_order_intent_bookable_route":"steps__check_order_intent_bookable","generate_timeslots_for_day_route":"steps__generate_timeslots_for_day","payment_environment":"live","style_border_radius":"flat","datepicker_timeslot_selected_label":"Selected","invoices_payment_form_route":"invoices__payment_form","invoices_summary_before_payment_route":"invoices__summary_before_payment","reset_presets_when_adding_new_item":"","start_from_transaction_access_key":"","stripe_connect_route_create_payment_intent":"stripe_connect__create_payment_intent","stripe_connect_route_create_payment_intent_for_transaction_intent":"stripe_connect__create_payment_intent_for_transaction"};
//# sourceURL=latepoint-main-front-js-extra
</script>
<script data-minify="1" src="../wp-content/cache/min/1/wp-content/plugins/latepoint/public/javascripts/frontbe33.js?ver=1771070146" id="latepoint-main-front-js"></script>
<script src="../wp-content/plugins/happy-elementor-addons/assets/vendor/dom-purify/purify.min005e.js?ver=3.1.6" id="dom-purify-js"></script>
<link rel="https://api.w.org/" href="../wp-json/index.html" /><link rel="alternate" title="JSON" type="application/json" href="../wp-json/wp/v2/posts/3402.html" /><link rel="EditURI" type="application/rsd+xml" title="RSD" href="../xmlrpc0db0.php?rsd" />
<meta name="generator" content="WordPress 6.9.1" />
<link rel='shortlink' href='../indexbe26.html?p=3402' />
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'../../connect.facebook.net/en_US/fbevents.js');
fbq('init', '727837786776844');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=727837786776844&amp;ev=PageView&amp;noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'../../www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PHSBK2RF');</script>
<!-- End Google Tag Manager -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Champions11 Cricket League",
  "image": "https://c11cl.com/wp-content/uploads/2025/05/favicon-3.png",
  "@id": "https://c11cl.com/",
  "url": "https://c11cl.com/",
  "telephone": "+919599505213",
  "priceRange": "₹",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "A- 60, S4, Second Floor, sector 2, Noida, UP 201301. Landmark :- Near Sector 15 metro station",
    "addressLocality": "Noida",
    "postalCode": "201301",
    "addressCountry": "IN"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 28.58509,
    "longitude": 77.31159
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
      "Sunday"
    ],
    "opens": "00:00",
    "closes": "23:59"
  },
  "sameAs": [
    "https://c11cl.com/",
    "https://www.youtube.com/@C11CLOfficial",
    "https://www.facebook.com/people/Champions11CricketLeague/61575926537950/",
    "https://www.linkedin.com/company/champions11cricketleague/posts/?feedView=all",
    "https://x.com/champions11cl"
  ] 
}
</script>
<link rel="pingback" href="../xmlrpc.html">
<meta name="generator" content="Elementor 3.35.3; features: e_font_icon_svg, additional_custom_breakpoints; settings: css_print_method-external, google_font-enabled, font_display-swap">
<style>.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>			<style>
				.e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload),
				.e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload) * {
					background-image: none !important;
				}
				@media screen and (max-height: 1024px) {
					.e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload),
					.e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload) * {
						background-image: none !important;
					}
				}
				@media screen and (max-height: 640px) {
					.e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload),
					.e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload) * {
						background-image: none !important;
					}
				}
			</style>
			<link rel="icon" href="../wp-content/uploads/2025/05/cropped-favicon-3-32x32.png" sizes="32x32" />
<link rel="icon" href="../wp-content/uploads/2025/05/cropped-favicon-3-192x192.png" sizes="192x192" />
<link rel="apple-touch-icon" href="../wp-content/uploads/2025/05/cropped-favicon-3-180x180.png" />
<meta name="msapplication-TileImage" content="https://c11cl.com/wp-content/uploads/2025/05/cropped-favicon-3-270x270.png" />
		<style id="wp-custom-css">
			

/** Start Block Kit CSS: 144-3-3a7d335f39a8579c20cdf02f8d462582 **/

.envato-block__preview{overflow: visible;}

/* Envato Kit 141 Custom Styles - Applied to the element under Advanced */

.elementor-headline-animation-type-drop-in .elementor-headline-dynamic-wrapper{
	text-align: center;
}
.envato-kit-141-top-0 h1,
.envato-kit-141-top-0 h2,
.envato-kit-141-top-0 h3,
.envato-kit-141-top-0 h4,
.envato-kit-141-top-0 h5,
.envato-kit-141-top-0 h6,
.envato-kit-141-top-0 p {
	margin-top: 0;
}

.envato-kit-141-newsletter-inline .elementor-field-textual.elementor-size-md {
	padding-left: 1.5rem;
	padding-right: 1.5rem;
}

.envato-kit-141-bottom-0 p {
	margin-bottom: 0;
}

.envato-kit-141-bottom-8 .elementor-price-list .elementor-price-list-item .elementor-price-list-header {
	margin-bottom: .5rem;
}

.envato-kit-141.elementor-widget-testimonial-carousel.elementor-pagination-type-bullets .swiper-container {
	padding-bottom: 52px;
}

.envato-kit-141-display-inline {
	display: inline-block;
}

.envato-kit-141 .elementor-slick-slider ul.slick-dots {
	bottom: -40px;
}

/** End Block Kit CSS: 144-3-3a7d335f39a8579c20cdf02f8d462582 **/



/** Start Block Kit CSS: 105-3-0fb64e69c49a8e10692d28840c54ef95 **/

.envato-kit-102-phone-overlay {
	position: absolute !important;
	display: block !important;
	top: 0%;
	left: 0%;
	right: 0%;
	margin: auto;
	z-index: 1;
}

/** End Block Kit CSS: 105-3-0fb64e69c49a8e10692d28840c54ef95 **/



/** Start Block Kit CSS: 69-3-4f8cfb8a1a68ec007f2be7a02bdeadd9 **/

.envato-kit-66-menu .e--pointer-framed .elementor-item:before{
	border-radius:1px;
}

.envato-kit-66-subscription-form .elementor-form-fields-wrapper{
	position:relative;
}

.envato-kit-66-subscription-form .elementor-form-fields-wrapper .elementor-field-type-submit{
	position:static;
}

.envato-kit-66-subscription-form .elementor-form-fields-wrapper .elementor-field-type-submit button{
	position: absolute;
    top: 50%;
    right: 6px;
    transform: translate(0, -50%);
		-moz-transform: translate(0, -50%);
		-webmit-transform: translate(0, -50%);
}

.envato-kit-66-testi-slider .elementor-testimonial__footer{
	margin-top: -60px !important;
	z-index: 99;
  position: relative;
}

.envato-kit-66-featured-slider .elementor-slides .slick-prev{
	width:50px;
	height:50px;
	background-color:#ffffff !important;
	transform:rotate(45deg);
	-moz-transform:rotate(45deg);
	-webkit-transform:rotate(45deg);
	left:-25px !important;
	-webkit-box-shadow: 0px 1px 2px 1px rgba(0,0,0,0.32);
	-moz-box-shadow: 0px 1px 2px 1px rgba(0,0,0,0.32);
	box-shadow: 0px 1px 2px 1px rgba(0,0,0,0.32);
}

.envato-kit-66-featured-slider .elementor-slides .slick-prev:before{
	display:block;
	margin-top:0px;
	margin-left:0px;
	transform:rotate(-45deg);
	-moz-transform:rotate(-45deg);
	-webkit-transform:rotate(-45deg);
}

.envato-kit-66-featured-slider .elementor-slides .slick-next{
	width:50px;
	height:50px;
	background-color:#ffffff !important;
	transform:rotate(45deg);
	-moz-transform:rotate(45deg);
	-webkit-transform:rotate(45deg);
	right:-25px !important;
	-webkit-box-shadow: 0px 1px 2px 1px rgba(0,0,0,0.32);
	-moz-box-shadow: 0px 1px 2px 1px rgba(0,0,0,0.32);
	box-shadow: 0px 1px 2px 1px rgba(0,0,0,0.32);
}

.envato-kit-66-featured-slider .elementor-slides .slick-next:before{
	display:block;
	margin-top:-5px;
	margin-right:-5px;
	transform:rotate(-45deg);
	-moz-transform:rotate(-45deg);
	-webkit-transform:rotate(-45deg);
}

.envato-kit-66-orangetext{
	color:#f4511e;
}

.envato-kit-66-countdown .elementor-countdown-label{
	display:inline-block !important;
	border:2px solid rgba(255,255,255,0.2);
	padding:9px 20px;
}

/** End Block Kit CSS: 69-3-4f8cfb8a1a68ec007f2be7a02bdeadd9 **/



/** Start Block Kit CSS: 72-3-34d2cc762876498c8f6be5405a48e6e2 **/

.envato-block__preview{overflow: visible;}

/*Kit 69 Custom Styling for buttons */
.envato-kit-69-slide-btn .elementor-button,
.envato-kit-69-cta-btn .elementor-button,
.envato-kit-69-flip-btn .elementor-button{
	border-left: 0px !important;
	border-bottom: 0px !important;
	border-right: 0px !important;
	padding: 15px 0 0 !important;
}
.envato-kit-69-slide-btn .elementor-slide-button:hover,
.envato-kit-69-cta-btn .elementor-button:hover,
.envato-kit-69-flip-btn .elementor-button:hover{
	margin-bottom: 20px;
}
.envato-kit-69-menu .elementor-nav-menu--main a:hover{
	margin-top: -7px;
	padding-top: 4px;
	border-bottom: 1px solid #FFF;
}
/* Fix menu dropdown width */
.envato-kit-69-menu .elementor-nav-menu--dropdown{
	width: 100% !important;
}

/** End Block Kit CSS: 72-3-34d2cc762876498c8f6be5405a48e6e2 **/



/** Start Block Kit CSS: 141-3-1d55f1e76be9fb1a8d9de88accbe962f **/

.envato-kit-138-bracket .elementor-widget-container > *:before{
	content:"[";
	color:#ffab00;
	display:inline-block;
	margin-right:4px;
	line-height:1em;
	position:relative;
	top:-1px;
}

.envato-kit-138-bracket .elementor-widget-container > *:after{
	content:"]";
	color:#ffab00;
	display:inline-block;
	margin-left:4px;
	line-height:1em;
	position:relative;
	top:-1px;
}

/** End Block Kit CSS: 141-3-1d55f1e76be9fb1a8d9de88accbe962f **/



/** Start Block Kit CSS: 136-3-fc37602abad173a9d9d95d89bbe6bb80 **/

.envato-block__preview{overflow: visible !important;}

/** End Block Kit CSS: 136-3-fc37602abad173a9d9d95d89bbe6bb80 **/



/** Start Block Kit CSS: 143-3-7969bb877702491bc5ca272e536ada9d **/

.envato-block__preview{overflow: visible;}
/* Material Button Click Effect */
.envato-kit-140-material-hit .menu-item a,
.envato-kit-140-material-button .elementor-button{
  background-position: center;
  transition: background 0.8s;
}
.envato-kit-140-material-hit .menu-item a:hover,
.envato-kit-140-material-button .elementor-button:hover{
  background: radial-gradient(circle, transparent 1%, #fff 1%) center/15000%;
}
.envato-kit-140-material-hit .menu-item a:active,
.envato-kit-140-material-button .elementor-button:active{
  background-color: #FFF;
  background-size: 100%;
  transition: background 0s;
}

/* Field Shadow */
.envato-kit-140-big-shadow-form .elementor-field-textual{
	box-shadow: 0 20px 30px rgba(0,0,0, .05);
}

/* FAQ */
.envato-kit-140-faq .elementor-accordion .elementor-accordion-item{
	border-width: 0 0 1px !important;
}

/* Scrollable Columns */
.envato-kit-140-scrollable{
	 height: 100%;
   overflow: auto;
   overflow-x: hidden;
}

/* ImageBox: No Space */
.envato-kit-140-imagebox-nospace:hover{
	transform: scale(1.1);
	transition: all 0.3s;
}
.envato-kit-140-imagebox-nospace figure{
	line-height: 0;
}

.envato-kit-140-slide .elementor-slide-content{
	background: #FFF;
	margin-left: -60px;
	padding: 1em;
}
.envato-kit-140-carousel .slick-active:not(.slick-current)  img{
	padding: 20px !important;
	transition: all .9s;
}

/** End Block Kit CSS: 143-3-7969bb877702491bc5ca272e536ada9d **/

		</style>
		</head>

<body itemtype='https://schema.org/Blog' itemscope='itemscope' class="wp-singular post-template-default single single-post postid-3402 single-format-standard wp-custom-logo wp-embed-responsive wp-theme-astra latepoint metaslider-plugin ast-header-break-point ast-separate-container ast-two-container ast-no-sidebar astra-4.12.0 ast-blog-single-style-1 ast-single-post ast-replace-site-logo-transparent ast-inherit-site-logo-transparent ast-hfb-header ast-normal-title-enabled elementor-default elementor-kit-247">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PHSBK2RF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<a
	class="skip-link screen-reader-text"
	href="#content">
		Skip to content</a>

<div
class="hfeed site" id="page">
<?php include "../head.php"; ?>
		
		<div id="content" class="site-content">
		<div class="ast-container">
		

	<div id="primary" class="content-area primary">

		
					<main id="main" class="site-main">
				

<article
class="post-3402 post type-post status-publish format-standard has-post-thumbnail hentry category-c11cl-news tag-c11cl tag-c11cl-registration tag-champions-11-cricket-league tag-cricket tag-cricket-trial tag-cricket-trials-in-india tag-cricket-trials-india tag-grassroots-cricket tag-national-cricket-league tag-state-level-cricket-trials tag-state-level-t20-match ast-article-single" id="post-3402" itemtype="https://schema.org/CreativeWork" itemscope="itemscope">

	
	
<div class="ast-post-format- single-layout-1">

	
	
	<header class="entry-header">

    <div class="post-thumb-img-content post-thumb">
        <img width="986" height="422" 
             src="<?php echo $blog['featured_img']; ?>" 
             class="attachment-large size-large wp-post-image" 
             alt="<?php echo htmlspecialchars($blog['alt_tag']); ?>" 
             itemprop="image" 
             decoding="async" />
    </div>

    <h1 class="entry-title" itemprop="headline">
        <?php echo $blog['title']; ?>
    </h1>
    

    <div class="entry-meta">
        <span class="comments-link">
            <a href="#respond">Leave a Comment</a>
        </span>
        
        <span class="meta-separator"> / </span>

        <span class="ast-terms-link">
            <a href="../category/<?php echo strtolower(str_replace(' ', '-', $blog['category'])); ?>/" class="">
                <?php echo $blog['category']; ?>
            </a>
        </span> 
        
        <span class="meta-separator"> / </span>

        By <span class="posted-by vcard author" itemtype="https://schema.org/Person" itemscope="itemscope" itemprop="author">
            <a title="View all posts by <?php echo $blog['author']; ?>" href="#" rel="author" class="url fn n" itemprop="url">
                <span class="author-name" itemprop="name"><?php echo $blog['author']; ?></span>
            </a>
        </span>
        
        <span class="meta-separator"> / </span>
        
        <span class="published-date">
            <?php echo date('M d, Y', strtotime($blog['publish_date'])); ?>
        </span>

    </div>
    
</header>



	
	
<div class="entry-content">
                        <?php echo $blog['content']; ?> 
                    </div>
</div>

	
</article><!-- #post-## -->

<nav class="navigation post-navigation" aria-label="Posts">
				<div class="nav-links"><div class="nav-previous"><a title="In Small Towns, Big Dreams Die Quietly: Why India Needs Grassroots Leagues Like C11CL?" href="../in-small-towns-big-dreams-die-quietly-why-india-needs-grassroots-leagues-like-c11cl/index.html" rel="prev"><span class="ast-left-arrow" aria-hidden="true">&larr;</span> Previous Post</a></div></div>
		</nav>		<div id="comments" class="comments-area comment-form-position-below ">
	
	
	
	
		<div id="respond" class="comment-respond">
		<h3 id="reply-title" class="comment-reply-title">Leave a Comment <small><a rel="nofollow" id="cancel-comment-reply-link" href="index.html#respond" style="display:none;">Cancel Reply</a></small></h3><form action="https://c11cl.com/wp-comments-post.php" method="post" id="ast-commentform" class="comment-form"><p class="comment-notes"><span id="email-notes">Your email address will not be published.</span> <span class="required-field-message">Required fields are marked <span class="required">*</span></span></p><div class="ast-row comment-textarea"><fieldset class="comment-form-comment"><legend class ="comment-form-legend"></legend><div class="comment-form-textarea ast-grid-common-col"><label for="comment" class="screen-reader-text">Type here..</label><textarea id="comment" name="comment" placeholder="Type here.." cols="45" rows="8" aria-required="true"></textarea></div></fieldset></div><div class="ast-comment-formwrap ast-row">
			<p class="comment-form-author ast-grid-common-col ast-width-lg-33 ast-width-md-4 ast-float">
				<label for="author" class="screen-reader-text">Name*</label>
				<input id="author" name="author" type="text" 
					value="" 
					placeholder="Name*" 
					size="30" aria-required='true' autocomplete="name" />
			</p>
<p class="comment-form-email ast-grid-common-col ast-width-lg-33 ast-width-md-4 ast-float">
			<label for="email" class="screen-reader-text">Email*</label>
			<input id="email" name="email" type="text" 
				value="" 
				placeholder="Email*" 
				size="30" aria-required='true' autocomplete="email" />
		</p>
<p class="comment-form-url ast-grid-common-col ast-width-lg-33 ast-width-md-4 ast-float">
			<label for="url" class="screen-reader-text">Website</label>
			<input id="url" name="url" type="text" 
				value="" 
				placeholder="Website" 
				size="30" autocomplete="url" />
		</p>
		</div>
<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" /> <label for="wp-comment-cookies-consent">Save my name, email, and website in this browser for the next time I comment.</label></p>
<p class="form-submit"><input name="submit" type="submit" id="submit" class="submit" value="Post Comment &raquo;" /> <input type='hidden' name='comment_post_ID' value='3402' id='comment_post_ID' />
<input type='hidden' name='comment_parent' id='comment_parent' value='0' />
</p></form>	</div><!-- #respond -->
	
	
</div><!-- #comments -->

			</main><!-- #main -->
			
		
	</div><!-- #primary -->


	</div> <!-- ast-container -->
	</div><!-- #content -->
<?php include "../foot.php"; ?>
		
		</div><!-- #page -->
<script type="speculationrules">
{"prefetch":[{"source":"document","where":{"and":[{"href_matches":"/*"},{"not":{"href_matches":["/wp-*.php","/wp-admin/*","/wp-content/uploads/*","/wp-content/*","/wp-content/plugins/*","/wp-content/themes/astra/*","/*\\?(.+)"]}},{"not":{"selector_matches":"a[rel~=\"nofollow\"]"}},{"not":{"selector_matches":".no-prefetch, .no-prefetch a"}}]},"eagerness":"conservative"}]}
</script>
			<script>
				;
				(function($, w) {
					'use strict';
					let $window = $(w);

					$(document).ready(function() {

						let isEnable = "";
						let isEnableLazyMove = "";
						let speed = isEnableLazyMove ? '0.7' : '0.2';

						if( !isEnable ) {
							return;
						}

						if (typeof haCursor == 'undefined' || haCursor == null) {
							initiateHaCursorObject(speed);
						}

						setTimeout(function() {
							let targetCursor = $('.ha-cursor');
							if (targetCursor) {
								if (!isEnable) {
									$('body').removeClass('hm-init-default-cursor-none');
									$('.ha-cursor').addClass('ha-init-hide');
								} else {
									$('body').addClass('hm-init-default-cursor-none');
									$('.ha-cursor').removeClass('ha-init-hide');
								}
							}
						}, 500);

					});

				}(jQuery, window));
			</script>
		
					<script>
				const lazyloadRunObserver = () => {
					const lazyloadBackgrounds = document.querySelectorAll( `.e-con.e-parent:not(.e-lazyloaded)` );
					const lazyloadBackgroundObserver = new IntersectionObserver( ( entries ) => {
						entries.forEach( ( entry ) => {
							if ( entry.isIntersecting ) {
								let lazyloadBackground = entry.target;
								if( lazyloadBackground ) {
									lazyloadBackground.classList.add( 'e-lazyloaded' );
								}
								lazyloadBackgroundObserver.unobserve( entry.target );
							}
						});
					}, { rootMargin: '200px 0px 200px 0px' } );
					lazyloadBackgrounds.forEach( ( lazyloadBackground ) => {
						lazyloadBackgroundObserver.observe( lazyloadBackground );
					} );
				};
				const events = [
					'DOMContentLoaded',
					'elementor/lazyload/observe',
				];
				events.forEach( ( event ) => {
					document.addEventListener( event, lazyloadRunObserver );
				} );
			</script>
			<link rel='stylesheet' id='widget-icon-list-css' href='../wp-content/plugins/elementor/assets/css/widget-icon-list.min5be5.css?ver=3.35.3' media='all' />
<link rel='stylesheet' id='widget-image-css' href='../wp-content/plugins/elementor/assets/css/widget-image.min5be5.css?ver=3.35.3' media='all' />
<link rel='stylesheet' id='e-animation-grow-css' href='../wp-content/plugins/elementor/assets/lib/animations/styles/e-animation-grow.min5be5.css?ver=3.35.3' media='all' />
<link rel='stylesheet' id='widget-heading-css' href='../wp-content/plugins/elementor/assets/css/widget-heading.min5be5.css?ver=3.35.3' media='all' />
<style id='core-block-supports-inline-css'>
.wp-elements-1042c8c4bf318da9e7b653f8e0913e73 a:where(:not(.wp-element-button)){color:var(--wp--preset--color--vivid-cyan-blue);}.wp-elements-c1c660d6c58c580ae49734075d331298 a:where(:not(.wp-element-button)){color:var(--wp--preset--color--vivid-cyan-blue);}.wp-elements-2d9f0346de46372828a4df6b1999b235 a:where(:not(.wp-element-button)){color:var(--wp--preset--color--vivid-cyan-blue);}
/*# sourceURL=core-block-supports-inline-css */
</style>
<link rel='stylesheet' id='elementor-post-247-css' href='../wp-content/uploads/elementor/css/post-2472e88.css?ver=1770644315' media='all' />
<link data-minify="1" rel='stylesheet' id='font-awesome-5-all-css' href='../wp-content/cache/min/1/wp-content/plugins/elementor/assets/lib/font-awesome/css/all.minb70c.css?ver=1771070144' media='all' />
<link rel='stylesheet' id='font-awesome-4-shim-css' href='../wp-content/plugins/elementor/assets/lib/font-awesome/css/v4-shims.min3a22.css?ver=6.5.10' media='all' />
<link data-minify="1" rel='stylesheet' id='elementor-gf-local-robotoslab-css' href='../wp-content/cache/min/1/wp-content/uploads/elementor/google-fonts/css/robotoslab0bfb.css?ver=1771070145' media='all' />
<script src="../wp-includes/js/comment-reply.min4d80.html?ver=6.9.1" id="comment-reply-js" async data-wp-strategy="async" fetchpriority="low"></script>
<script id="astra-theme-js-js-extra">
var astra = {"break_point":"921","isRtl":"","is_scroll_to_id":"","is_scroll_to_top":"","is_header_footer_builder_active":"1","responsive_cart_click":"flyout","is_dark_palette":""};
//# sourceURL=astra-theme-js-js-extra
</script>
<script src="../wp-content/themes/astra/assets/js/minified/frontend.minb925.js?ver=4.12.0" id="astra-theme-js-js"></script>
<script src="../wp-includes/js/dist/dom-ready.min5346.js?ver=f77871ff7694fffea381" id="wp-dom-ready-js"></script>
<script id="starter-templates-zip-preview-js-extra">
var starter_templates_zip_preview = {"AstColorPaletteVarPrefix":"--ast-global-color-","AstEleColorPaletteVarPrefix":["ast-global-color-0","ast-global-color-1","ast-global-color-2","ast-global-color-3","ast-global-color-4","ast-global-color-5","ast-global-color-6","ast-global-color-7","ast-global-color-8"]};
//# sourceURL=starter-templates-zip-preview-js-extra
</script>
<script data-minify="1" src="../wp-content/cache/min/1/wp-content/plugins/astra-sites/inc/lib/onboarding/assets/dist/template-preview/mainbe33.js?ver=1771070146" id="starter-templates-zip-preview-js"></script>
<script id="happy-elementor-addons-js-extra">
var HappyLocalize = {"ajax_url":"https://c11cl.com/wp-admin/admin-ajax.php","nonce":"2ffd7cd828","pdf_js_lib":"https://c11cl.com/wp-content/plugins/happy-elementor-addons/assets/vendor/pdfjs/lib"};
//# sourceURL=happy-elementor-addons-js-extra
</script>
<script src="../wp-content/plugins/happy-elementor-addons/assets/js/happy-addons.minb645.js?ver=3.20.8" id="happy-elementor-addons-js"></script>
<script data-minify="1" src="../wp-content/cache/min/1/wp-content/plugins/elementskit-lite/libs/framework/assets/js/frontend-scriptbe33.html?ver=1771070146" id="elementskit-framework-js-frontend-js"></script>
<script id="elementskit-framework-js-frontend-js-after">
		var elementskit = {
			resturl: 'https://c11cl.com/wp-json/elementskit/v1/',
		}

		
//# sourceURL=elementskit-framework-js-frontend-js-after
</script>
<script data-minify="1" src="../wp-content/cache/min/1/wp-content/plugins/elementskit-lite/widgets/init/assets/js/widget-scriptsbe33.js?ver=1771070146" id="ekit-widget-scripts-js"></script>
<script id="chaty-front-end-js-extra">
var chaty_settings = {"ajax_url":"https://c11cl.com/wp-admin/admin-ajax.php","analytics":"0","capture_analytics":"1","token":"9425b9ecb1","chaty_widgets":[{"id":0,"identifier":0,"settings":{"cta_type":"simple-view","cta_body":"","cta_head":"","cta_head_bg_color":"","cta_head_text_color":"","show_close_button":1,"position":"right","custom_position":1,"bottom_spacing":"25","side_spacing":"25","icon_view":"vertical","default_state":"click","cta_text":"\u003Cp\u003EContact us\u003C/p\u003E","cta_text_color":"#333333","cta_bg_color":"#ffffff","show_cta":"first_click","is_pending_mesg_enabled":"off","pending_mesg_count":"1","pending_mesg_count_color":"#ffffff","pending_mesg_count_bgcolor":"#dd0000","widget_icon":"chat-base","widget_icon_url":"","font_family":"-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Oxygen-Sans,Ubuntu,Cantarell,Helvetica Neue,sans-serif","widget_size":"54","custom_widget_size":"54","is_google_analytics_enabled":0,"close_text":"Hide","widget_color":"#FF6060","widget_icon_color":"#ffffff","widget_rgb_color":"255,96,96","has_custom_css":0,"custom_css":"","widget_token":"2d0ab63012","widget_index":"","attention_effect":""},"triggers":{"has_time_delay":1,"time_delay":"0","exit_intent":0,"has_display_after_page_scroll":0,"display_after_page_scroll":"0","auto_hide_widget":0,"hide_after":0,"show_on_pages_rules":[],"time_diff":0,"has_date_scheduling_rules":0,"date_scheduling_rules":{"start_date_time":"","end_date_time":""},"date_scheduling_rules_timezone":0,"day_hours_scheduling_rules_timezone":0,"has_day_hours_scheduling_rules":[],"day_hours_scheduling_rules":[],"day_time_diff":0,"show_on_direct_visit":0,"show_on_referrer_social_network":0,"show_on_referrer_search_engines":0,"show_on_referrer_google_ads":0,"show_on_referrer_urls":[],"has_show_on_specific_referrer_urls":0,"has_traffic_source":0,"has_countries":0,"countries":[],"has_target_rules":0},"channels":[{"channel":"Phone","value":"+919599505213","hover_text":"Phone","chatway_position":"","svg_icon":"\u003Csvg width=\"39\" height=\"39\" viewBox=\"0 0 39 39\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"\u003E\u003Ccircle class=\"color-element\" cx=\"19.4395\" cy=\"19.4395\" r=\"19.4395\" fill=\"#03E78B\"/\u003E\u003Cpath d=\"M19.3929 14.9176C17.752 14.7684 16.2602 14.3209 14.7684 13.7242C14.0226 13.4259 13.1275 13.7242 12.8292 14.4701L11.7849 16.2602C8.65222 14.6193 6.11623 11.9341 4.47529 8.95057L6.41458 7.90634C7.16046 7.60799 7.45881 6.71293 7.16046 5.96705C6.56375 4.47529 6.11623 2.83435 5.96705 1.34259C5.96705 0.596704 5.22117 0 4.47529 0H0.745882C0.298353 0 5.69062e-07 0.298352 5.69062e-07 0.745881C5.69062e-07 3.72941 0.596704 6.71293 1.93929 9.3981C3.87858 13.575 7.30964 16.8569 11.3374 18.7962C14.0226 20.1388 17.0061 20.7355 19.9896 20.7355C20.4371 20.7355 20.7355 20.4371 20.7355 19.9896V16.4094C20.7355 15.5143 20.1388 14.9176 19.3929 14.9176Z\" transform=\"translate(9.07179 9.07178)\" fill=\"white\"/\u003E\u003C/svg\u003E","is_desktop":0,"is_mobile":1,"icon_color":"#03E78B","icon_rgb_color":"3,231,139","channel_type":"Phone","custom_image_url":"","order":"","pre_set_message":"","is_use_web_version":"1","is_open_new_tab":"1","is_default_open":"0","has_welcome_message":"0","emoji_picker":"1","input_placeholder":"Write your message...","chat_welcome_message":"","wp_popup_headline":"","wp_popup_nickname":"","wp_popup_profile":"","wp_popup_head_bg_color":"#4AA485","qr_code_image_url":"","mail_subject":"","channel_account_type":"personal","contact_form_settings":[],"contact_fields":[],"url":"tel:+919599505213","mobile_target":"","desktop_target":"","target":"","is_agent":0,"agent_data":[],"header_text":"","header_sub_text":"","header_bg_color":"","header_text_color":"","widget_token":"2d0ab63012","widget_index":"","click_event":"","viber_url":""},{"channel":"Whatsapp","value":"919211760909","hover_text":"WhatsApp","chatway_position":"","svg_icon":"\u003Csvg width=\"39\" height=\"39\" viewBox=\"0 0 39 39\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"\u003E\u003Ccircle class=\"color-element\" cx=\"19.4395\" cy=\"19.4395\" r=\"19.4395\" fill=\"#49E670\"/\u003E\u003Cpath d=\"M12.9821 10.1115C12.7029 10.7767 11.5862 11.442 10.7486 11.575C10.1902 11.7081 9.35269 11.8411 6.84003 10.7767C3.48981 9.44628 1.39593 6.25317 1.25634 6.12012C1.11674 5.85403 2.13001e-06 4.39053 2.13001e-06 2.92702C2.13001e-06 1.46351 0.83755 0.665231 1.11673 0.399139C1.39592 0.133046 1.8147 1.01506e-06 2.23348 1.01506e-06C2.37307 1.01506e-06 2.51267 1.01506e-06 2.65226 1.01506e-06C2.93144 1.01506e-06 3.21063 -2.02219e-06 3.35022 0.532183C3.62941 1.19741 4.32736 2.66092 4.32736 2.79397C4.46696 2.92702 4.46696 3.19311 4.32736 3.32616C4.18777 3.59225 4.18777 3.59224 3.90858 3.85834C3.76899 3.99138 3.6294 4.12443 3.48981 4.39052C3.35022 4.52357 3.21063 4.78966 3.35022 5.05576C3.48981 5.32185 4.18777 6.38622 5.16491 7.18449C6.42125 8.24886 7.39839 8.51496 7.81717 8.78105C8.09636 8.91409 8.37554 8.9141 8.65472 8.648C8.93391 8.38191 9.21309 7.98277 9.49228 7.58363C9.77146 7.31754 10.0507 7.1845 10.3298 7.31754C10.609 7.45059 12.2841 8.11582 12.5633 8.38191C12.8425 8.51496 13.1217 8.648 13.1217 8.78105C13.1217 8.78105 13.1217 9.44628 12.9821 10.1115Z\" transform=\"translate(12.9597 12.9597)\" fill=\"#FAFAFA\"/\u003E\u003Cpath d=\"M0.196998 23.295L0.131434 23.4862L0.323216 23.4223L5.52771 21.6875C7.4273 22.8471 9.47325 23.4274 11.6637 23.4274C18.134 23.4274 23.4274 18.134 23.4274 11.6637C23.4274 5.19344 18.134 -0.1 11.6637 -0.1C5.19344 -0.1 -0.1 5.19344 -0.1 11.6637C-0.1 13.9996 0.624492 16.3352 1.93021 18.2398L0.196998 23.295ZM5.87658 19.8847L5.84025 19.8665L5.80154 19.8788L2.78138 20.8398L3.73978 17.9646L3.75932 17.906L3.71562 17.8623L3.43104 17.5777C2.27704 15.8437 1.55796 13.8245 1.55796 11.6637C1.55796 6.03288 6.03288 1.55796 11.6637 1.55796C17.2945 1.55796 21.7695 6.03288 21.7695 11.6637C21.7695 17.2945 17.2945 21.7695 11.6637 21.7695C9.64222 21.7695 7.76778 21.1921 6.18227 20.039L6.17557 20.0342L6.16817 20.0305L5.87658 19.8847Z\" transform=\"translate(7.7758 7.77582)\" fill=\"white\" stroke=\"white\" stroke-width=\"0.2\"/\u003E\u003C/svg\u003E","is_desktop":1,"is_mobile":1,"icon_color":"#49E670","icon_rgb_color":"73,230,112","channel_type":"Whatsapp","custom_image_url":"","order":"","pre_set_message":"","is_use_web_version":"1","is_open_new_tab":"1","is_default_open":"0","has_welcome_message":"1","emoji_picker":"1","input_placeholder":"Write your message...","chat_welcome_message":"\u003Cp\u003EHow can I help you? :)\u003C/p\u003E","wp_popup_headline":"Let&#039;s chat on WhatsApp","wp_popup_nickname":"Team C11CL","wp_popup_profile":"https://c11cl.com/wp-content/uploads/2025/05/favicon-2.png","wp_popup_head_bg_color":"#4AA485","qr_code_image_url":"","mail_subject":"","channel_account_type":"personal","contact_form_settings":[],"contact_fields":[],"url":"https://web.whatsapp.com/send?phone=919211760909","mobile_target":"","desktop_target":"_blank","target":"_blank","is_agent":0,"agent_data":[],"header_text":"","header_sub_text":"","header_bg_color":"","header_text_color":"","widget_token":"2d0ab63012","widget_index":"","click_event":"","viber_url":""},{"channel":"Instagram","value":"c11cl_official/","hover_text":"Instagram Page","chatway_position":"","svg_icon":"\u003Csvg width=\"39\" height=\"39\" viewBox=\"0 0 39 39\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"\u003E\u003Ccircle class=\"color-element\" cx=\"19.5\" cy=\"19.5\" r=\"19.5\" fill=\"url(#linear-gradient)\"/\u003E\u003Cpath id=\"Path_1923\" data-name=\"Path 1923\" d=\"M13.177,0H5.022A5.028,5.028,0,0,0,0,5.022v8.155A5.028,5.028,0,0,0,5.022,18.2h8.155A5.028,5.028,0,0,0,18.2,13.177V5.022A5.028,5.028,0,0,0,13.177,0Zm3.408,13.177a3.412,3.412,0,0,1-3.408,3.408H5.022a3.411,3.411,0,0,1-3.408-3.408V5.022A3.412,3.412,0,0,1,5.022,1.615h8.155a3.412,3.412,0,0,1,3.408,3.408v8.155Z\" transform=\"translate(10 10.4)\" fill=\"#fff\"/\u003E\u003Cpath id=\"Path_1924\" data-name=\"Path 1924\" d=\"M45.658,40.97a4.689,4.689,0,1,0,4.69,4.69A4.695,4.695,0,0,0,45.658,40.97Zm0,7.764a3.075,3.075,0,1,1,3.075-3.075A3.078,3.078,0,0,1,45.658,48.734Z\" transform=\"translate(-26.558 -26.159)\" fill=\"#fff\"/\u003E\u003C/svg\u003E\u003Cpath id=\"Path_1925\" data-name=\"Path 1925\" d=\"M120.105,28.251a1.183,1.183,0,1,0,.838.347A1.189,1.189,0,0,0,120.105,28.251Z\" transform=\"translate(-96.119 -14.809)\" fill=\"#fff\"/\u003E","is_desktop":1,"is_mobile":1,"icon_color":"#ffffff","icon_rgb_color":"0,0,0","channel_type":"Instagram","custom_image_url":"","order":"","pre_set_message":"","is_use_web_version":"1","is_open_new_tab":"1","is_default_open":"0","has_welcome_message":"0","emoji_picker":"1","input_placeholder":"Write your message...","chat_welcome_message":"","wp_popup_headline":"","wp_popup_nickname":"","wp_popup_profile":"","wp_popup_head_bg_color":"#4AA485","qr_code_image_url":"","mail_subject":"","channel_account_type":"personal","contact_form_settings":[],"contact_fields":[],"url":"https://www.instagram.com/c11cl_official/","mobile_target":"_blank","desktop_target":"_blank","target":"_blank","is_agent":0,"agent_data":[],"header_text":"","header_sub_text":"","header_bg_color":"","header_text_color":"","widget_token":"2d0ab63012","widget_index":"","click_event":"","viber_url":""}]}],"data_analytics_settings":"off","lang":{"whatsapp_label":"WhatsApp Message","hide_whatsapp_form":"Hide WhatsApp Form","emoji_picker":"Show Emojis"},"has_chatway":""};
//# sourceURL=chaty-front-end-js-extra
</script>
<script defer src="../wp-content/plugins/chaty/js/cht-front-script.mina7d3.js?ver=3.5.11768552451" id="chaty-front-end-js"></script>
<script src="../wp-content/plugins/chaty/admin/assets/js/picmo-umd.min9d52.js?ver=3.5.1" id="chaty-picmo-js-js"></script>
<script src="../wp-content/plugins/chaty/admin/assets/js/picmo-latest-umd.min9d52.js?ver=3.5.1" id="chaty-picmo-latest-js-js"></script>
<script src="../wp-content/plugins/happy-elementor-addons/assets/js/extension-reading-progress-bar.minb645.js?ver=3.20.8" id="happy-reading-progress-bar-js"></script>
<script id="eael-general-js-extra">
var localize = {"ajaxurl":"https://c11cl.com/wp-admin/admin-ajax.php","nonce":"481c46a9c7","i18n":{"added":"Added ","compare":"Compare","loading":"Loading..."},"eael_translate_text":{"required_text":"is a required field","invalid_text":"Invalid","billing_text":"Billing","shipping_text":"Shipping","fg_mfp_counter_text":"of"},"page_permalink":"https://c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/","cart_redirectition":"","cart_page_url":"","el_breakpoints":{"mobile":{"label":"Mobile Portrait","value":767,"default_value":767,"direction":"max","is_enabled":true},"mobile_extra":{"label":"Mobile Landscape","value":880,"default_value":880,"direction":"max","is_enabled":false},"tablet":{"label":"Tablet Portrait","value":1024,"default_value":1024,"direction":"max","is_enabled":true},"tablet_extra":{"label":"Tablet Landscape","value":1200,"default_value":1200,"direction":"max","is_enabled":false},"laptop":{"label":"Laptop","value":1366,"default_value":1366,"direction":"max","is_enabled":false},"widescreen":{"label":"Widescreen","value":2400,"default_value":2400,"direction":"min","is_enabled":false}}};
//# sourceURL=eael-general-js-extra
</script>
<script src="../wp-content/plugins/essential-addons-for-elementor-lite/assets/front-end/js/view/general.min3a22.js?ver=6.5.10" id="eael-general-js"></script>
<script id="bdt-uikit-js-extra">
var element_pack_ajax_login_config = {"ajaxurl":"https://c11cl.com/wp-admin/admin-ajax.php","language":"en","loadingmessage":"Sending user info, please wait...","unknownerror":"Unknown error, make sure access is correct!"};
var ElementPackConfig = {"ajaxurl":"https://c11cl.com/wp-admin/admin-ajax.php","nonce":"d80e46ba26","data_table":{"language":{"lengthMenu":"Show _MENU_ Entries","info":"Showing _START_ to _END_ of _TOTAL_ entries","search":"Search :","paginate":{"previous":"Previous","next":"Next"}}},"contact_form":{"sending_msg":"Sending message please wait...","captcha_nd":"Invisible captcha not defined!","captcha_nr":"Could not get invisible captcha response!"},"mailchimp":{"subscribing":"Subscribing you please wait..."},"search":{"more_result":"More Results","search_result":"SEARCH RESULT","not_found":"not found"},"words_limit":{"read_more":"[read more]","read_less":"[read less]"},"elements_data":{"sections":[],"columns":[],"widgets":[]}};
//# sourceURL=bdt-uikit-js-extra
</script>
<script src="../wp-content/plugins/bdthemes-element-pack-lite/assets/js/bdt-uikit.min4ecf.js?ver=3.21.7" id="bdt-uikit-js"></script>
<script src="../wp-content/plugins/bdthemes-element-pack-lite/assets/js/common/helper.min7945.js?ver=8.3.19" id="element-pack-helper-js"></script>
<script src="../wp-content/plugins/elementor/assets/js/webpack.runtime.min5be5.js?ver=3.35.3" id="elementor-webpack-runtime-js"></script>
<script src="../wp-content/plugins/elementor/assets/js/frontend-modules.min5be5.js?ver=3.35.3" id="elementor-frontend-modules-js"></script>
<script src="../wp-includes/js/jquery/ui/core.minb37e.js?ver=1.13.3" id="jquery-ui-core-js"></script>
<script id="elementor-frontend-js-extra">
var EAELImageMaskingConfig = {"svg_dir_url":"https://c11cl.com/wp-content/plugins/essential-addons-for-elementor-lite/assets/front-end/img/image-masking/svg-shapes/"};
//# sourceURL=elementor-frontend-js-extra
</script>
<script id="elementor-frontend-js-before">
var elementorFrontendConfig = {"environmentMode":{"edit":false,"wpPreview":false,"isScriptDebug":false},"i18n":{"shareOnFacebook":"Share on Facebook","shareOnTwitter":"Share on Twitter","pinIt":"Pin it","download":"Download","downloadImage":"Download image","fullscreen":"Fullscreen","zoom":"Zoom","share":"Share","playVideo":"Play Video","previous":"Previous","next":"Next","close":"Close","a11yCarouselPrevSlideMessage":"Previous slide","a11yCarouselNextSlideMessage":"Next slide","a11yCarouselFirstSlideMessage":"This is the first slide","a11yCarouselLastSlideMessage":"This is the last slide","a11yCarouselPaginationBulletMessage":"Go to slide"},"is_rtl":false,"breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"responsive":{"breakpoints":{"mobile":{"label":"Mobile Portrait","value":767,"default_value":767,"direction":"max","is_enabled":true},"mobile_extra":{"label":"Mobile Landscape","value":880,"default_value":880,"direction":"max","is_enabled":false},"tablet":{"label":"Tablet Portrait","value":1024,"default_value":1024,"direction":"max","is_enabled":true},"tablet_extra":{"label":"Tablet Landscape","value":1200,"default_value":1200,"direction":"max","is_enabled":false},"laptop":{"label":"Laptop","value":1366,"default_value":1366,"direction":"max","is_enabled":false},"widescreen":{"label":"Widescreen","value":2400,"default_value":2400,"direction":"min","is_enabled":false}},"hasCustomBreakpoints":false},"version":"3.35.3","is_static":false,"experimentalFeatures":{"e_font_icon_svg":true,"additional_custom_breakpoints":true,"container":true,"nested-elements":true,"home_screen":true,"global_classes_should_enforce_capabilities":true,"e_variables":true,"cloud-library":true,"e_opt_in_v4_page":true,"e_components":true,"e_interactions":true,"e_editor_one":true,"import-export-customization":true},"urls":{"assets":"https:\/\/c11cl.com\/wp-content\/plugins\/elementor\/assets\/","ajaxurl":"https:\/\/c11cl.com\/wp-admin\/admin-ajax.php","uploadUrl":"https:\/\/c11cl.com\/wp-content\/uploads"},"nonces":{"floatingButtonsClickTracking":"756722ec57"},"swiperClass":"swiper","settings":{"page":{"ha_cmc_init_switcher":"no"},"editorPreferences":[]},"kit":{"active_breakpoints":["viewport_mobile","viewport_tablet"],"global_image_lightbox":"yes","lightbox_enable_counter":"yes","lightbox_enable_fullscreen":"yes","lightbox_enable_zoom":"yes","lightbox_enable_share":"yes","lightbox_title_src":"title","lightbox_description_src":"description","ha_rpb_enable":"no"},"post":{"id":3402,"title":"The%20Business%20of%20Cricket%3A%20How%20Leagues%20Are%20Changing%20India%E2%80%99s%20Sports%20Landscape%20-%20C11CL","excerpt":"Cricket League India boosts the gentleman\u2019s game development not only in India but also abroad. It offers financial support and global opportunities for emerging talents.","featuredImage":"https:\/\/c11cl.com\/wp-content\/uploads\/2026\/02\/Leagues-are-changing-Indian-Cricket.jpeg"}};
//# sourceURL=elementor-frontend-js-before
</script>
<script src="../wp-content/plugins/elementor/assets/js/frontend.min5be5.js?ver=3.35.3" id="elementor-frontend-js"></script>
<script src="../wp-content/plugins/elementor/assets/lib/font-awesome/js/v4-shims.min3a22.js?ver=6.5.10" id="font-awesome-4-shim-js"></script>
<script src="../wp-content/plugins/elementskit-lite/widgets/init/assets/js/animate-circle.minc480.js?ver=3.7.9" id="animate-circle-js"></script>
<script id="elementskit-elementor-js-extra">
var ekit_config = {"ajaxurl":"https://c11cl.com/wp-admin/admin-ajax.php","nonce":"ed4e423a47"};
//# sourceURL=elementskit-elementor-js-extra
</script>
<script data-minify="1" src="../wp-content/cache/min/1/wp-content/plugins/elementskit-lite/widgets/init/assets/js/elementorbe33.js?ver=1771070146" id="elementskit-elementor-js"></script>
			<script>
			/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
			</script>
			<script id="wp-emoji-settings" type="application/json">
{"baseUrl":"https://s.w.org/images/core/emoji/17.0.2/72x72/","ext":".png","svgUrl":"https://s.w.org/images/core/emoji/17.0.2/svg/","svgExt":".svg","source":{"concatemoji":"https://c11cl.com/wp-includes/js/wp-emoji-release.min.js?ver=6.9.1"}}
</script>
<script type="module">
/*! This file is auto-generated */
const a=JSON.parse(document.getElementById("wp-emoji-settings").textContent),o=(window._wpemojiSettings=a,"wpEmojiSettingsSupports"),s=["flag","emoji"];function i(e){try{var t={supportTests:e,timestamp:(new Date).valueOf()};sessionStorage.setItem(o,JSON.stringify(t))}catch(e){}}function c(e,t,n){e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(t,0,0);t=new Uint32Array(e.getImageData(0,0,e.canvas.width,e.canvas.height).data);e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(n,0,0);const a=new Uint32Array(e.getImageData(0,0,e.canvas.width,e.canvas.height).data);return t.every((e,t)=>e===a[t])}function p(e,t){e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(t,0,0);var n=e.getImageData(16,16,1,1);for(let e=0;e<n.data.length;e++)if(0!==n.data[e])return!1;return!0}function u(e,t,n,a){switch(t){case"flag":return n(e,"\ud83c\udff3\ufe0f\u200d\u26a7\ufe0f","\ud83c\udff3\ufe0f\u200b\u26a7\ufe0f")?!1:!n(e,"\ud83c\udde8\ud83c\uddf6","\ud83c\udde8\u200b\ud83c\uddf6")&&!n(e,"\ud83c\udff4\udb40\udc67\udb40\udc62\udb40\udc65\udb40\udc6e\udb40\udc67\udb40\udc7f","\ud83c\udff4\u200b\udb40\udc67\u200b\udb40\udc62\u200b\udb40\udc65\u200b\udb40\udc6e\u200b\udb40\udc67\u200b\udb40\udc7f");case"emoji":return!a(e,"\ud83e\u1fac8")}return!1}function f(e,t,n,a){let r;const o=(r="undefined"!=typeof WorkerGlobalScope&&self instanceof WorkerGlobalScope?new OffscreenCanvas(300,150):document.createElement("canvas")).getContext("2d",{willReadFrequently:!0}),s=(o.textBaseline="top",o.font="600 32px Arial",{});return e.forEach(e=>{s[e]=t(o,e,n,a)}),s}function r(e){var t=document.createElement("script");t.src=e,t.defer=!0,document.head.appendChild(t)}a.supports={everything:!0,everythingExceptFlag:!0},new Promise(t=>{let n=function(){try{var e=JSON.parse(sessionStorage.getItem(o));if("object"==typeof e&&"number"==typeof e.timestamp&&(new Date).valueOf()<e.timestamp+604800&&"object"==typeof e.supportTests)return e.supportTests}catch(e){}return null}();if(!n){if("undefined"!=typeof Worker&&"undefined"!=typeof OffscreenCanvas&&"undefined"!=typeof URL&&URL.createObjectURL&&"undefined"!=typeof Blob)try{var e="postMessage("+f.toString()+"("+[JSON.stringify(s),u.toString(),c.toString(),p.toString()].join(",")+"));",a=new Blob([e],{type:"text/javascript"});const r=new Worker(URL.createObjectURL(a),{name:"wpTestEmojiSupports"});return void(r.onmessage=e=>{i(n=e.data),r.terminate(),t(n)})}catch(e){}i(n=f(s,u,c,p))}t(n)}).then(e=>{for(const n in e)a.supports[n]=e[n],a.supports.everything=a.supports.everything&&a.supports[n],"flag"!==n&&(a.supports.everythingExceptFlag=a.supports.everythingExceptFlag&&a.supports[n]);var t;a.supports.everythingExceptFlag=a.supports.everythingExceptFlag&&!a.supports.flag,a.supports.everything||((t=a.source||{}).concatemoji?r(t.concatemoji):t.wpemoji&&t.twemoji&&(r(t.twemoji),r(t.wpemoji)))});
//# sourceURL=https://c11cl.com/wp-includes/js/wp-emoji-loader.min.js
</script>



	</body>

<!-- Mirrored from c11cl.com/the-business-of-cricket-how-leagues-are-changing-indias-sports-landscape/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Mar 2026 16:54:27 GMT -->
</html>


<!-- Page cached by LiteSpeed Cache 7.7 on 2026-02-14 14:12:27 -->
<!-- This website is like a Rocket, isn't it? Performance optimized by WP Rocket. Learn more: https://wp-rocket.me - Debug: cached@1771078347 -->