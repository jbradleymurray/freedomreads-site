<?php snippet('header') ?>
<main>
  <div class="report-intro subpage grid">
    <?php if ( $page->pdf() && $page->pdf()->isNotEmpty() ): ?>
      <div class="report-image">
        <?php if ( $page->featureimg() ): ?>
          <a target="_blank" href="<?= $page->pdf()->toFile()->url() ?>" class="cover-report">
            <?php snippet('figure', ['image' => $page->featureimg()->toFile(), 'size' => "800"] ) ?>
          </a>
        <?php endif; ?>        
      </div>
    <?php endif; ?>

    <div class="report-info">
      <h1><?= $page->title(); ?></h1>
      <h2><?= $page->introduction(); ?></h2>
      <?php if ( $page->pdf() && $page->pdf()->isNotEmpty() ): ?>
      <p>
        <a target="_blank" href="<?= $page->pdf()->toFile()->url() ?>" class="btn-nofill">Download <span class="dl-text">↓</span></a>
      </p>
      <?php endif; ?>

    </div>
 </div>

  <section class="content">
    <div class="blocks">
      <?= $page->blocks()->toBlocks() ?>
    </div>
  </section>

<?php snippet('map') ?>

<?php snippet('nav-more') ?>
</main>
<?php snippet('footer') ?>