<?php
// Example of result given by the database
$cables = array('DVI', 'RJ45', 'VGA');

//Sending the result to python script
$result = shell_exec('python display_cables.py ' . $cables[0] . " " . $cables[1] . " ". $cables[2]);

echo $result;