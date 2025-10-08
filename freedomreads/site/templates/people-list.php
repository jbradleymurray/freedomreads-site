<?php snippet('header') ?>
<?php snippet('hero') ?>
<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
<?php $founder = $page->children()->published()->filterBy('category', 'founder')->first();
	if ($founder): ?>
	<div class="grid people-list founder">
			<h2 class="header">Our Founder</h2>
			<div class="bio-img img-wrapper">
				<?php if($hero = $founder->hero()->toFile()): ?>
					<a href="<?= $founder->url(); ?>">
					<figure style="background-image:url('<?= $hero->url() ?>');"></figure></a>
				<?php endif ?>
			</div>
			<div class="bio-info">
				<h2><?= $founder->title() ?></h2>
				<h3><?= $founder->position() ?></h3>
				<div class="bio-text">
					<?php echo str::excerpt($founder->bio()->kirbytext() , 200, false) ?>
				</div>
				<a class="btn-page" href="<?= $founder->url(); ?>">Read More</a>
			</div>
	</div>
<?php endif;?>
	<div class="grid people-heading staff-heading">
			<h2 class="header">Staff</h2>
	</div>
	<div class="people-list staff-list">
		<?php $staff = $page->find('staff')->children()->published(); ?>
		<?php if ( $staff->isNotEmpty()): ?>
		 <ul class="grid"> 
				<?php foreach ($staff as $staffItem):
						snippet('bio', ['bioItem' => $staffItem]);
					endforeach; ?>
				</ul>
			<?php endif ?>
	</div>
	<div class="grid people-heading board-heading">
		<h2 class="header">Board of Directors</h2>
	</div>
	<div class="people-list staff-list">
		<?php $board = $page->find('board-of-directors')->children()->published();
		if ( $board->isNotEmpty() ): ?>
		<ul class="grid">
			<?php  foreach ($board as $boardItem): 
				snippet('bio', ['bioItem' => $boardItem]);
			endforeach; ?>
		</ul>
		<?php endif ?>
 </div>
<div class="grid people-heading advisory-heading">
	<h2 class="header">Advisory Board</h2>
</div>
<div class="people-list advisory-list">
	<?php if (!$page->advisory()->isEmpty()): ?>
	<ul class="grid">
		 <?php
			$items = $page->advisory()->toStructure();
			foreach ($items as $item): ?>
					<li>
						<p><strong><?= $item->name() ?></strong><br>
					<?= $item->title() ?>
					<?= $item->description() ?></p>
				</li>
			<?php endforeach ?>
	</ul>
	<?php endif ?>
</div>

</section>
<?php snippet('footer') ?>