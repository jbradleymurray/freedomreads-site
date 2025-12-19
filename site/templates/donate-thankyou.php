<?php
// Check if this is version 1 or version 2 based on the page slug
$isVersion1 = strpos($page->slug(), 'v1') !== false;
$pageUrl = $page->url();
$siteUrl = $site->url();
?>
<?php snippet('header') ?>
<main class="donate-thankyou <?= $isVersion1 ? 'version-1' : 'version-2' ?>">
    <?php if ($isVersion1): ?>
        <!-- Version 1: Neon-style centered card -->
        <section class="thankyou-neon-style">
            <div class="thankyou-card">

                <?php if(isset($_GET['amount']) && $_GET['amount']): ?>
                    <div class="donation-amount">
                        $<?= number_format((float)$_GET['amount'], 2) ?>
                    </div>
                <?php endif; ?>

                <h1 class="thankyou-heading"><?= $page->herotext() ?></h1>

                <div class="thankyou-message">
                    <?php if(isset($_GET['name']) && $_GET['name']): ?>
                        <p><strong>{{<?= htmlspecialchars($_GET['name']) ?>}}</strong>, <?= nl2br($page->introduction()) ?></p>
                    <?php else: ?>
                        <p><?= nl2br($page->introduction()) ?></p>
                    <?php endif; ?>
                </div>

                <div class="share-section">
                    <hr class="share-divider">
                    <p class="share-label">Share with friends</p>
                    <div class="social-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($siteUrl . '/donate') ?>" target="_blank" rel="noopener" class="social-btn facebook" aria-label="Share on Facebook">
                            <svg width="10" height="18" viewBox="0 0 10 18" fill="white" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 0H6.5C5.57 0 4.69 0.37 4.05 1.05C3.37 1.69 3 2.57 3 3.5V6H0v4h3v8h4v-8h3l1-4H7V3.5C7 3.22 7.22 3 7.5 3H9V0Z" fill="white"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode($siteUrl . '/donate') ?>&text=<?= urlencode('I just supported Freedom Reads!') ?>" target="_blank" rel="noopener" class="social-btn twitter" aria-label="Share on X (Twitter)">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="white" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.5 0.5H16L10.5 7L17 17.5H12L8 11.5L3.5 17.5H1L7 10L1 0.5H6L9.5 6L13.5 0.5ZM12.5 16H14L5.5 2H4L12.5 16Z" fill="white"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($siteUrl . '/donate') ?>" target="_blank" rel="noopener" class="social-btn linkedin" aria-label="Share on LinkedIn">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="white" xmlns="http://www.w3.org/2000/svg">
                                <text x="1" y="14" font-family="Arial, sans-serif" font-size="14" font-weight="bold" fill="white">ln</text>
                            </svg>
                        </a>
                        <a href="mailto:?subject=<?= urlencode('Support Freedom Reads') ?>&body=<?= urlencode('I just supported Freedom Reads. Join me in helping bring books to incarcerated individuals: ' . $siteUrl . '/donate') ?>" class="social-btn email" aria-label="Share via Email">
                            <svg width="18" height="14" viewBox="0 0 18 14" fill="white" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 0H2C0.9 0 0.01 0.9 0.01 2L0 12C0 13.1 0.9 14 2 14H16C17.1 14 18 13.1 18 12V2C18 0.9 17.1 0 16 0ZM16 4L9 8L2 4V2L9 6L16 2V4Z" fill="white"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php else: ?>
        <!-- Version 2: Site-branded design -->
        <div class="grid">
            <section class="thankyou-intro">
                <div class="text">
                    <div class="success-indicator">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="30" r="28" fill="#993E0B"/>
                            <path d="M18 30 L26 38 L42 22" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                    </div>
                    <h1><?= $page->herotext() ?></h1>
                    <?php if(isset($_GET['amount']) && $_GET['amount']): ?>
                        <p class="donation-amount-v2">
                            Donation Amount: <strong>$<?= number_format((float)$_GET['amount'], 2) ?></strong>
                        </p>
                    <?php endif; ?>
                    <p class="p-intro"><?= $page->introduction()->kirbytextinline(); ?></p>

                    <div class="thankyou-body">
                        <?= $page->blocks()->toBlocks() ?>
                    </div>

                    <div class="thankyou-actions">
                        <a href="<?= $site->url() ?>" class="btn-page">Return to Home</a>
                        <a href="<?= $site->url() ?>/news" class="btn-page">Read Our Stories</a>
                    </div>

                    <div class="social-share-section">
                        <p class="share-label">Share your support</p>
                        <ul class="social-links-thankyou">
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($siteUrl . '/donate') ?>" target="_blank" rel="noopener" aria-label="Share on Facebook">
                                    <svg width="12" height="23" viewBox="0 0 12 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.42383 3.81836C8.92383 3.81836 8.528 3.9082 8.23633 4.08789C7.94466 4.26758 7.75716 4.49219 7.67383 4.76172C7.59049 5.03125 7.54883 5.37565 7.54883 5.79492V8.625H11.0905L10.5905 12.7129H7.54883V23H3.63216V12.7129H0.423828V8.625H3.63216V5.39062C3.63216 3.68359 4.0766 2.3584 4.96549 1.41504C5.85439 0.471675 7.03493 0 8.50716 0C9.70161 0 10.6738 0.0598949 11.4238 0.179688V3.81836H9.42383Z" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/intent/tweet?url=<?= urlencode($siteUrl . '/donate') ?>&text=<?= urlencode('I just supported Freedom Reads!') ?>" target="_blank" rel="noopener" aria-label="Share on X (Twitter)">
                                    <svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.0521332 0.473755L8.32399 11.5338L0 20.5262H1.87354L9.16135 12.6531L15.0495 20.5262H21.4248L12.6873 8.84412L20.4353 0.473755H18.5618L11.8503 7.72453L6.42744 0.473755H0.0521332ZM2.80726 1.85366H5.73605L18.6693 19.1463H15.7405L2.80726 1.85366Z" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($siteUrl . '/donate') ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn">
                                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.22222 20.5H17.7778C19.0051 20.5 20 19.5051 20 18.2778V2.72222C20 1.49492 19.0051 0.5 17.7778 0.5H2.22222C0.994923 0.5 0 1.49492 0 2.72222V18.2778C0 19.5051 0.994923 20.5 2.22222 20.5Z" />
                                        <path class="knockout" fill-rule="evenodd" clip-rule="evenodd" d="M17.2218 17.7223H14.2539V12.6673C14.2539 11.2814 13.7273 10.5069 12.6303 10.5069C11.437 10.5069 10.8135 11.3129 10.8135 12.6673V17.7223H7.95327V8.09265H10.8135V9.38976C10.8135 9.38976 11.6735 7.79845 13.7169 7.79845C15.7595 7.79845 17.2218 9.04574 17.2218 11.6254V17.7223ZM4.54105 6.83172C3.5668 6.83172 2.77734 6.03607 2.77734 5.05478C2.77734 4.07349 3.5668 3.27783 4.54105 3.27783C5.5153 3.27783 6.30429 4.07349 6.30429 5.05478C6.30429 6.03607 5.5153 6.83172 4.54105 6.83172ZM3.06416 17.7223H6.04662V8.09265H3.06416V17.7223Z" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:?subject=<?= urlencode('Support Freedom Reads') ?>&body=<?= urlencode('I just supported Freedom Reads. Join me in helping bring books to incarcerated individuals: ' . $siteUrl . '/donate') ?>" aria-label="Share via Email">
                                    <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 0H2C0.9 0 0.01 0.9 0.01 2L0 12C0 13.1 0.9 14 2 14H16C17.1 14 18 13.1 18 12V2C18 0.9 17.1 0 16 0ZM16 4L9 8L2 4V2L9 6L16 2V4Z" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    <?php endif; ?>
</main>

<?php if ($isVersion1 && isset($_GET['amount']) && $_GET['amount']): ?>
<script>
  fbq('track', 'Purchase', {
    currency: 'USD',
    value: <?= number_format((float)$_GET['amount'], 2, '.', '') ?>
  });
</script>
<?php elseif ($isVersion1): ?>
<script>
  fbq('track', 'Purchase', {
    currency: 'USD'
  });
</script>
<?php endif; ?>

<?php snippet('footer') ?>
