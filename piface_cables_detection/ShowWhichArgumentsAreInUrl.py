#!/usr/bin/python3
import cgi
import cgitb

print("Content-Type: text/html")
print("")

arguments = cgi.FieldStorage()
for i in arguments.keys():
    print(arguments[i].value)