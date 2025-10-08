<?php snippet('header') ?>
<main>
<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
	<div class="post-list grid">
		<?php 
		$posts = $page->children()->listed()->filterBy('reportstatus', true);
		foreach ( $posts as $post): ?>
		  <div class="report-item">
		    <div class="post-list-cover">
		    	<a href="<?= $post->url(); ?>">
		      <?php if ( $post->featureimg() && $post->featureimg()->isNotEmpty() ):?>
		        <?php $image = $post->featureimg()->toFile(); ?>
		        <?php snippet('figure', ['image' => $image, 'size' => "500"] ) ?>
		      <?php endif ?>
		      </a>
		    </div>
		    <div class="post-list-title">
		      <a href="<?= $post->url(); ?>"><?= $post->title(); ?></a>
		    </div>
		    <div class="post-list-intro">
		      <a href="<?= $post->url(); ?>"><?= $post->introduction()->kirbytextinline(); ?></a>
		    </div>
		    <div class="post-list-dl">
		    	<?php if ( $post->pdf() && $post->pdf()->isNotEmpty() ):?>
		    		<a target="_blank" href="<?= $post->pdf()->toFile()->url() ?>" class="btn-nofill" title="Download">Download ↓</a>
		    	<?php endif; ?>
		    </div>
		 </div>
		<?php endforeach ?>
	</div>

<?php 
		$archive_posts = $page->children()->listed()->filterBy('reportstatus', false); ?>
<?php if ( count( $archive_posts ) > 0 ):?>
	<div class="grid">
			<h2 class="header">Archive</h2>
	</div>
	<div class="post-list-archive">
		<?php foreach ( $archive_posts as $post): ?>
			 <div class="archive-item grid internal">
			   <div class="post-list-cover">
			   	<a href="<?= $post->url(); ?>">
			     <?php if ( $post->featureimg() && $post->featureimg()->isNotEmpty() ):?>
			       <?php $image = $post->featureimg()->toFile(); ?>
			       <?php snippet('figure', ['image' => $image, 'size' => "thumb"] ) ?>
			     <?php endif ?>
			     </a>
			   </div>
			   <div class="post-list-title">
			     <a href="<?= $post->url(); ?>"><?= $post->title(); ?></a>
			   </div>
			   <div class="post-list-intro">
			     <a href="<?= $post->url(); ?>"><?= $post->introduction()->kirbytextinline(); ?></a>
			   </div>
			   <div class="post-list-dl">
			   	<?php if ( $post->pdf() && $post->pdf()->isNotEmpty() ):?>
			   		<a target="_blank" href="<?= $post->pdf()->toFile()->url() ?>" class="btn-nofill" title="Download">Download ↓</a>
			   	<?php endif; ?>
			   </div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
</section>
<?php snippet('map') ?>
</main>
<?php snippet('footer') ?>