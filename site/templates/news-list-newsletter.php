<?php snippet('header') ?>
<main>
<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
	<div class="grid">
		<div class="post-list">
			<?php $posts = $page->children()->listed()->sortBy('published', 'desc')->paginate(12);
			foreach ( $posts as $post): ?>
			  <a href="<?= $post->url(); ?>" class="post-item internal">
			    <div class="post-list-title">
			      <?= $post->title(); ?>
			    </div>
			    <div class="post-list-intro">
			      <?= $post->introduction()->kirbytextinline(); ?>
			    </div>
			  </a>
			<?php endforeach ?>		
		</div>
		<div id="signup">
			<div class="content-signup">
				<?php snippet('form-signup'); ?>
			</div>
		</div>
	</div>
	<?php $pagination = $posts->pagination() ?>
	<?php snippet('pagination', ['pagination'=>$pagination]) ?>
</section>
</main>
<?php snippet('footer') ?>
