// select menu toggle and add listener for click event.
function setupNav(){
	const nav = document.querySelector('.nav-global');
	const menu = document.getElementById('menu-toggle');
	const menusearch = document.getElementById('search-button');
	menu.addEventListener('click', function (e) {
		nav.toggleAttribute('data-open');
		nav.dataset.nav = 'menu';
	});

	menusearch.addEventListener('click', function (e) {
		nav.toggleAttribute('data-open');
		nav.dataset.nav = 'search';
	});
}

function loadYoutubeEmbed(vid, container){
	var iframe = document.createElement('iframe');
  iframe.src = `https://www.youtube-nocookie.com/embed/${vid}?rel=0&loop=1&showinfo=0&controls=0`;
  iframe.title = "Freedom Reads";
  iframe.width = '791';
  iframe.height = '506';
  iframe.frameborder = '0';
  iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;';
  iframe.allowFullscreen = true;

  // Replace the placeholder with the iframe
  let youtubediv = container.querySelector('.video-live');
  youtubediv.appendChild(iframe);
  youtubediv.style.visibility = 'visible';

  let youtubestatic = container.querySelector('.video-static');
  youtubestatic.style.visibility = 'hidden';
}

function handleIntersection(entries, observer) {
	//load 3rd party JS only upon intersection
	//to make initial load more performant
	entries.forEach(entry => {
		let el = entry.target;
		if (entry.isIntersecting) {
			if( el.classList.contains('video-container')){
				let vid = entry.target.id;
				if( vid){
					loadYoutubeEmbed(vid, el);
				}
			}
			observer.unobserve(entry.target); // Stop observing once loaded
		}
	});
}

// Intersection observer setup
let observer = new IntersectionObserver(handleIntersection, {
	root: null, 
	threshold: 0
});

document.addEventListener("DOMContentLoaded", function(event) { 
	setupNav();
	let youtubes = document.querySelectorAll('.video-container');
	youtubes.forEach( vid =>{
		observer.observe(vid); 
	});

	const kiteblocks = document.querySelectorAll('.block-kite');
	if ( kiteblocks.length > 0 ){
		setupKites(kiteblocks);	
	}

});


function setupKites(blocks){
	 // Observe each target element
	blocks.forEach( (block,i) => {
	 	let letterscan = block.querySelector('.kite-image figure');
	 	letterscan.addEventListener('mouseover', ()=>{
	 		block.classList.add('active-kite');
	 	});
	 	letterscan.addEventListener('mouseout', ()=>{
	 		block.classList.remove('active-kite');
	 	});

		if( i%2 == 0 ){
			block.classList.add('right-aligned');
		}
		scrollobserver.observe(block);
		
	});

	const kitebg = document.querySelector('.kite-bg');
	if( kitebg ){
		const kites = document.querySelector('.kite-bg').querySelectorAll('.kite-crop');
		kites.forEach( (kite) => {
			scrollobserver.observe(kite);
		});
		// window.onscroll = function() {
		//   var scrollTop = window.scrollY || window.pageYOffset;
		//  	kites.forEach(function(el) {
		//     let kitespeed = parseInt(el.getAttribute('data-scroll-speed'));
		//     el.style.transform = 'translate3d(0,0,0) translateY(' + -(scrollTop / kitespeed ) + 'px)';
		//   });
		// };
	}

	
}

// Create an intersection observer
const scrollobserver = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      // Element is in viewport, apply scroll effect
      window.addEventListener('scroll', () => scrollEffect(entry.target));
    } else {
      // Element is out of viewport, remove scroll effect
      window.removeEventListener('scroll', () => scrollEffect(entry.target));
    }
  });
}, { threshold: [0], rootMargin: '100px 0px' }); // Adjust threshold as needed


// Define the scroll effect function
function scrollEffect(block) {
	el = block.querySelector('.kite-image');
  // const scrollTop = window.scrollY || window.pageYOffset;
  const scrollTop = block.getBoundingClientRect().top;
  let speed = parseInt(el.getAttribute('data-scroll-speed'));
  el.style.transform = 'translate3d(0,0,0) translateY(' + (scrollTop / speed ) + 'px)';
}






