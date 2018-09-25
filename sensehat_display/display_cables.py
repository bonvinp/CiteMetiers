#!/usr/bin/python

from sense_hat import SenseHat
import cgi
import cgitb

print "Content-Type: text/html"
print ""

arguments = cgi.FieldStorage()

cable1 = arguments['first'].value
cable2 = arguments['second'].value
cable3 = arguments['third'].value

message = cable1 + " - " + cable2 + " - " + cable3

sense = SenseHat()

sense.clear()

sense.show_message(message, text_colour=[255, 0, 0])

print "OK"
