<div class="block-wrapper block-signup">
  <div class="grid">
    <div class="form-wrapper">
      <h3><?= $block->headline() ?></h3>

      <?php
        // Get the source value from the block (if any)
        $rawSource = strip_tags($block->source()->kt()->value());

        // Fallback to 'default' if empty
        $source = $block->source()->isNotEmpty() ? Str::slug($rawSource) : 'default';

        // Compose form ID with 'block-' prefix
        $form_id = 'block-' . $source;
      ?>

      <?php snippet('form-signup', ['form_id' => $form_id]); ?>
    </div>
  </div>
</div>
