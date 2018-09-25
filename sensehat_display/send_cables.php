<?php

//Sending the result to python script
$result = shell_exec('python display_cables.py ');

echo $result;