<?php snippet('header') ?>
<main>

<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
	<div class="grid">
		<nav class="tag-list">
			<h3>Tags</h3>			
			<?php
			$tags = $page->children()->listed()->pluck('newstags', ',', true);
			 foreach ($tags as $tag): ?>
			   <a class="tag-item btn-nofill" href="<?= url('/news/blog', ['params' => ['tag' => $tag]]) ?>"><?= $tag ?></a>
			<?php endforeach ?>
		</nav>
		<div class="blog-list">
			<?php if($tag = param('tag')):?>
				<h3>Tagged with <?= $tag ?></h3>
			<?php else: ?>
				<h3>All Posts</h3>
			<?php endif; ?>

		<?php 
		// fetch the basic set of articles
		$posts = $page->children()->listed()->sortBy('published', 'desc');

		// add the tag filter
		if($tag = param('tag')) {
		  $posts = $posts->filterBy('newstags', $tag, ',');
		}

		$posts = $posts->paginate(12);

		foreach ($posts as $post): ?>
		<article class="blog-item">
				<div class="post-heading">
					<a href="<?= $post->url(); ?>"><h2 class="post-title">
						<?= $post->title(); ?>
					</h2></a>
					<?php if ($post->author()->isNotEmpty()): ?>
						<div class="author-list">By
							<?php  $authors = $post->author()->toStructure();
						foreach ($authors as $author): ?>
							<span class="author">
								<?= $author->authorname() ?><?php e($author->authoraffiliation()->isNotEmpty(), ", " . $author->authoraffiliation() ); ?>
							</span>
							<?php e($author == $authors->last(), '', ' and '); ?>
						<?php endforeach ?>
						</div>
					<?php endif ?>
					<time class="post-date meta-date">
						<?= $post->published()->toDate('F j, Y') ?> 
					</time>
				</div>
				<?php if ($post->featureimg()->isNotEmpty()):
					 $image = $post->featureimg()->toFile();
				 ?>

				 <?php snippet('figure', ['image' => $image, 'size' => "2000"] ) ?>
				<?php endif ?>
				<div class="post-excerpt">
				<?php if ($post->introduction()->isNotEmpty()): ?>
					<?= $post->introduction()->kirbytext(); ?>
				<?php endif ?>
				<a href="<?= $post->url();?>" class="btn-nofill">Continue Reading</a>
				</div>
		</article>
		<?php endforeach ?>		
		</div>		
		<?php $pagination = $posts->pagination() ?>
		<?php snippet('pagination', ['pagination'=>$pagination]) ?>
	</div>
</section>
</main>
<?php snippet('footer') ?>