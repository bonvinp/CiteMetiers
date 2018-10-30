<?php
/*
Author      : Guillaume Pin
Date        : 25.09.2018
Description : data management
*/

require("pdo.php");
include('result.php');
$getInfoGameInProgress =  getInfoGameInProgress()[0];
$getInfoGameSet =  getInfoGameSet()[0];
$idGame = $getInfoGameInProgress['idgameinprogress'];
$start = $getInfoGameInProgress['timestart'];
$step1 = $getInfoGameInProgress['timefirststep'];
$step2 = $getInfoGameInProgress['timesecondestep'];
$end = $getInfoGameInProgress['timeend'];
$success = $getInfoGameInProgress['success'];
$nameCable = array();
foreach (getNameCable() as $key => $value)
$nameCable[] = $value['namecable'];
$cableSelect[] = $getInfoGameSet['cableselect1'];
$cableSelect[] = $getInfoGameSet['cableselect2'];
$cableSelect[] = $getInfoGameSet['cableselect3'];
$indice[] = $getInfoGameSet['indice1'];
$indice[] = $getInfoGameSet['indice2'];

$result = new result($idGame,
$cableSelect[0],
$nameCable[0],
$cableSelect[1],
$nameCable[1],
$cableSelect[2],
$nameCable[2],
$indice[0],
$indice[1],
$start,
$step1,
$step2,
$end,
$success);

$resultJSON = json_encode($result);

print_r($resultJSON);
?>
