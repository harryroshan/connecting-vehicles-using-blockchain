import time
import serial
import string
import pynmea2
import RPi.GPIO as gpio

gpio.setmode(gpio.BCM)
port = "/dev/ttyAMA0" # the serial port to which the pi is connected.

'''
try:
    while 1:
        try:
            data = ser.readline()
        except:
            print("Loading...")
        if(data[0:6] == '$GPGGA'): # the long and lat data are always contained in the GPGGA string of the NMEA data
            msg = pynmea2.parse(data)
            latval = msg.latitude #parse the latitude and print
            concatlat = "Latitude:" + str(latval)
            print(concatlat) #parse the longitude and print
            longval = msg.longitude
            concatlong = "Longitude:"+ str(longval)
            print(concatlong)
            #ser.println(gps.satellites.value());
            time.sleep(1.0) #wait a little before picking the next data
except:
    time.sleep(2)
'''

def get_current_coords():
    #create a serial object 
    ser = serial.Serial(port, baudrate = 9600, timeout = 1.0)
    while 1:
        try:
            data = ser.readline()
        except:
            return "12.939552", "77.6154298333"
        if(data[0:6] == '$GPGGA'): # the long and lat data are always contained in the GPGGA string of the NMEA data
            msg = pynmea2.parse(data)
            latval = msg.latitude #parse the latitude and print
            longval = msg.longitude
            #ser.println(gps.satellites.value());
            return str(latval), str(longval)
        