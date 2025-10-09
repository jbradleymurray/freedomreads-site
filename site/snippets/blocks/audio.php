<div class="block-wrapper block-audio">
      
  <div class="grid audio-group" data-muted="false" data-playing="false" data-playspeed="<?= $block->playspeed() ?>">
    <div class="audio-icons">
      <div class="audio-play">
        <svg class="audio-on-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 18"><path class="cls-1" d="m10,0l-6,6H0v6h4l6,6V0Zm3,.09v2c3.4.5,6,3.41,6,6.91s-2.6,6.41-6,6.91v2c4.5-.5,8-4.31,8-8.91S17.5.59,13,.09Zm0,5v7.72c1.7-.4,3-1.91,3-3.81s-1.3-3.41-3-3.91Z"/></svg>
      </div>
      <div class="audio-mute">
        <svg class="audio-mute-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 18"><path class="cls-1" d="m10,0l-6,6H0v6h4l6,6V0Zm3.22,4.73l-1.44,1.44,2.81,2.78-2.81,2.78,1.44,1.44,2.78-2.81,2.78,2.81,1.44-1.44-2.81-2.78,2.81-2.78-1.44-1.44-2.78,2.81-2.78-2.81Z"/></svg>
      </div>      
    </div>
    <blockquote class="content-quote citation">
      <p class="audiotext-full"><?= $block->quote()->kirbytextinline() ?></p>
      <p class="audiotext-typed"></p>  
      <footer><?= $block->speaker()->kirbytextinline()?></footer>        
    </blockquote>
      
    <audio playsinline class="audio-file">
      <source src="<?= $block->soundfile()->toFile()->url() ?>" >
    </audio>

  </div>
</div>
