<?php
/*
  Author      : Guillaume Pin
  Date        : 25.09.2018
  Description : data management
*/

require("PDO.php");
include('result.php');
$idGame = getInfoGameInProgress()[0]['idGameInProgress'];
$nameCable = array();
foreach (getNameCable() as $key => $value)
  $nameCable[] = $value['nameCable'];
$cableSelect[] = getInfoGameSet()[0]['cableSelect1'];
$cableSelect[] = getInfoGameSet()[0]['cableSelect2'];
$cableSelect[] = getInfoGameSet()[0]['cableSelect3'];
$indice[] = getInfoGameSet()[0]['indice1'];
$indice[] = getInfoGameSet()[0]['indice2'];

$result = new result($idGame, $cableSelect[0], $nameCable[0], $cableSelect[1], $nameCable[1], $cableSelect[2], $nameCable[2], $indice[0], $indice[1]);

$resultJSON = json_encode($result);

print_r($resultJSON);
?>
