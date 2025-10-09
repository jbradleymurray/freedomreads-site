<?php snippet('header') ?>
<main>
<?php snippet('page-intro', ['landing'=>false]) ?>
<section class="content">
	<div class="post-list">
		<?php snippet('post-list', ['paginate'=>true]) ?>
	</div>
</section>
</main>
<?php snippet('footer') ?>