document.getElementById("playParty").addEventListener("click", function(e){
  StartTimer();
  StartVideo();
});

document.getElementById("resetParty").addEventListener("click", function(e){
  EndTimer();
  StartVideo(false);
});

const TIMETOWORK = 60*15;
const ONESECOND = 1;
let time = TIMETOWORK;
let timer;
let start = 0;
DisplayTimer(TIMETOWORK);

function StartTimer(){
  if(!start){
    timer = setInterval(NewTime, 1000);
    start = 1;
  }
}

function EndTimer(){
  clearInterval(timer);
  time = TIMETOWORK;
  start = 0;
  DisplayTimer(TIMETOWORK);
}

function StopTimer() {
  clearInterval(timer);
  start = 0;
}

function NewTime(){
  time -= ONESECOND;
  DisplayTimer(time);
}

function DisplayTimer(ActualTime){
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