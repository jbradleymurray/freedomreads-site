<section class="module dark">
  <div class="grid">
    <div class="block-audio-heading">
      <h3>Listen to xxx</h3>
      <p>

      </p>
      <a href="" target="_blank">Browse more episodes</a>
    </div>
    <div class="block-audio">
   
    <iframe height="200px" width="100%" frameborder="no" scrolling="no" seamless src="https://player.simplecast.com/585c4f2b-43a3-4d8b-ba98-1fc3e6bed639?dark=false"></iframe>
    </div>
  </div>



  <div class="grid" style="padding-top: 60px;">
      <div class="block-audio-mp4-heading">
          <h3>As True As I Can Write It: Erika Sánchez</h3>
          <div class="links"> 
            <a href="" target="_blank">Browse more episodes</a>
            <a href="" onclick="toggleScript()" class="transcription">Transcription</a>
          </div>
          <!-- <p>
          Our guest, Erika Sánchez, reads from her masterful debut young adult novel, I Am Not Your Perfect Mexican Daughter. Sánchez's writing is unflinching in its reckoning with teenage pain, while also somehow making you laugh out loud. This conversation combines the same qualities, returning bravely to humor between ventures into serious terrain like the stigma attached to mental health struggles in the Latinx community, and the dark places a writer needs to go in her own mind to get despair right on the page. Sánchez reflects on a family dynamic recognizable to most of us who were once adolescents: the desire to be seen for who we are and want to be, alongside the failure to imagine the lives of our parents -- and the alienation and tension this can cause, especially for the children of immigrants. For Sánchez, reading can exacerbate the distance we feel from our kin, carrying us to a million other worlds, but it's also an exercise in revolutionary empathy -- with the potential to reconnect us, and more deeply than before.
          </p> -->
        </div>
      <div class="block-audio-mp4">    
        <div class="audio-wrapper">
     
         <audio src="../assets/audio/default_tc.mp3" id="audio" class="audio audio_player" preload="metadata"></audio>
      <div class="navigation">
        <!-- <button id="prev" class="action-btn" title="Previous">
          <i class="fas fa-backward"></i>
          
        </button> -->
        <button id="play" class="action-btn action-btn-big">
          <!-- <i class="fas fa-play"></i> -->
          <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="26" cy="26" r="26" fill="black"/>
<path d="M35.5 24.634C36.1667 25.0189 36.1667 25.9811 35.5 26.366L19.75 35.4593C19.0833 35.8442 18.25 35.3631 18.25 34.5933L18.25 16.4067C18.25 15.6369 19.0833 15.1558 19.75 15.5407L35.5 24.634Z" fill="white"/>
</svg>

        </button>
        <div class="progress-container progress-range" id="progress-container">
          <div class="progress progress-bar" id="progress"></div>
        </div>
        <!-- <button id="next" class="action-btn" title="Next">
          <i class="fas fa-forward"></i>
        </button> -->
        <button class="action-btn speaker">
          <!-- <i id="speaker_icon" class="fa fa-volume-up" aria-hidden="true"></i> -->
          <svg width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.1973 7.34408C17.5577 8.7045 18.3253 10.5474 18.3329 12.4713C18.3405 14.3952 17.5874 16.2442 16.2377 17.6153M22.2075 4.25049C24.3842 6.42715 25.6124 9.37586 25.6245 12.4541C25.6366 15.5324 24.4317 18.4906 22.2723 20.6844" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M1.06403 15.3155C0.0242298 13.5825 0.0242296 11.4175 1.06403 9.68446C1.38133 9.15562 1.907 8.78517 2.51175 8.66422L4.98075 8.17042C5.12784 8.14101 5.26043 8.06212 5.35647 7.94688L9.67057 2.76994C10.8531 1.35088 11.4444 0.641344 11.9721 0.832384C12.4997 1.02342 12.4997 1.94703 12.4997 3.79424L12.4997 21.2057C12.4997 23.0529 12.4997 23.9765 11.9721 24.1675C11.4444 24.3586 10.8531 23.649 9.67057 22.23L5.35647 17.053C5.26043 16.9378 5.12784 16.8589 4.98075 16.8295L2.51175 16.3357C1.907 16.2147 1.38133 15.8443 1.06403 15.3155Z" fill="black"/>
</svg>

        </button>
        <input type="range" name="volume" class="player_slider" min="0" max="1" step="0.05" value="1"></input>
        <div class="time">
          <span class="time-elapsed">00:00</span>
          <span class="time-duration"> / 5:59</span>
        </div>
      </div>

        
        </div>
    </div>
  </div>
</section>

<script>

function toggleScript() {
    var x = document.getElementById("transcript-text");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
    console.log('working');
  }
</script>