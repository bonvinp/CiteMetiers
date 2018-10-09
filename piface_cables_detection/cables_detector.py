#!/usr/bin/python3

import pifacedigitalio as p
import time
import cgi
import cgitb
import math

print("Content-Type: text/html")
print("")

arguments = cgi.FieldStorage()


cable1Value = arguments['first'].value
cable2Value = arguments['second'].value
cable3Value = arguments['third'].value

expectedValue = math.pow(2,int(cable1Value) - 1) + math.pow(2,int(cable2Value) - 1) + math.pow(2,int(cable3Value) - 1)

piface = p.PiFaceDigital()
allCablesConnected = False

previous = 0

while allCablesConnected == False:
    inputPortValue = piface.input_port.value
    
    if previous != inputPortValue:
        previous = inputPortValue
        

    if inputPortValue == int(expectedValue):
        allCablesConnected = True
        print("OK")
