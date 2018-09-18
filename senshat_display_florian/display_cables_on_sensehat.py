from sense_emu import SenseHat
import sys

#Recuperation of the PHP variables
cable1 = sys.argv[1]
cable2 = sys.argv[2]
cable3 = sys.argv[3]

message=cable1+"-"+cable2+"-"+cable3
print message

#Call of the Sense Hat
while True:
    sense = SenseHat()
    sense.show_message(message, text_colour=[255, 0, 0])
