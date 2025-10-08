<?php snippet('header') ?>
<main>
<?php snippet('post-intro') ?>
<section class="content">
  <?= $page->blocks()->toBlocks() ?>
</section>
<section id="signup-module" class="module-signup">
  <div class="grid">
    <div class="content-signup">
      <?php snippet('signup'); ?>
    </div>
  </div>
</section>
<?php snippet('nav-more') ?>
</main>
<?php snippet('footer') ?>