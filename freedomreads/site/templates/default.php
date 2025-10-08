<?php snippet('header') ?>
<main>
<?php snippet('hero') ?>
<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
  <?php if( $page->slug() == 'kites-from-the-inside'):?>
    <div class="kite-bg">
      <div class="kite-crop">
        <div class="kite-image" data-scroll-speed="2">
          <img src="/assets/img/kite-01.png">
        </div>
      </div>
      <div class="kite-crop">
        <div class="kite-image" data-scroll-speed="5">
          <img src="/assets/img/kite-02.png">
        </div>
      </div>
      <div class="kite-crop">
        <div class="kite-image" data-scroll-speed="11">
          <img src="/assets/img/kite-03.png">
        </div>
      </div>
      <div class="kite-crop">
        <div class="kite-image" data-scroll-speed="1">
          <img src="/assets/img/kite-04.png">
        </div>
      </div>
      <div class="kite-crop">
        <div class="kite-image" data-scroll-speed="6">
          <img src="/assets/img/kite-05.png">
        </div>
      </div>
      <div class="kite-crop">
        <div class="kite-image" data-scroll-speed="3">
          <img src="/assets/img/kite-06.png">
        </div>
      </div>
      <div class="kite-crop">
        <div class="kite-image" data-scroll-speed="8">
          <img src="/assets/img/kite-07.png">
        </div>
      </div>
      <div class="kite-crop">
        <div class="kite-image" data-scroll-speed="4">
          <img src="/assets/img/kite-08.png">
        </div>
      </div>
      <div class="kite-crop">
        <div class="kite-image" data-scroll-speed="6">
          <img src="/assets/img/kite-09.png">
        </div>
      </div>
      <div class="kite-crop">
        <div class="kite-image" data-scroll-speed="1">
          <img src="/assets/img/kite-10.png">
        </div>
      </div>
    </div>
  <?php endif;?>
  <div class="blocks">
    <?= $page->blocks()->toBlocks() ?>
  </div>
</section>
<?php if ($page->parent()->slug() == 'reports' ): ?>
<?php snippet('map') ?>
<?php endif; ?>

<?php snippet('nav-more') ?>
</main>
<?php snippet('footer') ?>