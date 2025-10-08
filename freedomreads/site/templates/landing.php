<?php snippet('header') ?>
<main>
<?php snippet('hero') ?>
<?php snippet('page-intro', ['landing'=>true]) ?>
<section class="content">
  <div class="blocks">
    <?= $page->blocks()->toBlocks() ?>
  </div>
</section>
  <?php if ($page->slug() != 'donate' ): ?>
    <?php snippet('map') ?>
  <?php endif?>
</main>
<?php snippet('footer') ?>