<?php /** @var \Kirby\Cms\Block $block */ ?>
<div class="block-wrapper block-heading">
	<div class="grid">
		<div class="content-text">
		<<?= $level = $block->level()->or('h2') ?>><?= $block->text() ?></<?= $level ?>>
		</div>
	</div>
</div>