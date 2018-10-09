import pifacedigitalio as p
import time

piface = p.PiFaceDigital()
while True:
    print(piface.input_port.value)
    time.sleep(0.2)
