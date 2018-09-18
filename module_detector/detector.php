<?php

if (stripos(shell_exec('python ./python_scripts/sensehat.py 2>&1'),"ImportError") !== false)
{
    //No SenseHat - Detect if Raspberry as Real PiFace

    echo "No Sensehat";

    if (stripos(shell_exec('python ./python_scripts/piface.py 2>&1'),"ImportError") !== false)
    {
	//Raspberry becomes Labyrinth or Server
    } else {
	//Raspberry becomes CablesDetector
    }

} else {
    //Raspberry becomes Display
    echo "RaspPi has Sensehat";
}