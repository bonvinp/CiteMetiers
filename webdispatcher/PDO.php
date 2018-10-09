<?php
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
  $requete = $connexion->prepare("SELECT count(idGame) FROM games");
  $requete->execute();
  $nbGame = $requete->fetch(PDO::FETCH_ASSOC);
  return $nbGame['count(idGame)'];
}

function startNewGame(){
  $nbGame = getNbGame();
  $connexion = getConnexion();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('INSERT INTO `logs` (`timeStart`, `timeFirstStep`, `timeSecondeStep`, `timeEnd`, `idGame`) VALUES (now(), NULL, NULL, NULL, :id);');
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
  $requete = $connexion->prepare("SELECT idLog FROM logs ORDER BY idLog DESC LIMIT 1");
  $requete->execute();
  $idGameInProgress = $requete->fetch(PDO::FETCH_ASSOC);
  return $idGameInProgress['idLog'];
}

function validFirstStep(){
  $idGameInProgress = findGameInProgress();
  $connexion = getConnexion();
  try{
    $connexion->beginTransaction();
    $requete = $connexion->prepare('UPDATE `logs` SET `timeFirstStep` = now() WHERE `idLog` = :id');
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
    $requete = $connexion->prepare('UPDATE `logs` SET `timeSecondeStep` = now() WHERE `idLog` = :id');
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
    $requete = $connexion->prepare('UPDATE `logs` SET `timeEnd` = now() WHERE `idLog` = :id');
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
  $requete = $connexion->prepare('SELECT * FROM logs WHERE idLog = :id');
  $requete->bindParam(':id', $idGameInProgress, PDO::PARAM_INT);
  $requete->execute();
  $infoGameInProgress = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $infoGameInProgress;
}
?>
