document.getElementById("playParty").addEventListener("click", function(e){
  Start();
  StartVideo();
});

document.getElementById("stopParty").addEventListener("click", function(e){
  Stop();
});

document.getElementById("resetParty").addEventListener("click", function(e){
  End();
  StartVideo(false);
});

const TIMETOWORK = 60*15;
const ONESECOND = 1;
let time = TIMETOWORK;
let timer;
let start = 0;
Display(TIMETOWORK);

function Start(){
  if(!start){
    timer = setInterval(NewTime, 1000);
    start = 1;
  }
}

function End(){
  clearInterval(timer);
  time = TIMETOWORK;
  start = 0;
  Display(TIMETOWORK);
}

function Stop() {
  clearInterval(timer);
  start = 0;
}

function NewTime(){
  time -= ONESECOND;
  Display(time);
}

function Display(ActualTime){
  let seconds = Math.floor(ActualTime % 60).toString();
  let minutes = Math.floor(ActualTime / 60).toString();
  if (seconds.length === 1 ) {
      seconds = '0' + seconds;
  }
                    
  document.getElementById("timer").innerHTML = minutes + ':' + seconds;
}

function StartVideo(pause = true) {
  let isPaused = +pause;
  fetch(`http://10.5.51.30/EscapeGame/video.php?play=${isPaused}`, {
    method: 'GET'
  })
    .then(response => {
      response.json()
        .then(json => {
          console.log(json);
        });
    })
    .catch(err => console.log(err));
}