<?php foreach ($groups as $groupname => $items): ?>
	<?php $groupslug = Str::slug($groupname); ?>
	<a href="<?= $site->index()->findBy('slug', $groupslug)->url() ?>" class="anchor" id="anchor-<?= $groupslug ?>"><h3><?= $groupname ?></h3></a>
		<?php foreach ($items as $result): ?>
			<?php if ($result->template()=='news-list-external'): ?>
					<a href="<?= $result->url() ?>"><h4 class="results-pagetitle"><?= $result->title() ?></h4></a>
					<?php
						$listing = $result->listing()->sortBy('publishdate', 'desc')->toStructure();
						foreach( $listing as $entry ):
							$titlematch = getResultText($entry->title(), $query);
							$textmatch = getResultText($entry->description()->kt(), $query);
							$srcmatch = getResultText($entry->publication()->kt(), $query);
							$tagmatch = str_contains($entry->newstags()->lower(), strtolower($query) );
							if ( $titlematch || $textmatch || $srcmatch || $tagmatch): ?>
							<a class="search-result external" href="<?= $entry->link() ?>" target="_blank">
							<div class="result-info">
								<div class="results-excerpt">
									<strong><?php e( strlen($titlematch) > 0, $titlematch, $entry->title()); ?></strong> <div class="excerpt"><?= $textmatch ?></div>
									<div class="entry-list-meta">
										<span class="meta-resource">
											<?php e($srcmatch, $srcmatch, $entry->publication()) ?> <?php if ($entry->author()->isNotEmpty()): ?>
										by <?= $entry->author() ?>
										<?php endif ?></span>
										<time class="meta-date"><?= $entry->publishdate()->toDate('F j, Y') ?></time>
									<?php if($tagmatch): ?>
											|	Tagged with &nbsp;<span class="searchterm-highlight"><?= $query ?></span>
									<?php endif?>
									</div> 
								</div>
							</div>
						</a>
					<?php endif; endforeach;?>
		<?php elseif ($result->template()=='people-post'): ?>
			<?php $bio = getResultText($result->bio(), $query);
					if( strlen($bio)>0 ): ?>
			<a class="search-result" href="<?= $result->url() ?>">
				<div class="result-info">
					<h4 class="results-pagetitle"><?= $result->title() ?></h4>
					<div class="results-excerpt">
						<div class="excerpt"><?= $bio ?></div>
					</div>
				</div>
			</a>
			<?php endif; ?>
		<?php elseif ($result->template()=='people-list'): ?>
				<a class="search-result" href="<?= $result->url() ?>">
					<div class="result-info">
						<h4 class="results-pagetitle"><?= $result->title() ?></h4>
						<div class="results-excerpt">
							<?php $peoplelisting = $result->listing()->toStructure();
								foreach( $peoplelisting as $people ): ?>
								<?php if ( strlen( getResultText($people->name(), $query)) > 0 ): ?>
										<div class="excerpt"><?= getResultText($people->name(), $query) ?></div>										
								<?php endif;?>
								<?php if( strlen( getResultText($people->title(), $query)) > 0 ): ?>
									<div class="excerpt"><?= getResultText($people->title(), $query) ?></div>
								<?php endif;?>
							<?php endforeach; ?>
						</div>
					</div>
				</a>
			
		<?php else: ?>
			<?php $intromatch = strlen( getResultText($result->introduction(), $query) ) > 0;
				$textmatch = strlen( getResultText($result->blocks()->toBlocks(), $query) ) > 0; 
				$tagmatch =  str_contains($result->newstags()->lower(), strtolower($query) );
				$files = $result->files();
				$imgmatch = false;
				foreach( $files  as $file){
					if (  Str::contains($file->caption(), $query, true) ){
						$imgmatch = $file;
						break;
					}
				}
				if ( $intromatch || $textmatch || $tagmatch || $imgmatch): ?>
			<a class="search-result" href="<?= $result->url() ?>">
				<div class="result-info">
					<h4 class="results-pagetitle"><?= $result->title() ?></h4>
					<div class="results-excerpt">						
						<?php if ( $intromatch ): ?>
							<div class="excerpt">
						<?= getResultText($result->introduction()->kt(), $query) ?>
							</div>
						<?php endif; ?>
						<?php if ( $textmatch ): ?>
							<div class="excerpt">
							<?= getResultText($result->blocks()->toBlocks(), $query) ?>
							</div>
						<?php endif ?>
						<?php if ( $imgmatch ): ?>
							<div class="excerpt">
							<?= getResultText($imgmatch->caption(), $query) ?>
							</div>
						<?php endif; ?>
						<div class="entry-list-meta">
						<?php if ( $result->published()->isNotEmpty() ):?>
							<time class="meta-date"><?= $result->published()->toDate('F j, Y') ?></time>
						<?php endif;?>
						<?php if($tagmatch): ?>
								|	Tagged with &nbsp;<span class="searchterm-highlight"><?= $query ?></span>
						<?php endif?>
						</div>
					</div>
				</div>
				<div class="result-thumbnail thumbnail">
					<?php
					$thumb = false;
					if( $result->hero()->toFile() ){
						$thumb = $result->hero()->toFile(); 
					}elseif ( $result->featureimg()->toFile() ){
						$thumb = $result->featureimg()->toFile(); 
					}?>
					<?php if($thumb): ?>
					<img src="<?= $thumb->url(); ?>">
					<?php endif ?>
				</div>
			</a>
			<?php endif ?>
	<?php endif; ?>
<?php endforeach; ?>
<?php endforeach; ?>