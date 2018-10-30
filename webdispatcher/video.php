<?php
/*
Author      : Guillaume Pin
Date        : 30.10.2018
Description : data management
*/
require("PDO.php");
$played = isset($_GET['play']) ? $_GET['play'] : false;

if (is_numeric($played)) {
  echo switchVideo($played);
}
else {
  echo getInfoVideo();
}

?>
