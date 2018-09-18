<?php
// Example of result given by the database
$cables = array('HTML', 'RJ45', 'VGA');

//Sending the result to python script
$result = shell_exec('python /var/www/html/testPython.py ' . $cables[0] . " " . $cables[1] . " ". $cables[2]);

//Writing the return of the python script
echo $result;