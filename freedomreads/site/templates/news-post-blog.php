<?php snippet('header') ?>
<main>
<?php snippet('post-intro') ?>
<section class="content">  
  <div class="grid">
    <div class="content-text">
      <?= $page->introduction()->kirbytext(); ?>
    </div>
  </div>
  <?= $page->blocks()->toBlocks() ?>
</section>
<?php snippet('nav-more') ?>
</main>
<?php snippet('footer') ?>