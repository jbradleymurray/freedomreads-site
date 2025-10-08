<?php snippet('header') ?>
<section class="intro">
   <div class="grid">
      <?php if ($page->hero()->isNotEmpty()): ?>
      <div class="img-wrapper-hero"> 
        <figure style="background-image:url('<?= $page->hero()->toFile()->url(); ?>');"></figure>
      </div>
      <?php endif ?>
      <div class="title">
        <h1><?= $page->title(); ?></h1>
      </div>
    </div>
</section>
<section class="content">
  <?= $page->blocks()->toBlocks() ?>
</section>
<section class="others">
  <a class="btn-page" href="<?= $page->parent()->url()?>">Other Posts</a>
</section>
<?php snippet('footer') ?>