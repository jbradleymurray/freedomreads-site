<?php 
$image = $block->image();
$sb = $block->sidebar()->toBool();
?>
<div class="block-wrapper <?php e($block->inline()->toBool() === true, 'inlined');?> block-quote<?php e($sb, ' sidebar-module sidebar-quote'); if ($image->isNotEmpty() && !$sb ): ?> quote-fullwidth" style="background-image: url('<?= $image->toFile()->url()?>')"><?php else: ?>"><?php endif ?>
	<div class="grid">
		<?php snippet('sidebar', ['block'=>$block])?>
		<blockquote class="content-quote <?php e($block->citation()->isNotEmpty(), 'citation');?>">
		  <p><?= $block->text() ?></p>
		  <?php if ($block->citation()->isNotEmpty()): ?>
		  <footer>
		    <?= $block->citation() ?>
		  </footer>
		  <?php endif ?>
		</blockquote>
	</div>
</div>
