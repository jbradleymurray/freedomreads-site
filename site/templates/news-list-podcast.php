<?php snippet('header') ?>
<main>
<?php snippet('hero') ?>
<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
  <div class="grid">
    <div class="subscription-options">
      <h3>Subscribe to the Podcast</h3>
      <?php
        $pods_links = $page->podcastlinks()->toStructure();
        foreach ($pods_links as $link): ?>
          <a class="btn-nofill btn-external" target="_blank" href="<?= $link->platformlink() ?>">
           <?= $link->platform() ?>
          </a> 
      <?php endforeach; ?>
    </div>
  </div>
  <div class="blocks">
    <?= $page->blocks()->toBlocks() ?>
  </div>
</section>
<section class="podcasts">
  <div class="grid">
    <?php $pods = $page->podcasts()->toStructure();
      $pods_reversed = $pods->flip();
      foreach ($pods_reversed as $podcast): 
        if($embed = $podcast->embed()->toEmbed()): ?>
        <div class="podcast-embed">
          <?=$embed->code();?>
        </div>
        <div class="podcast-info">
          <h3><?=$embed->title(); ?></h3>
          <h4>Episode <?= $pods->indexOf($podcast) + 1 ?></h4>
          <?php if ($podcast->episodesummary()->isNotEmpty() ): ?>
            <?= $podcast->episodesummary()->kirbytext() ?>
          <?php endif ?>
          <?php if ($podcast->episodeauthor()->isNotEmpty() ): ?>
          <details>
            <summary>
              More
            </summary>                     
            <?= $podcast->episodeauthor()->kirbytext() ?>            
          </details>
          <?php endif ?>
        </div>
    <?php endif; endforeach; ?>
  </div>
</section>
</main>
<?php snippet('footer') ?>