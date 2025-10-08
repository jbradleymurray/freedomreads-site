<?php
$items = $page->listing()->sortBy('publishdate', 'desc')->toStructure()->paginate(12);

if ( isset($limit)  ){
  $items = $items->limit($limit);
}

foreach ($items as $entry): ?>
    <a href="<?= $entry->link(); ?>" target="blank" class="news-item entry-item external">
  <div class="entry-block">
    <?php if ($entry->thumbnail()->isNotEmpty()): ?>
    <div class="entry-thumbnail"><img src="<?= $entry->thumbnail()->toFile()->url(); ?>"></div>
    <?php endif ?>
    <h5 class="entry-list-title">
      <?= $entry->title(); ?>
    </h5>  
    <div class="entry-list-meta">
      <span class="meta-resource"><strong><?= $entry->publication(); ?></strong> <?php if ($entry->author()->isNotEmpty()): ?>
      by <?= $entry->author() ?>
      <?php endif ?></span>
      <span class="meta-date"><?= $entry->publishdate()->toDate('F j, Y') ?></span>
    </div> 
    <p class="entry-list-description">
      <?= $entry->description()->kirbytextinline(); ?>
    </p>
  </div>
  </a>
<?php endforeach ?>

<?php if ( isset($paginate)  ): 
  $pagination = $items->pagination() ?>
  <?php snippet('pagination', ['pagination'=>$pagination]) ?>
<?php endif ?>

