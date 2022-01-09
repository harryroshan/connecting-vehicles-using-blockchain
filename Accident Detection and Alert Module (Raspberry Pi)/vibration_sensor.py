#!/usr/bin/python
import RPi.GPIO as GPIO
import time
import datetime
import gps_coord
import send_mail_alert
import subprocess

#GPIO SETUP
channel = 17
GPIO.setmode(GPIO.BCM)
GPIO.setup(channel, GPIO.IN)

def callback(channel):
        if GPIO.input(channel):
                print(datetime.datetime.now().isoformat()+": Accident (Collision) Occured !!!")
                print(datetime.datetime.now().isoformat()+": Getting the GPS co-ordinates of the vehicle:-")
                latitude, longitude = gps_coord.get_current_coords()
                print(datetime.datetime.now().isoformat()+": Latitude = " + latitude + " Longitude = " + longitude)
                date_and_time = str(datetime.datetime.now()).split(".")[0]
                mac_id = subprocess.check_output('cat /sys/class/net/wlan*/address', shell=True).decode("ascii").upper().strip("\n")
                print(datetime.datetime.now().isoformat()+": The MAC ID of the vehicle is = " + str(mac_id))
                send_mail_alert.send_mail(mac_id, "High", latitude, longitude, date_and_time, "The vehicle collided with another vehicle/object")
                print(datetime.datetime.now().isoformat()+": Sent the details of the accident via e-mail to the Control Center\n\n")

def detect_collision():
    GPIO.add_event_detect(channel, GPIO.BOTH, bouncetime=300)  # let us know when the pin goes HIGH or LOW
    GPIO.add_event_callback(channel, callback)  # assign function to GPIO PIN, Run function on change
    