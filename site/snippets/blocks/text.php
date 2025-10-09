<?php /** @var \Kirby\Cms\Block $block */ ?>
<div class="block-wrapper block-text <?php e($block->sidebar()->toBool(), 'sidebar-module sidebar-text')?>">
	<div class="grid">
		<div class="content-text">
			<?= $block->text()->kirbytext(); ?>
		</div>
		<?php snippet('sidebar', ['block'=>$block])?>
	</div>
</div>