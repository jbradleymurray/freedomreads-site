
<section class="cover <?php e($page->template() == 'landing', 'cover-landing', 'cover-subpage')?> <?php e($page->hero()->isEmpty(), 'no-background', 'with-background');?>"> 
	<div class="grid">
		<div class="cover-text">
			<?php if ( !$landing ):?>
			<div class="hero-text"><?php e($page->herotext()->isNotEmpty(), kt($page->herotext()) )?></div>
			<?php endif; ?>	
			<?php if ($page->slug() == 'subscribe-confirmation' ): ?>
				<h1><?= $site->page('subscribe')->title(); ?></h1>
				<p class="p-cover"><?=  $site->page('subscribe')->introduction()->kirbytextinline(); ?></p>
			<?php else: ?>
				<h1><?= $page->title(); ?></h1>
				<p class="p-cover"><?= $page->introduction()->kirbytextinline(); ?></p>
		  <?php endif; ?>		
		</div>
		<?php if ($page->template() == 'landing'):?>
			<?php if ($page->slug() == 'news' ): ?>
				<div class="mediacontact note">
					<h2>Media Contact</h2>
					<?= $page->mediacontact()->kirbytext(); ?>
				</div>
			<?php elseif( $page->id() != 'about' &&  $page->id() != 'donate' ): 
					$pagetag = $page->title(); ?>
			<div class="featured-content">
				<?php
				  $news = $site->index()->filterBy('newstags', $pagetag, ',')->listed()->sortBy('published', 'desc')->limit(2); 
				  if ( count($news)>0 ): ?>
				  <h3><a href="/news/blog/">Latest News</a></h3>
				  <ul>
				  <?php foreach ($news as $newsitem): ?>
				  	<li><a href="<?=$newsitem->url()?>"><?= $newsitem->title() ?></a>
				  		<time><?= $newsitem->published()->toDate('m.d.y') ?></time></li>
				  <?php endforeach ?>
					</ul>
				<?php endif; ?>

				 <?php $media = page('news/in-the-media')->listing()->toStructure()->filterBy('newstags', $pagetag, ',')->limit(1); 
				  if ( count($media)>0 ):?>
				 <h3><a href="/news/in-the-media/">In the Media</a></h3>
				 <ul>
				 <?php foreach ($media as $mediaitem): ?>
				  	<li><a href="<?=$mediaitem->link()?>" target="_blank" class="external"><?= $mediaitem->title() ?></a><time class="lastmedia"><?= $mediaitem->publishdate()->toDate('m.d.y') ?> in <?= $mediaitem->publication() ?></time></li>
				  <?php endforeach ?>
				</ul>
				<?php endif; ?>		
			</div>
			<?php endif; ?>
			<?php if (!$page->children()->isEmpty()): ?>
			  <ul class="submenu">
				 <?php foreach ($page->children() as $subpage): ?>
					<li><a href="<?= $subpage->url(); ?>"><?= $subpage->title() ?></a></li>
				 <?php endforeach ?>
			  </ul>
			<?php endif; ?>
		<?php endif; ?> 
		<!-- endif if landing -->		
	</div>
</section>