import vibration_sensor
import accelerometer

def main():
    vibration_sensor.detect_collision()
    accelerometer.detect_topple()
    
main()