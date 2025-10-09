<li>
	<a href="<?= $bioItem->url(); ?>">
		<div class="bio-img">
		<?php 
			$heroFile = $bioItem->content()->get('hero')->toFile();
			if ($heroFile): 
					$heroUrl = $heroFile->url(); ?>
					<figure style="background-image:url('<?= $heroUrl ?>');"></figure>
			<?php endif; ?>
		</div>
		<div class="bio-info">
			<h4><?= $bioItem->content()->get('title')->value() ?></h4>
			<p>
				<?= $bioItem->content()->get('position')->value() ?>
			</p>
		</div>
	</a>
</li>