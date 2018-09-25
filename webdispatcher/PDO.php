<?php
/*
  Author      : Guillaume Pin
  Date        : 25.09.2018
  Description : data management
*/
DEFINE('DB_HOST', "127.0.0.1");
DEFINE('DB_NAME', "ESCAPEGAME");
DEFINE('DB_USER', "root");
DEFINE('DB_PASS', "root");

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

function getNbGame(){
  $connexion = getConnexion();
  $requete = $connexion->prepare("SELECT count(idGame) FROM gameset");
  $requete->execute();
  $nbGame = $requete->fetch(PDO::FETCH_ASSOC);
  return $nbGame['count(idGame)'];
}

function startNewGame(){
  $nbGame = getNbGame();
  $connexion = getConnexion();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('INSERT INTO `gameInProgress` (`timeStart`, `timeFirstStep`, `timeSecondeStep`, `timeEnd`, `idGame`) VALUES (now(), NULL, NULL, NULL,  :id);');
    $requete->bindParam(':id', rand(1, $nbGame), PDO::PARAM_INT);
    $requete->execute();
    $connexion->commit();
    header('Location: index.php');
  }
  catch (Exception $e)
  {
    $connexion->rollback();
    echo "Error -> ".$e;
  }
}

function findGameInProgress(){
  $connexion = getConnexion();
  $requete = $connexion->prepare("SELECT idLog FROM gameInProgress ORDER BY idLog DESC LIMIT 1");
  $requete->execute();
  $idGameInProgress = $requete->fetch(PDO::FETCH_ASSOC);
  return $idGameInProgress['idLog'];
}

function validFirstStep(){
  $idGameInProgress = findGameInProgress();
  $connexion = getConnexion();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('UPDATE `gameInProgress` SET `timeFirstStep` = now() WHERE `idLog` = :id');
    $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
    $requete->execute();
    $connexion->commit();
    header('Location: index.php');
  }
  catch (Exception $e)
  {
    $connexion->rollback();
    echo "Error -> ".$e;
  }
}

function validSecondeStep(){
  $idGameInProgress = findGameInProgress();
  $connexion = getConnexion();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('UPDATE `gameInProgress` SET `timeSecondeStep` = now() WHERE `idLog` = :id');
    $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
    $requete->execute();
    $connexion->commit();
    header('Location: index.php');
  }
  catch (Exception $e)
  {
    $connexion->rollback();
    echo "Error -> ".$e;
  }
}

function validEndStep(){
  $idGameInProgress = findGameInProgress();
  $connexion = getConnexion();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('UPDATE `gameInProgress` SET `timeEnd` = now() WHERE `idLog` = :id');
    $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
    $requete->execute();
    $connexion->commit();
    header('Location: index.php');
  }
  catch (Exception $e)
  {
    $connexion->rollback();
    echo "Error -> ".$e;
  }
}

function getInfoGameInProgress(){
  $connexion = getConnexion();
  $idGameInProgress= findGameInProgress();
  $requete = $connexion->prepare('SELECT * FROM gameInProgress WHERE idLog = :id');
  $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
  $requete->execute();
  $infoGameInProgress = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $infoGameInProgress;
}

function giveUp(){
  $connexion = getConnexion();
  $idGameInProgress= findGameInProgress();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('UPDATE `gameInProgress` SET `success` = 0 WHERE `idLog` = :id');
    $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
    $requete->execute();
    $connexion->commit();
    header('Location: index.php');
  }
  catch (Exception $e)
  {
    $connexion->rollback();
    echo "Error -> ".$e;
  }
}

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
?>
