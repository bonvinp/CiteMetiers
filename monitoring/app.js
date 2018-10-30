document.getElementById("playParty").addEventListener("click", function(e){
  StartTimer();
  StartVideo();
  NewGame();
});

document.getElementById("resetParty").addEventListener("click", function(e){
  EndTimer();
  StartVideo(false);
});

const API_ENDPOINT = 'http://10.5.51.30/EscapeGame';

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
  fetch(`${API_ENDPOINT}/video.php?play=${isPaused}`, {
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

function NewGame() {
  fetch(`${API_ENDPOINT}/start.php`, {
    method: 'GET'
  })
    .then(response => {
      console.log(response)
    })
    .catch(err => console.log(err));
}

function GetGameInfo() {
  fetch(`${API_ENDPOINT}/soluce.php`, {
    method: 'GET'
  })
    .then(response => {
      response.json()
        .then(json => {
          RefreshView(json);
        });
    })
    .catch(err => console.log(err));
}

function RefreshView(json) {
  console.log(json)

  document.querySelector('#cables-tofind').innerHTML = `${json.nameCable1}-${json.nameCable2}-${json.nameCable3}`

  document.querySelector('#first-hexacode-tofind').innerHTML = `"${json.soluce1}"`;
  document.querySelector('#second-hexacode-tofind').innerHTML = `"${json.soluce2}"`;

}

setInterval(GetGameInfo, 1000);