<?php snippet('header') ?>
<main>
<?php snippet('hero') ?>
<?php snippet('page-intro', ['landing'=>true]) ?>
<section class="content">
		<?php $blog = $page->find('blog') ?>
		<?php $post = $blog->children()->listed()->sortBy('published', 'desc')->first() ?>
		<div class="blog-feature blog-item module-intro">
			<div class="grid">
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
				<?php if ($post->featureimg()->isNotEmpty()):
					 $img = $post->featureimg()->toFile();
				 ?>
				 <figure class="post-image">
					 <img class="featureimg" src="<?= $img->url(); ?>" alt="">
					 <?php if ($img->caption()->isNotEmpty()): ?><figcaption><?= $img->caption()->kirbytextinline() ?> <?php e($img->credit()->isNotEmpty(), '(Photo: '.$img->credit()->kirbytextinline().')') ?></figcaption>
					 <?php endif?>
				 </figure>
					<?php endif ?>
					<div class="post-excerpt">  
						<?= $post->introduction()->kirbytext() ?>
						<a href="<?= $post->url();?>" class="btn-nofill">Continue Reading</a>
					</div>
				</div>

				<div class="sidebar">
					<h2>Blog</h2>
					<div class="description"><?= $blog->introduction() ?></div>
					<a href="<?= $blog->url();?>" class="btn-page">Read the Blog</a>
				</div>
			</div>			
		</div>
			

		<?php $media = $page->find('in-the-media') ?>
		<div class="module-intro">
			<div class="grid">
				<div class="sidebar">
					<h2><?= $media->title() ?></h2>
					<div class="description"><?= $media->introduction() ?></div>
					<a href="<?= $media->url();?>" class="btn-page">Read More</a>
				</div>
				<?php snippet('entry-list', ['page' => $media, 'limit' => 2] ) ?>
			</div>	        
		</div>

		<?php $interest = $page->find('news-of-interest') ?>
		<div class="module-intro">
			<div class="grid">
				<div class="sidebar">
					<h2><?= $interest->title() ?></h2>
					<div class="description"><?= $interest->introduction() ?></div>
					<a href="<?= $interest->url();?>" class="btn-page">Read More</a>
				</div>
				<?php snippet('entry-list', ['page' => $interest, 'limit' => 2] ) ?>
			</div>	        
		</div>

		<?php $newsletter = $page->find('newsletter') ?>
		<div class="module-intro">
			<div class="grid">
				<div class="sidebar">
					<h2><?= $newsletter->title() ?></h2>
					<div class="description">
						<div class="content-signup">
						<?php snippet('form-signup', ['form_id' => 'sidebar']); ?>
						</div>
					<a href="./news/newsletter" class="btn-page">Access the Archive</a>
					</div>
				</div>
				<div class="newsletter-latest">
					<h4>Latest Issue</h4>
					<?php $newsletterlatest = $newsletter->children()->flip()->first(); ?>
					<h3><a href="<?= $newsletterlatest->url();?>"><?= $newsletterlatest->title() ?></a></h3>
					<?= $newsletterlatest->introduction()->kirbytext() ?>
					<?php if ($newsletterlatest->featureimg()->isNotEmpty()):
						$img = $newsletterlatest->featureimg()->toFile();
					?>
						<a href="<?= $newsletterlatest->url();?>"><figure>
							<img src="<?= $img->url(); ?>" alt="">
							<?php if ($img->caption()->isNotEmpty()): ?><figcaption><?= $img->caption()->kirbytextinline() ?> <?php if ($img->credit()->isNotEmpty()): ?>(<?=$img->credit() ?>)<?php endif ?></figcaption>
							<?php endif?>
						</figure></a>
					<?php endif ?>

					<a href="<?= $newsletterlatest->url();?>" class="btn-nofill">Read the Newsletter</a>
				</div>
				
			</div>
		</div>

		<?php $podcasts = $page->find('freedom-takes-podcast') ?>
		<?php if ($podcasts):?>
		<div class="module-intro">
			<div class="grid">
				<?php $latestpod = $podcasts->podcasts()->toStructure()->last();
				    if($embed = $latestpod->embed()->toEmbed()): ?>
				    
			    	<div class="podcast-info">
			    		<h4>Latest Episode</h4>
			    	  <h3><?=$embed->title(); ?></h3>
			    	  <figcaption><?= $latestpod->episodesummary()->kirbytext() ?></figcaption>
			    	  <div class="podcast-embed">
			    	    <?=$embed->code();?>
			    	  </div>				    	  
			    	</div>
				<?php endif;?>
				<div class="sidebar">
					<h2><?= $podcasts->title() ?></h2>
					<div class="description"><?= $podcasts->introduction() ?></div>
					<h4>Subscribe</h4>
					<?php $pods_links = $podcasts->podcastlinks()->toStructure();
		        foreach ($pods_links as $link): ?>
		          <a class="btn-nofill btn-external" target="_blank" href="<?= $link->platformlink() ?>">
		           <?= $link->platform() ?>
		          </a> 
		      <?php endforeach; ?>
					<a href="<?= $podcasts->url();?>" class="btn-page">Listen to Episodes</a>
				</div>

			</div>	        
		</div>
	<?php endif; ?>

		<?php $prs = $page->find('press-releases') ?>
		<div class="module-intro">
			<div class="grid">
				<div class="sidebar">
					<h2><?= $prs->title() ?></h2>
					<div class="description"><?= $prs->introduction() ?></div>
					<a href="<?= $prs->url();?>" class="btn-page">Read More</a>
				</div>

				<?php 
				$releases = $prs->children()->listed()->sortBy('published', 'desc')->limit(2);
				foreach ( $releases as $release): ?>
				  <a href="<?= $release->url(); ?>" class="news-item post-item internal">
				    <div class="post-list-title">
				      <?= $release->title(); ?>
				    </div>
				    <div class="post-list-intro">
				      <?= $release->introduction()->kirbytextinline(); ?>
				    </div>
				    <time class="post-list-date meta-date">
				     <?= $release->published()->toDate('F j, Y') ?> 
				     <?php if ($release->template() == 'news-post-pr'): ?>
				      <span class="meta-loc"><?= $release->location(); ?></span>
				      <?php endif ?>
				    </time>
				  </a>
				<?php endforeach ?>

			</div>	        
		</div>

</section>
</main>
<?php snippet('footer') ?>