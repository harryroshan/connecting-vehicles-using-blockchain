'''
usage           : python blockchain_client.py
                  python blockchain_client.py -p 8080
                  python blockchain_client.py --port 8080
'''

from collections import OrderedDict

import binascii

import Crypto
import Crypto.Random
from Crypto.Hash import SHA
from Crypto.PublicKey import RSA
from Crypto.Signature import PKCS1_v1_5
import json

import requests
from flask import Flask, jsonify, request, render_template


class Transaction:
#=severity, gps_latitude, gps_longitude, date_and_time, details
    def __init__(self, sender_address, sender_private_key, severity, gps_latitude, gps_longitude, date_and_time, details, value):
        self.sender_address = sender_address
        self.sender_private_key = sender_private_key
        self.severity = severity
        self.gps_latitude = gps_latitude
        self.gps_longitude = gps_longitude
        self.date_and_time = date_and_time
        self.details = details
        self.value = value

    def __getattr__(self, attr):
        return self.data[attr]

    def to_dict(self):
        return OrderedDict({'sender_address': self.sender_address,
                            'severity': self.severity,
                            'gps_latitude': self.gps_latitude,
                            'gps_longitude': self.gps_longitude,
                            'date_and_time': self.date_and_time,
                            'details': self.details,
                            'value': self.value})

    def sign_transaction(self):
        """
        Sign transaction with private key
        """
        private_key = RSA.importKey(binascii.unhexlify(self.sender_private_key))
        signer = PKCS1_v1_5.new(private_key)
        h = SHA.new(str(self.to_dict()).encode('utf8'))
        return binascii.hexlify(signer.sign(h)).decode('ascii')



app = Flask(__name__)

@app.route('/')
def index():
	return render_template('./index.html')

@app.route('/make/transaction')
def make_transaction():
    return render_template('./make_transaction.html')

@app.route('/view/transactions')
def view_transaction():
    return render_template('./view_transactions.html')

@app.route('/wallet/new', methods=['GET'])
def new_wallet():
	random_gen = Crypto.Random.new().read
	private_key = RSA.generate(1024, random_gen)
	public_key = private_key.publickey()
	response = {
		'private_key': binascii.hexlify(private_key.exportKey(format='DER')).decode('ascii'),
		'public_key': binascii.hexlify(public_key.exportKey(format='DER')).decode('ascii')
	}

	return jsonify(response), 200

@app.route('/generate/transaction', methods=['POST'])
def generate_transaction():
    # print(str(request.data))
    retrieved_data = json.loads(request.data)
    sender_address = retrieved_data["sender_address"]
    sender_private_key = retrieved_data["sender_private_key"]
    severity = retrieved_data["severity"]
    gps_latitude = retrieved_data["gps_latitude"]
    gps_longitude = retrieved_data["gps_longitude"]
    date_and_time = retrieved_data["date_and_time"]
    details = retrieved_data["details"]
    value = retrieved_data["value"]

    transaction = Transaction(sender_address, sender_private_key, severity, gps_latitude, gps_longitude, date_and_time, details, value)

    response = {'transaction': transaction.to_dict(), 'signature': transaction.sign_transaction()}
    #print(str(response)+"\n\n")

    return jsonify(response), 200


if __name__ == '__main__':
    from argparse import ArgumentParser

    parser = ArgumentParser()
    parser.add_argument('-p', '--port', default=8080, type=int, help='port to listen on')
    args = parser.parse_args()
    port = args.port

    app.run(host='127.0.0.1', port=port)