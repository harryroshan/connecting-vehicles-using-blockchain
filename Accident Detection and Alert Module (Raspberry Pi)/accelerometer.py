# Simple demo of of the ADXL345 accelerometer library.  Will print the X, Y, Z
# axis acceleration values every half second.
# Author: Tony DiCola
# License: Public Domain
import time
import datetime
import gps_coord
import send_mail_alert
import subprocess
# Import the ADXL345 module.
import Adafruit_ADXL345

def detect_topple():
    while True:
        try:
            # Create an ADXL345 instance.
            accel = Adafruit_ADXL345.ADXL345()

            # Alternatively you can specify the device address and I2C bus with parameters:
            #accel = Adafruit_ADXL345.ADXL345(address=0x54, busnum=2)

            # For example to set to +/- 16G:
            #accel.set_range(Adafruit_ADXL345.ADXL345_RANGE_16_G)

            # For example to set to 6.25 hz:
            #accel.set_data_rate(Adafruit_ADXL345.ADXL345_DATARATE_6_25HZ)
        
            while True:
                # Read the X, Y, Z axis acceleration values and print them.
                x, y, z = accel.read()
                print('X={0}, Y={1}, Z={2}'.format(x, y, z))
                # Wait half a second and repeat.
                time.sleep(0.5)
                if abs(x)>180 or abs(y)>180 or z<0:
                    print(datetime.datetime.now().isoformat()+": Accident (Toppling) Occured !!!")
                    print(datetime.datetime.now().isoformat()+": Getting the GPS co-ordinates of the vehicle:-")
                    latitude, longitude = gps_coord.get_current_coords()
                    date_and_time = str(datetime.datetime.now()).split(".")[0]
                    print(datetime.datetime.now().isoformat()+": Latitude = " + latitude + " Longitude = " + longitude)
                    mac_id = subprocess.check_output('cat /sys/class/net/wlan*/address', shell=True).decode("ascii").upper().strip("\n")
                    print(datetime.datetime.now().isoformat()+": The MAC ID of the vehicle is = " + str(mac_id))
                    send_mail_alert.send_mail(mac_id, "High", latitude, longitude, date_and_time, "The vehicle toppled")
                    print(datetime.datetime.now().isoformat()+": Sent the details of the accident via e-mail to the Control Center\n\n")

        except:
            time.sleep(0.1)
