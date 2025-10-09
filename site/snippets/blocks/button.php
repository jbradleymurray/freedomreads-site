<div class="grid">
  <div class="block-button">
<?php if ( $block->external()->toBool() ): ?>
<a href="<?= $block->link() ?>" class="btn btn-nofill external" target="_blank">
  <?= $block->buttontext() ?>
</a>
<?php else: ?>
<a href="<?= $block->link()->toPage()->url()?>" class="btn btn-nofill">
  <?= $block->buttontext() ?>
</a>
<?php endif; ?>
  </div>
</div>