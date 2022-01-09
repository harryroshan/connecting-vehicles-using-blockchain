'''
usage           : python blockchain.py
                  python blockchain.py -p 5000
                  python blockchain.py --port 5000
'''

from collections import OrderedDict

import binascii

import Crypto
import Crypto.Random
from Crypto.Hash import SHA
from Crypto.PublicKey import RSA
from Crypto.Signature import PKCS1_v1_5

import hashlib
import json
from time import sleep
from time import time
from urllib.parse import urlparse
from uuid import uuid4

import requests
from flask import Flask, jsonify, request, render_template
from flask_cors import CORS

import atexit
from apscheduler.schedulers.background import BackgroundScheduler



MINING_SENDER = "THE BLOCKCHAIN"
MINING_REWARD = 1
MINING_DIFFICULTY = 2


class Blockchain:

    def __init__(self):

        self.transactions = []
        self.chain = []
        self.nodes = set()
        #Generate random number to be used as node_id
        self.node_id = str(uuid4()).replace('-', '')
        #Create genesis block
        self.create_block(0, '00')


    def register_node(self, node_url):
        """
        Add a new node to the list of nodes
        """
        #Checking node_url has valid format
        parsed_url = urlparse(node_url)
        if parsed_url.netloc:
            self.nodes.add(parsed_url.netloc)
        elif parsed_url.path:
            # Accepts an URL without scheme like '192.168.0.5:5000'.
            self.nodes.add(parsed_url.path)
        else:
            raise ValueError('Invalid URL')


    def verify_transaction_signature(self, sender_address, signature, transaction):
        """
        Check that the provided signature corresponds to transaction
        signed by the public key (sender_address)
        """
        public_key = RSA.importKey(binascii.unhexlify(sender_address))
        verifier = PKCS1_v1_5.new(public_key)
        h = SHA.new(str(transaction).encode('utf8'))
        return verifier.verify(h, binascii.unhexlify(signature))


    def verify_if_transaction_already_exists(self, transaction):
        transaction_hash = self.hash(dict(transaction))
        for i in range(len(self.transactions)):
            current_transaction_hash = self.hash(dict(self.transactions[i]))
            if current_transaction_hash == transaction_hash:
                print("\nReceived transaction already exists in the transaction pool...\n")
                return True
        print("\nReceived transaction is a fresh transaction...\n")
        return False


    def submit_transaction(self, sender_address, severity, gps_latitude, gps_longitude, date_and_time, details, value, signature):
        """
        Add a transaction to transactions array if the signature verified
        """
        transaction = OrderedDict({'sender_address': sender_address,
                                    'severity': severity,
                                    'gps_latitude': gps_latitude,
                                    'gps_longitude': gps_longitude,
                                    'date_and_time': date_and_time,
                                    'details': details,
                                    'value': value})

        #Reward for mining a block
        if sender_address == MINING_SENDER:
            self.transactions.append(transaction)
            return len(self.chain) + 1
        #Manages transactions from wallet to another wallet
        else:
            transaction_verification = self.verify_transaction_signature(sender_address, signature, transaction)
            transaction_already_present = self.verify_if_transaction_already_exists(transaction)
            if transaction_verification and not transaction_already_present:
                self.transactions.append(transaction)
                return len(self.chain) + 1
            else:
                return False


    def create_block(self, nonce, previous_hash):
        """
        Add a block of transactions to the blockchain
        """
        block = {'block_number': len(self.chain) + 1,
                'timestamp': time(),
                'transactions': self.transactions,
                'nonce': nonce,
                'previous_hash': previous_hash}

        # Reset the current list of transactions
        self.transactions = []

        self.chain.append(block)
        return block


    def hash(self, block):
        """
        Create a SHA-256 hash of a block
        """
        # We must make sure that the Dictionary is Ordered, or we'll have inconsistent hashes
        block_string = json.dumps(block, sort_keys=True).encode()

        return hashlib.sha256(block_string).hexdigest()


    def proof_of_work(self):
        """
        Proof of work algorithm
        """
        last_block = self.chain[-1]
        last_hash = self.hash(last_block)

        nonce = 0
        while self.valid_proof(self.transactions, last_hash, nonce) is False:
            nonce += 1

        return nonce


    def valid_proof(self, transactions, last_hash, nonce, difficulty=MINING_DIFFICULTY):
        """
        Check if a hash value satisfies the mining conditions. This function is used within the proof_of_work function.
        """
        guess = (str(transactions)+str(last_hash)+str(nonce)).encode()
        guess_hash = hashlib.sha256(guess).hexdigest()
        return guess_hash[:difficulty] == '0'*difficulty


    def valid_chain(self, chain):
        """
        check if a blockchain is valid
        """
        last_block = chain[0]
        current_index = 1

        while current_index < len(chain):
            block = chain[current_index]
            # Check that the hash of the block is correct
            if block['previous_hash'] != self.hash(last_block):
                print("Hashes do not match!!!!")
                return False

            # Check that the Proof of Work is correct
            #Delete the reward transaction
            #transactions = block['transactions'][:-1]
            transactions = block['transactions']

            # Need to make sure that the dictionary is ordered. Otherwise we'll get a different hash
            transaction_elements = ['sender_address', 'severity', 'gps_latitude', 'gps_longitude', 'date_and_time', 'details', 'value']
            transactions = [OrderedDict((k, transaction[k]) for k in transaction_elements) for transaction in transactions]

            if not self.valid_proof(transactions, block['previous_hash'], block['nonce'], MINING_DIFFICULTY):
                return False

            last_block = block
            current_index += 1

        return True

    def resolve_conflicts(self):
        """
        Resolve conflicts between blockchain's nodes
        by replacing our chain with the longest one in the network.
        """
        #neighbours = self.nodes
        new_chain = None

        # We're only looking for chains longer than ours
        max_length = len(self.chain)

        # Grab and verify the chains from all the nodes in our network
        for node in range(0,5):
            if "500"+str(node) != str(port):
                try:
                    response = requests.get('http://localhost:500' + str(node) + '/chain')
                    print('Getting the blockchain from Node: '+str(node)+"\n")
                    #print("\nThe chain in response is = " + str(response.data))
                    if response.status_code == 200:
                        length = response.json()['length']
                        chain = response.json()['chain']
                        print("Length of the node's blockchain = "+str(length)+"\n")
                        print("Value of max_length = "+str(max_length)+"\n")
                        print("Validity of chain = "+str(self.valid_chain(chain))+"\n")
                        print("Chain = "+str(chain)+"\n")

                        # Check if the length is longer and the chain is valid
                        if length > max_length and self.valid_chain(chain):
                            print("Found a chain longer than ours !!!\n")
                            max_length = length
                            new_chain = chain
                except:
                    pass

        # Replace our chain if we discovered a new, valid chain longer than ours
        if new_chain:
            self.chain = new_chain
            return True

        return False

