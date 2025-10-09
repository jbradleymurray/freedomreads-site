document.addEventListener("DOMContentLoaded", function(event) { 
	let mapContainer = document.getElementById('map-container');
	if( mapContainer ){
		initializeMap();
	}
});

function initializeMap(){
	const markerColor = '#47433A';
	const mapdetail = document.getElementById('mapdetail');
	mapboxgl.accessToken = 'pk.eyJ1IjoiZnJlZWRvbXJlYWRzIiwiYSI6ImNsdWJwM3Y5djB4N3UybW54aWw1cnVta3UifQ.nXaU5D0OsxOe4IxH2R_fBw';

	const bounds = [
				 [-150.0, 20], // Southwest coordinates
				 [-50, 60] // Northeast coordinates
				 ]
	const map = new mapboxgl.Map({
				container: 'mapbox', // container ID
				style: 'mapbox://styles/freedomreads/cluuiqypb004t01omd0ym8lco',
				center: [-98.30, 36.00], // starting position [lng, lat]
				zoom: 3.5,
				minZoom: 2,
				showZoom: true,
				maxBounds: bounds
			});

	map.on('load', ()=>{
		let mapboxcontainer = document.getElementById('mapbox');
		// let mapstatic = document.getElementById('mapstatic');
		mapbox.style.visibility = 'visible';
		// mapstatic.style.visibility = 'hidden'; //toggle placeholder map visibility

		map.scrollZoom.disable();

		var mq = window.matchMedia( "(min-width: 600px)" );

		if (mq.matches){
						map.setZoom(3.5); //set map zoom level for desktop size
					} else {
						map.setZoom(2.25); //set map zoom level for mobile size
					};

					map.addSource('libraries', {
						type: 'geojson',
						data: '/map.json',
						cluster: true,
						clusterMaxZoom: 10, 
						clusterRadius: 10 
					});

					map.addLayer({
						id: 'clusters',
						type: 'circle',
						source: 'libraries',
						filter: ['has', 'point_count'],
						paint: {
							'circle-color': markerColor,
							'circle-radius': 20,
						}
					});

					map.addLayer({
						id: 'cluster-count',
						type: 'symbol',
						source: 'libraries',
						filter: ['has', 'point_count'],
						layout: {
							'text-field': ['get', 'point_count_abbreviated'],
							'text-size': 14
						},
						paint: {
							'text-color': '#ffffff'
						}
					});

					map.addLayer({
						id: 'unclustered-point',
						type: 'circle',
						source: 'libraries',
						filter: ['!', ['has', 'point_count']],
						paint: {
							'circle-color': markerColor,
							'circle-radius': 8
						}
					});

				// inspect a cluster on click
					map.on('click', 'clusters', (e) => {
						const features = map.queryRenderedFeatures(e.point, {
							layers: ['clusters']
						});
						const clusterId = features[0].properties.cluster_id;
						map.getSource('libraries').getClusterExpansionZoom(
							clusterId,
							(err, zoom) => {
								if (err) return;
								map.easeTo({
									center: features[0].geometry.coordinates,
									zoom: zoom
								});
							}
							);
					});

					map.on('click', 'unclustered-point', (e) => {

						const coordinates = e.features[0].geometry.coordinates.slice();
						// Ensure that if the map is zoomed out such that
						// multiple copies of the feature are visible, the
						// popup appears over the copy being pointed to.
						while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
							coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
						}

						const properties = e.features[0].properties;
						const libname = properties.title;
						const libstate = properties.state;
						const libcount = properties.librarycount;
						let libunit = "Libraries";
						if( libcount == 1){
							libunit = "Libary";
						}

						const libimg = JSON.parse(properties.libraryimg);
						let figure = "";
						
						if( libimg ){
						
							figure = `<figure><img src="${ libimg.url }" alt="${ libimg.alt }"></figure><figcaption>${ libimg.caption }`;
							if( libimg.credit.length > 1 ){
								figure += ` (Photo: ${libimg.credit})`;
							} 
							figure += '</figcaption>';
						}

						const popup = new mapboxgl.Popup({
							closeButton: false,
							closeOnClick: true,
						})
						.setLngLat(coordinates)
						.setHTML(
							`<div class="count">${libcount} Freedom ${libunit}</div>`
							)
						.addTo(map);

						popup.on('close', ()=>{
							mapdetail.dataset.active = "false";
						});
						//add mapdetail 
						mapdetail.innerHTML = `
						<div class="popup-content">             
						<div class="prison-name">${libname}, ${libstate}</div>
						<div class="count">${libcount} Freedom Libraries</div>      
						<div class="prison-img">${figure}</div>

						`
						mapdetail.dataset.active = "true";

					});

					mapdetail.addEventListener('click', function(){
						mapdetail.dataset.active = "false";
					});

					map.on('mouseenter', 'clusters', () => {
						map.getCanvas().style.cursor = 'pointer';
					});
					map.on('mouseleave', 'clusters', () => {
						map.getCanvas().style.cursor = '';
					});

					map.addControl(new mapboxgl.NavigationControl());

				});

	window.addEventListener('scroll', function(){
		if( mapdetail.dataset.active = "true"){
			mapdetail.dataset.active = "false";
		};
	});
}