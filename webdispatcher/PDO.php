<?php
/*
  Author      : Guillaume Pin
  Date        : 25.09.2018
  Description : data management
*/

// Variable pour la connexion à la base de données
DEFINE('DB_HOST', "127.0.0.1");
DEFINE('DB_NAME', "ESCAPEGAME");
DEFINE('DB_USER', "root");
DEFINE('DB_PASS', "root");

// Méthode qui permet de créer une variable static pour la connexion à la base de données
function getConnexion(){
  static $dbb = null;
  try{
    if($dbb === null)
    {
      $connectionString="mysql:host=".DB_HOST.";dbname=".DB_NAME.'';
      $dbb = new PDO($connectionString, DB_USER, DB_PASS);
      $dbb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
  }
  catch(PDOException $e)
  {
    die("Erreur : ".$e->getMEssage());
  }
  return $dbb;
}

// Méthode qui permet de savoir le nombre de partie différente
function getNbGame(){
  $connexion = getConnexion();
  $requete = $connexion->prepare("SELECT count(idGame) FROM gameset");
  $requete->execute();
  $nbGame = $requete->fetch(PDO::FETCH_ASSOC);
  return $nbGame['count(idGame)'];
}

// Méthode qui permet de démarrer une nouvelle partie
function startNewGame(){
  $nbGame = getNbGame();
  $connexion = getConnexion();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('INSERT INTO `gameInProgress` (`timeStart`, `timeFirstStep`, `timeSecondeStep`, `timeEnd`, `idGame`) VALUES (now(), NULL, NULL, NULL,  :id);');
    $requete->bindParam(':id', rand(1, $nbGame), PDO::PARAM_INT);
    $requete->execute();
    $connexion->commit();
  }
  catch (Exception $e)
  {
    $connexion->rollback();
    echo "Error -> ".$e;
  }
}

// Méthode qui permet de trouver la partie qui est actuellement en cours
// Pour cela on regarde la dernière partie commencé dans la base
function findGameInProgress(){
  $connexion = getConnexion();
  $requete = $connexion->prepare("SELECT idGameInProgress FROM gameInProgress ORDER BY idGameInProgress DESC LIMIT 1");
  $requete->execute();
  $idGameInProgress = $requete->fetch(PDO::FETCH_ASSOC);
  return $idGameInProgress['idGameInProgress'];
}

// Méthode qui permet de valider la première étape
function validFirstStep(){
  $idGameInProgress = findGameInProgress();
  $connexion = getConnexion();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('UPDATE `gameInProgress` SET `timeFirstStep` = now() WHERE `idGameInProgress` = :id');
    $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
    $requete->execute();
    $connexion->commit();
  }
  catch (Exception $e)
  {
    $connexion->rollback();
    echo "Error -> ".$e;
  }
}

// Méthode qui permet de valider la deuxième étape
function validSecondeStep(){
  $idGameInProgress = findGameInProgress();
  $connexion = getConnexion();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('UPDATE `gameInProgress` SET `timeSecondeStep` = now() WHERE `idGameInProgress` = :id');
    $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
    $requete->execute();
    $connexion->commit();
  }
  catch (Exception $e)
  {
    $connexion->rollback();
    echo "Error -> ".$e;
  }
}

// Méthode qui permet de valider la dernière étape
function validEndStep(){
  $idGameInProgress = findGameInProgress();
  $connexion = getConnexion();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('UPDATE `gameInProgress` SET `timeEnd` = now() WHERE `idGameInProgress` = :id');
    $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
    $requete->execute();
    $connexion->commit();
  }
  catch (Exception $e)
  {
    $connexion->rollback();
    echo "Error -> ".$e;
  }
  checkTime();
}

// Méthode qui permet de récuperer les informations de la partie en cours
function getInfoGameInProgress(){
  $connexion = getConnexion();
  $idGameInProgress= findGameInProgress();
    $requete = $connexion->prepare('SELECT * FROM gameInProgress WHERE idGameInProgress	 = :id');
  $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
  $requete->execute();
  $infoGameInProgress = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $infoGameInProgress;
}

// Méthode qui permet de déclarer une défaite
// Pour cela il y a dans la table gameinprogress la valeur de success à 0
function giveUp(){
  $connexion = getConnexion();
  $idGameInProgress= findGameInProgress();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('UPDATE `gameInProgress` SET `success` = 0 WHERE `idGameInProgress` = :id');
    $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
    $requete->execute();
    $connexion->commit();
  }
  catch (Exception $e)
  {
    $connexion->rollback();
    echo "Error -> ".$e;
  }
}

// Méthode qui permet de vérifier la différence de temps entre le début et la fin de l'escape game
function checkTime(){
  $infoGameInProgress = getInfoGameInProgress();
  foreach (getInfoGameInProgress() as $key => $donnees)
  {
      $timeStart = $donnees['timeStart'];
      $timeEnd = $donnees['timeEnd'];
  }
  $timeStart = new DateTime($timeStart);
  $timeEnd = new DateTime($timeEnd);
  $diff = 15 * 60;
  if($timeEnd->getTimeStamp() - $timeStart->getTimeStamp() > $diff)
    giveUp();
}

// Méthode qui permet de recuperer les informations du template de partie
function getInfoGameSet(){
  $connexion = getConnexion();
  $idGameInProgress = findGameInProgress();
  foreach (getInfoGameInProgress() as $key => $donnees)
  {
      $idGame = $donnees['idGame'];
  }
  $requete = $connexion->prepare('SELECT * FROM gameset WHERE idGame = :id');
  $requete->bindParam(':id', $idGame, PDO::PARAM_INT);
  $requete->execute();
  $infoGameInProgress = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $infoGameInProgress;
}

// Méthode qui permet de récupérer les noms des câbles
function getNameCable(){
  $connexion = getConnexion();
  $tableCable = array();
  $result = array();
  foreach (getInfoGameSet() as $key => $value) {
    $tableCable[] = $value['cableSelect1'];
    $tableCable[] = $value['cableSelect2'];
    $tableCable[] = $value['cableSelect3'];
  }
  foreach ($tableCable as $value) {
    $requete = $connexion->prepare('SELECT nameCable FROM cables WHERE idCable = :idCable');
    $requete->bindParam(':idCable', $value, PDO::PARAM_INT);
    $requete->execute();
    $result[]  = $requete->fetch(PDO::FETCH_ASSOC);
  }
  return $result;
}
?>
