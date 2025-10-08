<?php snippet('header') ?>
<main>
<?php snippet('hero') ?>
<?php snippet('page-intro', ['landing'=>true]) ?>
<section class="content">
  <div class="blocks">
    <div class="intro">
      <?= $page->intro()->toBlocks() ?>
    </div>
    <?php if ($page->video()->isNotEmpty()): ?>
      <div class="video">
        <?= $page->video()->toBlocks() ?>
      <?php endif ?>
    </div>
  </div>
</section>
<section class="freedom-libraries">
  <?php if ($page->library()->isNotEmpty()): ?>
    <?= $page->library()->toBlocks() ?>
  <?php endif ?>
</section>
<?php snippet('map') ?>

<?php if ($page->recent_media()->isNotEmpty()): ?>
<section class="recent-media">
  <div class="grid blockquote-wrapper">
    <?= $page->recent_media()->toBlocks() ?>
  </div>
</section>
<?php endif ?>


<?php if ($page->carousel()->isNotEmpty()): ?>
<section class="press-images">
  <?= $page->carousel()->toBlocks() ?>
</section>
<?php endif ?>

<?php if ($page->press_people()->isNotEmpty()): ?>
<section class="press-people people">  
  <div class="grid">
  <?= $page->press_people()->toBlocks() ?>
  </div>
</section>
<?php endif ?>

<?php if ($page->contact()->isNotEmpty()): ?>
<section class="contact">
  <div class="grid">
    <h2>Contact</h2>
    <div class="info">     
      <h3>Freedom Reads</h3>
      <?= $pages->find('contact')->address()->kirbytext() ?>
      <div class="social-links dark">
        <h3>Follow Us</h3>
        <?php snippet('social-links') ?>
       </div>
    </div>
    <?= $page->contact()->toBlocks() ?> 
  </div>
</section>
<?php endif ?>
</section>
</main>
<?php snippet('footer') ?>