<?php 
$posts = $page->children()->listed()->sortBy('published', 'desc')->paginate(12);
if ( isset($limit)  ){
  $posts = $posts->limit($limit);
}
foreach ( $posts as $post): ?>
  <a href="<?= $post->url(); ?>" class="grid news-item post-item internal">
    <div class="post-list-cover">
      <?php if ( $post->featureimg() && $post->featureimg()->isNotEmpty() ):?>
        <?php $image = $post->featureimg()->toFile(); ?>
        <?php snippet('figure', ['image' => $image, 'size' => "thumb"] ) ?>
      <?php endif ?>
    </div>
    <div class="post-list-title">
      <?= $post->title(); ?>
    </div>
    <div class="post-list-intro">
      <?= $post->introduction()->kirbytextinline(); ?>
    </div>
    <time class="post-list-date meta-date">
     <?= $post->published()->toDate('F j, Y') ?> 
     <?php if ($post->template() == 'news-post-pr'): ?>
      <span class="meta-loc"><?= $post->location(); ?></span>
      <?php endif ?>
    </time>
  </a>
<?php endforeach ?>

<?php if ( isset($paginate)  ): 
  $pagination = $posts->pagination() ?>
  <?php snippet('pagination', ['pagination'=>$pagination]) ?>
<?php endif ?>
