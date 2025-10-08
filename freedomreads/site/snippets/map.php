<?php
$map_page = $pages->find('map');
$lib_data = $map_page->children()->listed();
$lib_count = 0;
$states = [];
foreach ( $lib_data as $item){
 $lib_count += $item->librarycount()->int();
 $state_name = $item->getState();
 if( !in_array($state_name, $states ) ){
 	$states[] = $state_name;
 }
};
$prison_count = count($lib_data);
$state_count = count($states); ?>
<section class="block-map">
	<div class="grid">
		<h2>Freedom Libraries Across the US</h2>
		<p>Our vision: A Freedom Library in every cellblock in every prison in America.</p>

	</div>
	<div id="map-container">
		<div id="mapbox"></div>
		<div id="mapdetail"></div>
		<!-- <div id="mapstatic"></div> -->
	</div>
</section>
<section class="map-stats">
	<div class="grid">
		<div class="statistic">
			<div class="number"><?= $lib_count ?></div> Freedom Libraries so far
		</div>
		<div class="statistic">
			<div class="number"><?= $prison_count ?></div> Adult and youth prisons with Freedom Libraries and counting
		</div>
		<div class="statistic">
			<div class="number"><?= $map_page->bookcount() ?></div> Books shipped to readers in prisons across the US to date
		</div>
	</div>
</section>
<?= css('https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.css') ?>
<?= js([
	'/assets/js/mapbox-gl.js',
	'/assets/js/map.js'
]); ?>