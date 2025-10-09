<?php snippet('header') ?>
<main>
<?php snippet('hero') ?>
<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
  <div class="blocks grid">
 

    <?php if ($page->slug() == 'subscribe' ): //form ?>
      <?php snippet('form-email') ?>
    <?php else: //confirmation 
      $page = $site->find('subscribe'); ?> 
    <?php endif?>
    <div class="sidebar">
        <?= $page->blocks()->toBlocks() ?>
        <a href="<?= $site->url()?>/news/newsletter" class="btn btn-page">Read more</a>
    </div> 
  </div>
</section>
</main>
<?php snippet('footer') ?>