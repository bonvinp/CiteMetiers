<?php

// put your code here
// Set up database root credentials
$host = 'localhost';
$user = 'root';
$pass = 'root';
// ---- Do not edit below this ----
// Misc settings
header('Content-type: text/plain; Charset=UTF-8');
// Final import queries goes here
$export = array();
// Connect to database
try {
  $link = new PDO("mysql:host=$host;dbname=mysql", $user, $pass);
} catch (PDOException $e) {
  printf('Connect failed: %s', $e->getMessage());
  die();
}

// Get users from database
$statement = $link->prepare("select `user`, `host`, `password` FROM `user`");
$statement->execute();
while ($row = $statement->fetch()) {
  $user = $row[0];
  $host = $row[1];
  $pass = $row[2];
  $export[] = 'CREATE USER \'' . $user . '\'@\'' . $host . '\' IDENTIFIED BY \'' . $pass . '\'';
  // Fetch any permissions found in database
  $statement2 = $link->prepare('SHOW GRANTS FOR \'' . $user . '\'@\'' . $host . '\'');
  $statement2->execute();
  foreach ($statement2->fetchAll() as $row2) {
    $export[] = $row2[0];
  }
}

$link = null;
echo implode(";\n", $export);
?>