# Instantiate the Node
app = Flask(__name__)
CORS(app)  

# Instantiate the Blockchain
blockchain = Blockchain()

def get_latest_transactions():
    url = "http://localhost:"+str(port)+"/transactions/get"
    response = requests.get(url)
    print("Latest transactions:-\n"+str(response.json())+"\n")
    return response

def mine_blockchain():
    url = "http://localhost:"+str(port)+"/nodes/resolve"
    response = requests.get(url)
    print("Resolving blockchain/Consensus:-\n"+str(response.json())+"\n")

    response = (get_latest_transactions()).json()
    latest_transactions = response["transactions"]
    if latest_transactions:
        url = "http://localhost:"+str(port)+"/mine"
        response = requests.get(url)
        print("Response:-\n"+str(response.json())+"\n")
    print("Blockchain:-\n"+str(blockchain.chain)+"\n\n")

scheduler = BackgroundScheduler()
scheduler.add_job(func=mine_blockchain, trigger="interval", seconds=30)
scheduler.start()

atexit.register(lambda: scheduler.shutdown())


@app.route('/transactions/get', methods=['POST'])
def index():
    return render_template('./index.html')

@app.route('/configure')
def configure():
    return render_template('./configure.html')



@app.route('/transactions/new', methods=['POST'])
def new_transaction():
    values = json.loads(request.data)

    # Create a new Transaction
    transaction_result = blockchain.submit_transaction(values['transaction']['sender_address'], values['transaction']['severity'], values['transaction']['gps_latitude'], values['transaction']['gps_longitude'], values['transaction']['date_and_time'], values['transaction']['details'], values['transaction']['value'], values['signature'])

    if transaction_result == False:
        response = {'message': 'Invalid Transaction!'}
        return jsonify(response), 406
    else:
        response_for_this_node = {'message': 'Transaction will be added to Block '+ str(transaction_result)}
        for node_number in range(0,5):
            try:
                if "500"+str(node_number) != str(port):
                    url = "http://localhost:500" + str(node_number) + "/transactions/new"
                    data = json.loads(request.data.decode('utf-8'))
                    response_for_other_nodes = requests.post(url, json=data)
                    print("Sent the latest transaction to Node: "+str(node_number)+"\n")
            except:
                pass
        return jsonify(response_for_this_node), 201

