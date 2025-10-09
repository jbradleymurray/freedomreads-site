<?php /** @var \Kirby\Cms\Block $block */ 

$image = null;
$vert = false;

if ($img = $block->scan()->toFile()){
  $image = $img;
  $vert = $img->isPortrait();
}?>
<div class="block-wrapper block-kite">      
  <div class="grid kite-text">  
    <blockquote class="content-quote citation">
      <?= $block->text()->kirbytext() ?>
      <?php if ($block->citation()->isNotEmpty()): ?>
      <footer>
        <?= $block->citation() ?>
      </footer>
      <?php endif ?>  
    </blockquote>       
  </div>
  <div class="kite-image" data-scroll-speed="3">
    <div class="grid">
     <?php if ($image): ?>
      <figure>        
        <picture>
            <img
              alt="<?php if($image->alt()->isNotEmpty()): echo esc($image->alt(), 'attr'); endif ?>"
              title="<?php if($image->caption()->isNotEmpty()): echo esc($image->caption(), 'attr'); endif ?>"
              src="<?= $image->url() ?>"
              loading="lazy" 
            >
        </picture>
      </figure>
    <?php endif; ?>
    </div>
  </div>
</div>