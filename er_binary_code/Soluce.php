<?php

const ADDR = "10.5.51.30";// ip du serveur
const DEFAULT_VALUE = ["A","9"];// solutions par defaut

// recupere les solutions du serveur sous forme de JSON
function getSolutionJSON()
{
  $ping = curl_init("http://" . ADDR . "/EscapeGame/soluce.php");// prepare l'adresse a atteidre
  curl_setopt($ping,CURLOPT_RETURNTRANSFER,true);
  if (curl_exec($ping)==true)// verifie si l'adresse est atteignable
  {
    $json = file_get_contents("http://" . ADDR . "/EscapeGame/soluce.php");
    $obj = json_decode($json);
    $Table = [$obj->soluce1,$obj->soluce2];// ajoute les donnees de soluce1 et soluce 2 dans la table qui est a retourner
  }
  else
  {
    $Table = DEFAULT_VALUE;
  }
  return $Table;// retourne les solutions sous forme de table
}
?>
