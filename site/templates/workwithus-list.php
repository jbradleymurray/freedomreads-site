<?php snippet('header') ?>
<?php snippet('hero') ?>
<?php snippet('page-intro', ['landing'=>true]) ?>
<section class="content">
      <div class="wrapper grid post-list">
        <div class="content-text intro-description">
         <?= $page->description()->kirbytext() ?>
        </div>

            <h2 class="header">Current Openings</h2>
            <?php if ($page->children()->isEmpty()): ?>
              <ul><li>There are no opportunities at this time.</li></ul>
            <?php else: ?>
              <ul>
                  <?php foreach ($page->children() as $subpage): ?>
                    <li>
                        <div class="info">
                          <h1><?= $subpage->title() ?></h1>
                          <h2><?= $subpage->position() ?></h2>
                          <div class="description">
                            <?php echo str::excerpt($subpage->blocks()->first()->toBlocks() , 400, false) ?>
                          </div>
                        </div>
                        <a class="btn-page" href="<?= $subpage->url(); ?>">Read more</a>

                    </li>
                  <?php endforeach ?>
                </ul>
            <?php endif ?>
          </div>
  </div>
</section>
<?php snippet('footer') ?>