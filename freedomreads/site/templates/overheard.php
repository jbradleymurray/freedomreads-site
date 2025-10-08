<?php snippet('header') ?>
<main>
<?php
	if ($page->herovideo()->isNotEmpty()):
		$herovid = $page->herovideo()->toFile();
	if($herovid): ?>
<div class="hero hero-subpage">
	<video playsinline autoplay muted loop id="bgvid">
	  <source src="<?= $herovid->url(); ?>" type="<?= $herovid->mime(); ?>">
		Your browser does not support the video tag.
	</video>
</div>
<?php if ($herovid->caption()->isNotEmpty() ):?>
<figcaption class="hero-caption caption">
	<div class="grid">
		<div class="content-caption">
		<?= $herovid->caption()->kirbytextinline() ?> <?php e($herovid->credit()->isNotEmpty(), '(Photo: '.$herovid->credit()->kirbytextinline().')') ?>
		</div>
	</div>
</figcaption>
<?php endif;?>
<?php endif; endif; ?>
<section class="cover cover-subpage with-background"> 
	<div class="grid">
		<div class="cover-text">
			<div class="hero-text"></div>					
		  <h1><?= $page->title(); ?></h1>
		  <p class="p-cover"><?= $page->introduction()->kirbytextinline(); ?></p>
		</div>
	</div>
</section>
<section class="content">
  <div class="blocks">
    <?= $page->blocks()->toBlocks() ?>
  </div>
</section>
<?php snippet('nav-more') ?>
</main>
<?php snippet('footer') ?>