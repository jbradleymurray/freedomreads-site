let audioBlocks = document.querySelectorAll('.block-audio');
// console.log(audioBlocks);

audioBlocks.forEach( audioblock=>{
	let block = audioblock.querySelector('.audio-group');
	let icon = block.querySelector('.audio-play');
	let mute = block.querySelector('.audio-mute');
	let audiofile = block.querySelector('.audio-file');
	let audio = new Audio(audiofile.querySelector('source').src);

	let text = block.querySelector('.audiotext-full').innerHTML;
	let typedContainer = block.querySelector('.audiotext-typed');
	let words = text.split(' ');

    let speed = parseInt(block.dataset.playspeed);

    setupTranscript( words, typedContainer );

	audio.addEventListener('loadedmetadata', function() {

      audiofile.addEventListener('ended',function(){
      	// console.log('end audio');
      	block.dataset.playing = 'false';
      	block.dataset.muted = 'false';
        //rest word visibilities
        typedContainer.querySelectorAll('.word').forEach( word=>{
            word.dataset.visible = 0;
        });
      });

      block.addEventListener('click', function(){
      	// console.log('clicked');
      	if( audiofile.muted == false){
      		audiofile.muted = true;
      		block.dataset.muted = 'true';
      	}else{
      		audiofile.muted = false;
      		block.dataset.muted = 'false';
      	}

      	if (block.dataset.playing == 'false'){      		
      		block.dataset.playing = 'true';
      		audiofile.muted = false;
      		audiofile.play();
      		fadeInWords( typedContainer, speed )
      	}
      	
      });

  });

});


function setupTranscript( words, container ){
    // console.log('words', words);
    let italic = false;
    words.forEach((word, index) => {
        const span = document.createElement('span');    
        span.className = 'word';

        if( word.includes('<em>') ){ //start italic sequence
            italic = true;
            word = word.split('>')[1]; //remove html em tags
        }else if( word.includes('</em>') ){
            word = word.split('<')[0]; //remove html em tags
            italic = 'end';
        }
        if(italic || italic == 'end'){
            span.classList.add('em');
        }
        if( italic == 'end'){
            italic = false; //close italic sequence
        }
        span.innerText = word + ' ';
        span.dataset.visible = 0;
        container.appendChild(span);
    });
}

function fadeInWords( container, speed ){
    let words = container.querySelectorAll('.word');

    let currentWordIndex = 0;

    function showNextWord() {
        if (currentWordIndex < words.length) {
            words[currentWordIndex].dataset.visible = 1;
            const pauseTime = words[currentWordIndex].textContent.length * (11 - speed) * 10;
            // console.log(pauseTime);
            currentWordIndex++;
            setTimeout(showNextWord, pauseTime); 
        }
    }

    showNextWord();
}

