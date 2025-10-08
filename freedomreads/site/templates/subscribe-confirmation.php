<?php snippet('header') ?>
<main>
<?php snippet('hero') ?>
<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
  <div class="blocks grid">
    <form id="neon-signup" class="message">
      <?= $page->blocks()->toBlocks() ?>
</form>
    <div class="sidebar">
        <?= $site->find('subscribe')->blocks()->toBlocks() ?>
        <a href="" class="btn btn-page">Read more</a>
    </div> 
  </div>
</section>
</main>
<?php snippet('footer') ?>