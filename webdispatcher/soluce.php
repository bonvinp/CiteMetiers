<?php
/*
  Author      : Guillaume Pin
  Date        : 25.09.2018
  Description : data management
*/
require("PDO.php");
foreach (getInfoGameSet() as $key => $value) {
  echo $value['indice1'];
  echo $value['indice2'];
}
 ?>
