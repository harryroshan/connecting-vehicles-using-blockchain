# Connecting Vehicles Using Blockchain

## Hardware & software required to run the project:
*Hardware Requirements :-*
* Raspberry Pi 3
* GPS module
* Accelerometer sensor
* Vibration sensor

*Software Requirements :-*
* Ethereum
* Solidity
* Flask
* Composer
* Ganache
* VNC Viewer
* XAMPP


## Instructions to get the project up and running:
*To run the accident detection and reporting module :-*
Step 1: Make sure laptop is connected to Wi-Fi hotspot.
Step 2: Give power to Raspberry Pi and turn it on.
Step 3: Note down the IP address for Raspberry Pi.
Step 4: Open VNC Viewer and enter the IP address of Raspberry Pi.
Step 5: Enter username and password if asked.
Step 6: Open terminal from taskbar/Ctrl+Alt+T in Raspberry Pi.
Step 7: Enter the command to start detecting accidents:
```
   sudo python3 master.py"
```

*To run the website which can be used for registration, getting accident notifications and reporting new incidents :-*
Step 1: Open XAMPP.
Step 2: Switch on Apache and MySQL.
Step 3: Open web browser and go to 127.0.0.1

*To run the blockchain which stores all the accident details :-*
Step 1: Open command prompt.
Step 2: Enter the command to start blockchain client:
```
	cd blockchain_python
	cd blockchain_client
	python blockchain_client.py -p 8080
```
Step 3: Again, open another command prompt instance.
Step 4: Enter the command to start the blockchain mining node:
```
	cd blockchain_python
	cd blockchain
	python blockchain.py -p 5000
```

*To run the script which checks for new incident emails and sends new incidents for voting :-*
Step 1: Open command prompt.
Step 2: Enter the command:
```
   python read_emails.py
```