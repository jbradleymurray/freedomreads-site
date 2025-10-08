<?php snippet('header') ?>
<main>
<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
  <div class="grid entry-list">
    <?php snippet('entry-list', ['paginate'=>true]) ?>
  </div>
</section>
</main>
<?php snippet('footer') ?>