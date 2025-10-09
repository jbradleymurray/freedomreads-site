<?php
	$fullwidth = false;
	$layout  = $block->layout();
	if ( $layout == 'fullwidth' ){
		$fullwidth = true;
		$srckey = 'cover';
	}
 
 	$videoid = str_replace('https://youtu.be/', '', explode('?', $block->url())[0] ); ?>

<?php if( $videoid ):?>
<div class="block-wrapper block-video <?php e($fullwidth,'figure-fullwidth'); e($block->sidebar()->toBool(), 'sidebar-module sidebar-video')?>">
		<div class="grid">
			<div class="content-video">
				<figure>
					<div class="video-container" id="<?= $videoid ?>">
						<div class="video-live">
						</div>						
						<div class="video-static"><img src="https://i.ytimg.com/vi/<?= $videoid ?>/maxresdefault.jpg" alt="YouTube Video Thumbnail" loading="lazy"></div>
					</div>
					<?php if ($block->caption()->isNotEmpty()): ?>
					<figcaption><?= $block->caption() ?></figcaption>
					<?php endif ?>
				</figure>
			</div>
		<?php snippet('sidebar', ['block'=>$block])?>
	</div>
</div>
<?php endif ?>