<?php

$image = null;
$fullwidth = false;
$vert = false;
$sb = $block->sidebar()->toBool();

if ($singleimg = $block->image()->toFile()){
	$image = $singleimg;
	$vert = $image->isPortrait();
}

$layout  = $block->layout();

if ( $layout == 'fullwidth' && !$sb ){
	$fullwidth = true;
}

?>

<div class="block-wrapper block-image <?php e($fullwidth,'figure-fullwidth'); e($vert, ' figure-vertical'); e($sb, ' sidebar-module sidebar-img');?>">
	<div class="grid">
		<?php snippet('sidebar', ['block'=>$block])?>
		<?php if ($image): ?>
		<div class="content-image">
			<?php snippet('figure', ['image' => $image, 'size' => "1600"] ) ?>
		</div>
		<?php endif; ?>
	</div>
</div>

