<?php
// Classe qui permet de créer des objets résultats
class Result {
  public $idGame;
  public $idCable1;
  public $nameCable1;
  public $idCable2;
  public $nameCable2;
  public $idCable3;
  public $nameCable3;
  public $soluce1;
  public $soluce2;
  public function __construct($idGame, $idCable1, $nameCable1, $idCable2, $nameCable2, $idCable3, $nameCable3, $soluce1, $soluce2)
  {
    $this->idGame = $idGame;
    $this->idCable1 = $idCable1;
    $this->nameCable1 = $nameCable1;
    $this->idCable2 = $idCable2;
    $this->nameCable2 = $nameCable2;
    $this->idCable3 = $idCable3;
    $this->nameCable3 = $nameCable3;
    $this->soluce1 = $soluce1;
    $this->soluce2 = $soluce2;
  }
}
?>
