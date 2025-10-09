<section class="nav-more">
  <?php if ( str_starts_with($page->template(), 'news') ): ?>
  <div class="next-prev wrapper grid">
    <?php if ($page->hasPrevListed()): ?>
    <a class="nav-prev" href="<?= $page->prevListed()->url() ?>"> ‹ previous</a>
    <?php endif ?>

    <?php if ($page->hasNextListed()): ?>
    <a class="nav-next" href="<?= $page->nextListed()->url() ?>">next ›</a>
    <?php endif ?>
  </div>
  <?php endif; ?>
  <?php 
  $tags = $page->newstags()->split(',');
  $related = $page->siblings(false)->listed()->flip()->filter(function($item) use($tags) {
    return count(array_intersect($tags, $item->newstags()->split(','))) > 0;
  })->sortBy('published', 'desc')->limit(6);

  $notag = count($related)== 0 || $page->template()=='news-post-pr';
   //don’t filter by tag for press releases
  if( $notag ){   
    $related = $page->siblings(false)->listed()->flip()->limit(6);
  }
  ?>
  <?php if ( count($related)>0 ):?>
  <div class="grid">
    <div class="heading-related">
      <?php if ($notag): ?>
        <h3>Related</h3>
      <?php else: ?>
        <h3>Related to <span class="tags-related"><?php foreach ( $page->newstags()->split() as $tag): ?>
          <a href="<?= url('/news/blog', ['params' => ['tag' => $tag]]) ?>"><?= $tag ?></a><?php endforeach;?>
        </h3>
      <?php endif;?>
    </div>
    <?php snippet('related-list', ['related' => $related, 'page' => $page]) ?>
  </div>
  <?php endif; ?>
</section>