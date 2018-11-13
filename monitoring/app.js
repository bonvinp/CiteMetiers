document.getElementById("playParty").addEventListener("click", function(e){
  StartTimer();
  NewGame()
    .then(response => {
      console.log(response)
      StartVideo();
    })
    .catch(err => console.log(err));
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

/**
 * Requête HTTP asynchrone pour démarrer la vidéo de présentation de l'escaperoom
 * @param {boolean} pause 
 */
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

/**
 * Requête asynchrone pour créer une nouvelle partie
 */
function NewGame() {
   return fetch(`${API_ENDPOINT}/start.php`, {
    method: 'GET'
  })
}

/**
 * Requête HTTP asynchrone pour récupérer les informations de la partie en cours
 */
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

/**
 * Affiche le statut d'un raspberry
 * @param {string} selector 
 * @param {string} prefix
 * @param {boolean} status 
 */
function displayStatus(selector, prefix = '', status) {
  if (status) {
    document.querySelector(selector).innerHTML = `${prefix} <i class="fas fa-check-circle done"></i>`
  } else {
    document.querySelector(selector).innerHTML = `${prefix} <i class="fas fa-times-circle error"></i>`
  }
}

/**
 * Affiche si l'énigme a commencée ou non (si oui, heure affichée)
 * @param {string} selector 
 * @param {string} date 
 */
function displayStepDate(selector, date) {
  if (date) {
    let riddle = new Date(date)
    let minutes = riddle.getMinutes();

    if (minutes < 10) {
      minutes = `0${minutes}`
    }

    document.querySelector(selector).innerHTML = `commencée à <b>${riddle.getHours()}h${minutes}</b>`
  } else {
    document.querySelector(selector).innerHTML = `énigme pas commencée`
  }
}

/**
 * Cette fonction s'occupe de mettre à jour toute la vue 
 * du dashboard en récupérant les données du serveur
 * @param {*} json 
 */
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

  displayStepDate('#riddle1-beginning', json.start)
  displayStepDate('#riddle2-beginning', json.step1)
  displayStepDate('#riddle3-beginning', json.step2)

  //hex to binary
  document.querySelector('#masterBerry').innerHTML = `0x${json.soluce1}${json.soluce2} > ${json.binary}`

  //ping
  displayStatus('.piface-riddle1', 'Piface', json.piface_up)
  displayStatus('.piface-riddle2', 'Piface', json.piface_up)
  displayStatus('.sensehat', 'Sensehat', json.sensehat_up)
  displayStatus('.laby', 'Labyrinthe', json.laby_up)

  //laby status
  if (json.step2) {
    document.querySelector('#laby-status').innerHTML = `Labyrinthe réussi !`
  }

  //is party finish
  if (json.end) {
    document.querySelector('#party-finish').innerHTML = `La partie est terminée !`
    EndTimer();
    StartVideo(false);
  }
}

setInterval(GetGameInfo, 1000);