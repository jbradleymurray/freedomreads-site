<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <?php if ($kirby->option('environment') == 'dev' || $page->status() == 'unlisted'): ?>
        <meta name="robots" content="noindex, nofollow">
    <?php else: ?>
        <meta name="robots" content="index, follow">
    <?php endif; ?>

    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <?php
    if ($page->introduction()->isNotEmpty()) {
        $description = strip_tags($page->introduction()->kirbytext());
    } else {
        $description = $site->seodescription();
    }
    $socialshareimg = "";

    if ($page->featureimg()->isNotEmpty()) {
        $socialimg = $page->featureimg()->toFile();
    } else if ($page->hero()->toFile()) {
        $socialimg = $page->hero()->toFile();
    } else if ($site->socialshare()->isNotEmpty()) {
        $socialimg = $site->socialshare()->toFile();
    }
    if ($socialimg) {
        $socialshareimg = $socialimg->thumb([
            'width' => 1200,
            'height' => 626,
            'crop' => 'center',
            'format' => 'webp',
            'quality' => 100
        ])->url();
    }
    ?>
    <?php
    $metatitle = $page->title()->esc() .' | ' . $site->title()->esc();
    if ($page->template() == 'home') {
        $metatitle = $site->title()->esc();
        $description = $site->seodescription();
    }
    ?>

    <!-- HTML Meta Tags -->
    <title><?= $metatitle ?></title>
    <meta name="description" content="<?= $description ?>">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="<?= $page->url() ?>" />
    <meta property="og:title" content="<?= $metatitle ?>">
    <meta property="og:description" content="<?= $description ?>">
    <meta property="og:image" content="<?= $socialshareimg ?>" />
    <?php if ($page->template() == 'news-post-blog' || $page->template() == 'news-post-pr'): ?>
        <meta property="og:type" content="article" />
    <?php else: ?>
        <meta property="og:type" content="website" />
    <?php endif; ?>

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@million_book">
    <meta name="twitter:domain" content="freedomreads.org">
    <meta name="twitter:url" content="<?= $page->url() ?>">
    <meta name="twitter:title" content="<?= $metatitle ?>">
    <meta name="twitter:description" content="<?= $description ?>">
    <meta name="twitter:image" content="<?= $socialshareimg ?>">

    <?= css([
        'assets/css/slick.css',
        'assets/css/main.css',
        '@auto'
    ]) ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?= url('favicon.svg') ?>">

    <?php if ($kirby->option('environment') == 'prod'): ?>
        <link rel="canonical" href="<?= $page->url() ?>" />
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NKSZCM8Z');</script>
        <!-- End Google Tag Manager -->
    <?php endif; ?>
   	<!-- Start cookieyes banner -->
    <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/287ab948e0835b17321e5ed3/script.js"></script>
    <!-- End cookieyes banner -->
</head>
<body id="<?=$page->slug();?>" class="template-<?= $page->template()?> <?php if($page->parent()): echo($page->parent()->slug() ); else: echo( $page->slug() ); endif;?>">
<style>
    .cky-consent-container,
    .cky-modal.cky-modal-open {
        font-family: 'Metric2';
        font-weight: 700;
        background-color: #F2EBE8;
    }
    .cky-btn {
        font-family: 'Metric2';
        background-color: #292424;
        font-weight: 700;
        font-size: 20px;
    }
    .cky-btn-reject,.cky-btn-customize,.cky-btn-preferences {
        border: 4px solid #292424;
    }
   .cky-preference-body-wrapper, .cky-accordion-wrapper, .cky-accordion, .cky-accordion-wrapper, .cky-footer-wrapper, .cky-prefrence-btn-wrapper {
        border-color: #292424;
    }
    .cky-preference-header {
        border: 0;
    }
    .cky-preference-content-wrapper .cky-show-desc-btn,
    button.cky-show-desc-btn:not(:hover):not(:active),
    .cky-accordion-header .cky-always-active {
        color: #993E0B;
    }
    .cky-audit-table .cky-cookie-des-table,
    .cky-audit-table .cky-empty-cookies-text {
        background-color: #e7ddd9;
    }
    .cky-audit-table .cky-cookie-des-table {
        border-bottom-color: #F2EBE8;

    }

    .cky-btn-revisit-wrapper.cky-revisit-bottom-left {
        background: transparent;
    }
    .cky-btn-revisit-wrapper {
        background: transparent;
        position: absolute;
        width: auto;
        height: auto;
        z-index: 99; /*to position it below the navigation when it is open */
    }
    .cky-btn-revisit::before {
        content: "Manage my Cookies";
        color: #fff;
        font-family: 'Metric2';
        padding: 3px 7px; 
        background-color: #807070;
    }
    .cky-btn-revisit-wrapper .cky-btn-revisit img {
        display: none;
    }
    .cky-revisit-bottom-left {
        left: auto;
        right: 0;
        bottom: 0;
    }
    
</style>
<header>
    <?php snippet('nav') ?>
</header>
