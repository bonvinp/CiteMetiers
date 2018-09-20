#!/usr/bin/python

from sense_hat import SenseHat
import sys

#Recuperation of the PHP variables
#cable1 = sys.argv[1]
#cable2 = sys.argv[2]
#cable3 = sys.argv[3]

cable1="HDMI"
cable2="VGA"
cable3="USB"

message=cable1 + " - " + cable2 + " - " + cable3

sense = SenseHat()

sense.clear()

sense.show_message(message, text_colour=[255, 0, 0])
