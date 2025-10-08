<?php snippet('header') ?>
<section class="content">
<div class="grid">
<h1><?= $page->title(); ?></h1>
	<?php if ($page->text()->isNotEmpty()): ?>
	<article class=""><?= $page->text()->kirbytext(); ?></article>
	<?php endif ?>
</div>
</section>
<?php snippet('footer') ?>