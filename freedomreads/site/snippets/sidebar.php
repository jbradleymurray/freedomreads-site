<?php 
$pagefeature = $block->pagefeature()->toBool();
if ( $pagefeature ){
	$link = $block->link()->toPage();
} ?>
<?php if ($block->sidebar()->toBool()): ?>
<div class="sidebar">	
<?php if ( $pagefeature && $link): ?>	
	<h2><?php e( $link->herotext()->isNotEmpty(), $link->herotext(), $link->title() ) ?></h2>
	<div class="description"><?= $link->introduction() ?></div>
	<?php if (!$block->buttontext()->isEmpty()): ?>
		<a href="<?= $link->url()?>" class="btn btn-page">
		  <?= $block->buttontext() ?>
		</a>
	<?php endif; ?>
<?php else: ?>
	<h2><?= $block->sbheading()->kirbytextinline() ?></h2>
	<div class="description"><?= $block->sbdescription()->kirbytext() ?></div>
<?php endif; ?>
</div>
<?php endif; ?>