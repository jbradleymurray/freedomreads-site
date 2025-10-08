<div class="grid">
	<section class="post-intro <?php if ($page->featureimg()->isNotEmpty()):?><?= $page->featureimg()->toFile()->orientation(); ?><?php endif ?>">
			<div class="text">
				<div class="category"><a href="<?= $page->parent()->url(); ?>"><?= $page->parent()->title(); ?></a></div>
				<h1><?= $page->title(); ?></h1>
				<?php if ( !($page->template() == 'news-post-blog') && $page->introduction()->isNotEmpty()): ?>
					<p class="p-intro"><?= $page->introduction()->kirbytextinline(); ?></p>
				<?php endif ?>

				<?php if ($page->author()->isNotEmpty()): ?>
					<div class="author-list">By
						<?php  $authors = $page->author()->toStructure();
						foreach ($authors as $author): ?>
							<span class="author">
								<?= $author->authorname() ?><?php e($author->authoraffiliation()->isNotEmpty(), ", " . $author->authoraffiliation() ); ?>
							</span>
							<?php e($author == $authors->last(), '', ' and '); ?>
						<?php endforeach ?>
					</div>
				<?php endif ?>
				<time class="meta-date">
					<?= $page->published()->toDate('F j, Y') ?>
					<?php if ($page->template() == 'news-post-pr'): ?>
						<span class="meta-loc"><?= $page->location(); ?></span>
					<?php endif ?>
				</time>
			</div>
			<?php if ($page->template() !== 'news-post-pr'): ?>
				<?php if ($page->featureimg()->isNotEmpty()):
						$image = $page->featureimg()->toFile();
					?>							
						<?php snippet('figure', ['image' => $image, 'size' => "2400"] ) ?>
					<?php endif ?>
			<?php endif ?>
		 
	</section>
	</div>