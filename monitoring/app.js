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

function displayStatus(selector, prefix = '', status) {
  if (status) {
    document.querySelector(selector).innerHTML = `${prefix} <i class="fas fa-check-circle done"></i>`
  } else {
    document.querySelector(selector).innerHTML = `${prefix} <i class="fas fa-times-circle error"></i>`
  }
}

function RefreshView(json) {
  console.log(json)
  //piface
  document.querySelector('#cables-tofind').innerHTML = `${json.nameCable1}-${json.nameCable2}-${json.nameCable3}`

  //hexacodes
  document.querySelector('#first-hexacode-tofind').innerHTML = `"${json.soluce1}"`
  document.querySelector('#second-hexacode-tofind').innerHTML = `"${json.soluce2}"`

  //game identifier
  document.querySelector('#game-number').innerHTML = `Partie n°${json.idGame}`

  //Date of the game
  let date = new Date(json.start)
  if (date) {
    document.querySelector('#game-date > b').innerHTML = `${date.getUTCDate()}.${date.getMonth() + 1}.${date.getFullYear()}`
  }

  let riddle1Date = new Date(json.start)
  document.querySelector('#riddle1-beginning > b').innerHTML = `${riddle1Date.getHours()}h${riddle1Date.getMinutes()}`

  //document.querySelector('#riddle2-beginning > b').innerHTML = ``
  //document.querySelector('#riddle3-beginning > b').innerHTML = ``

  //hex to binary
  document.querySelector('#masterBerry').innerHTML = `0x${json.soluce1}${json.soluce2} > ${json.binary}`

  //ping
  displayStatus('.piface-riddle1', 'Piface', json.piface_up)
  displayStatus('.piface-riddle2', 'Piface', json.piface_up)
  displayStatus('.sensehat', 'Sensehat', json.sensehat_up)
  displayStatus('.laby', 'Labyrinthe', json.laby_up)

}

setInterval(GetGameInfo, 1000);