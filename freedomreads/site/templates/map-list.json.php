<?php

$data = $pages->find('map')->children()->listed();
$json = [];

foreach($data as $prison) {
	$location = $prison->prisonlocation()->yaml();
	$image = false;
	if($imagefile = $prison->libraryimg()->toFile()){
		$image = (object)[
			'url' => (string)$imagefile->resize(800)->url(),
			'caption' => (string)$imagefile->caption()->kirbytextinline(),
			'alt' => (string)$imagefile->alt(),
			'credit' => (string)$imagefile->credit()->kirbytextinline()
		];
	}

  $json[] = [
  	"type" => "Feature",
  	"geometry" => (object)[
  		"type" => "Point",
  		"coordinates" => [(float)$location['lon'], (float)$location['lat']]
  	],
  	"properties" => (object)[
  		'title' => (string)$prison->title(),
  		'state' => (string)$location['region'],
  		'librarycount'  => (float)(string)$prison->librarycount(),
  		'libraryimg' => $image
  	]
  ];
}

$geojson = (object)[
	"type" => "FeatureCollection",
	"features" => $json
];

echo json_encode($geojson);
?>