@app.route('/transactions/get', methods=['GET'])
def get_transactions():
    #Get transactions from transactions pool
    transactions = blockchain.transactions

    response = {'transactions': transactions}
    return jsonify(response), 200

@app.route('/chain', methods=['GET'])
def full_chain():
    response = {
        'chain': blockchain.chain,
        'length': len(blockchain.chain),
    }
    return jsonify(response), 200

@app.route('/mine', methods=['GET'])
def mine():
    # We run the proof of work algorithm to get the next proof...
    last_block = blockchain.chain[-1]
    nonce = blockchain.proof_of_work()

    # We must receive a reward for finding the proof.
    # blockchain.submit_transaction(sender_address=MINING_SENDER, recipient_address=blockchain.node_id, value=MINING_REWARD, signature="")

    # Forge the new Block by adding it to the chain
    previous_hash = blockchain.hash(last_block)
    block = blockchain.create_block(nonce, previous_hash)

    response = {
        'message': "New Block Forged",
        'block_number': block['block_number'],
        'transactions': block['transactions'],
        'nonce': block['nonce'],
        'previous_hash': block['previous_hash'],
    }
    return jsonify(response), 200



@app.route('/nodes/register', methods=['POST'])
def register_nodes():
    values = request.form
    nodes = values.get('nodes').replace(" ", "").split(',')

    if nodes is None:
        return "Error: Please supply a valid list of nodes", 400

    for node in nodes:
        blockchain.register_node(node)

    response = {
        'message': 'New nodes have been added',
        'total_nodes': [node for node in blockchain.nodes],
    }
    return jsonify(response), 201


@app.route('/nodes/resolve', methods=['GET'])
def consensus():
    replaced = blockchain.resolve_conflicts()
    if replaced:
        print("Removing any transaction from the pool which is already present in the updated blockchain...\n")
        latest_block_transactions = (blockchain.chain[-1])["transactions"]
        for i in range(len(latest_block_transactions)):
            for j in range(len(blockchain.transactions)):
                if blockchain.hash(dict(blockchain.transactions[j])) == blockchain.hash(dict(latest_block_transactions[i])):
                    blockchain.transactions = blockchain.transactions[:j] + blockchain.transactions[j+1:]
                    print("Removed a duplicate transaction from transaction pool...\n")
                    j=j-1

        response = {
            'message': 'Our chain was replaced',
            'new_chain': blockchain.chain
        }
    else:
        response = {
            'message': 'Our chain is authoritative',
            'chain': blockchain.chain
        }
    return jsonify(response), 200


@app.route('/nodes/get', methods=['GET'])
def get_nodes():
    nodes = list(blockchain.nodes)
    response = {'nodes': nodes}
    return jsonify(response), 200



if __name__ == '__main__':
    from argparse import ArgumentParser

    parser = ArgumentParser()
    parser.add_argument('-p', '--port', default=5000, type=int, help='port to listen on')
    args = parser.parse_args()
    global port
    port = args.port

    app.run(host='127.0.0.1', port=port)