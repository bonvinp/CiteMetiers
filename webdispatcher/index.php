<?php
/*
  Author      : Guillaume Pin
  Date        : 25.09.2018
  Description : data management
*/
require("PDO.php");
?>
<html>
<head>
</head>
<body>
<?php
foreach (getInfoGameInProgress() as $key => $donnees)
{
  ?>
  <h1><?php echo "Numéro de partie : ".$donnees['idLog']; ?></h1></br>
  <b><?php echo "Début de la partie : ".$donnees['timeStart']; ?></b></br>
  <b><?php echo "Validation de la première étape : ".$donnees['timeFirstStep']; ?></b></br>
  <b><?php echo "Validation de la deuxième étape : ".$donnees['timeSecondeStep']; ?></b></br>
	<b><?php echo "Validation de la dernière étape : ".$donnees['timeEnd']; ?></b></br>
	<b><?php echo "Valeur de la partie : ".$donnees['idGame']; ?></b></br>
	<br/>
<?php
}
checkTime();
foreach (getInfoGameSet() as $key => $value) {
  echo "<br/>";
  echo $value['indice1'];
  echo "<br/>";
  echo $value['indice2'];
}
?>
<form action="press.php" methodFR="post">
<p>
    <input type="submit" value="Start" />
</p>
</form>
<form action="step1.php" methodFR="post">
<p>
    <input type="submit" value="Etape 1" />
</p>
</form>
<form action="step2.php" methodFR="post">
<p>
    <input type="submit" value="Etape 2" />
</p>
</form>
<form action="end.php" methodFR="post">
<p>
    <input type="submit" value="Fin" />
</p>
</form>
<form action="giveUp.php" methodFR="post">
<p>
    <input type="submit" value="Give Up" />
</p>
</form>
</body>
</html>
