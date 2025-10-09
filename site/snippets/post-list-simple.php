<?php 
if( $page->parent() ):
if( $page->parent()->children() ):
$posts = $page->parent()->children()->listed()->sortBy('published', 'desc');
foreach ($posts->limit($limit) as $post): 
  if( $post !== $page ): ?>
  <a href="<?= $post->url(); ?>" class="post-item internal">
    <?php if ( !str_starts_with($page->template(), 'news') ): ?>
      <?php if ($post->hero()->isNotEmpty()): ?>
      <div class="post-list-thumbnail">
        <img src="<?= $post->hero()->toFile()->url(); ?>">
      </div>
      <?php endif ?>
    <?php endif ?>
    <div class="post-list-title">
      <?= $post->title(); ?>
    </div>
    <time class="post-list-date">
     <?= $post->published()->toDate('F j, Y') ?> 
     <?php if ($post->template() == 'news-post-pr'): ?>
      <span class="meta-loc"><?= $post->location(); ?></span>
      <?php endif ?>
    </time>
  </a>
<?php endif; endforeach; endif; endif; ?>