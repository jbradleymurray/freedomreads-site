<?php
	if ($page->hero()->isNotEmpty()):
		$heroimage = $page->hero()->toFile();
	if($heroimage): ?>
	<style>
	.hero {
	background-image: url(<?= $heroimage->resize(2000)->url(); ?>);
	}
	@media screen and (max-width: 415px) {
		.hero  {
			background-image:  url(<?= $heroimage->resize(818)->url(); ?>);
		}
	}
	</style>
<div class="hero <?php e($page->template() == 'landing', 'hero-landing', 'hero-subpage')?>">
	<div class="grid">
		<div class="hero-text"><?php e($page->herotext()->isNotEmpty(), kt($page->herotext()) )?></div>
	</div>
</div>
<?php if ($heroimage->caption()->isNotEmpty() ):?>
<figcaption class="hero-caption caption">
	<div class="grid">
		<div class="content-caption">
		<?= $heroimage->caption()->kirbytextinline() ?> <?php e($heroimage->credit()->isNotEmpty(), '(Photo: '.$heroimage->credit()->kirbytextinline().')') ?>
		</div>
	</div>
</figcaption>
<?php endif;?>
<?php endif; endif; ?>
