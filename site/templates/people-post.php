<?php snippet('header') ?>
<section class="content">
<div class="people-intro">
	<div class="grid">
		<?php  if ($page->hero()->isNotEmpty()):
		$hero = $page->hero()->toFile(); ?>
		<div class="bio-img bio-hero"> 
			<figure style="background-image:url('<?= $hero->url(); ?>');"></figure>
			<figcaption><?php if ($hero->caption()->isNotEmpty()): ?><?= $hero->caption() ?><?php endif ?><?php if ($hero->credit()->isNotEmpty()): ?> <span class="credit">Photo: <?=$hero->credit() ?></span><?php endif ?></figcaption>
		</div>
		<?php endif ?>
		<div class="bio-info">
			<h1><?= $page->title(); ?></h1>
			<h2><?= $page->position(); ?></h2>
		</div>
	</div>
</div>

<div class="grid">
	<div class="bio-contact">
		<?php if ($page->email()->isNotEmpty()): ?>
			<h3>Email</h3>
			<p><?= $page->email(); ?></p>
		<?php endif ?>
	</div>
	<?php if ($page->bio()->isNotEmpty()): ?>
	<div class="bio-text"><?= $page->bio()->kirbytext(); ?></div>
	<?php endif ?>
</div>

<!--staff -->
<?php if($page->category() == 'staff' || $page->category() == 'founder'): ?>
<div class="grid people-heading">
	<h2 class="header">Staff</h2>
</div>

<div class="people-list staff-list">
	<?php if ( $page->category() == 'founder' ): ?>
		<ul class="grid">
			<?php  foreach ( page('about/people/staff')->children()->published() as $staffItem): 
				snippet('bio', ['bioItem' => $staffItem]);
			endforeach; ?>
		</ul>
	<?php elseif( $page->category() == 'staff' ):?>
	<ul class="grid">
		<!--add founder to staff lists-->
	<?php $founder = page('about/people/reginald-dwayne-betts'); 
		if ( $founder ): ?>
			<?php snippet('bio', ['bioItem' => $founder]); ?>
		<?php endif ?>

		<?php  foreach ( $page->siblings()->published() as $staffItem): 
			snippet('bio', ['bioItem' => $staffItem]);
		endforeach; ?>
		</ul>
	<?php endif?>
</div>
<?php endif; ?>

<!-- board -->
<?php if($page->category() == 'board'): ?>
<div class="grid people-heading">
	<h2 class="header">Board of Directors</h2>
</div>
<div class="people-list staff-list">
	<ul class="grid">
	<?php  foreach ( $page->siblings()->published() as $boardItem): 
		snippet('bio', ['bioItem' => $boardItem]);
	endforeach; ?>
	</ul>
</div>
<?php endif; ?>

</section>
<?php snippet('footer') ?>