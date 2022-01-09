import imaplib
import email
import time
import datetime
import mysql.connector
import requests
import threading

FROM_EMAIL  = "blockchain.project.2019@gmail.com"
FROM_PWD    = "blockchain2019"
SMTP_SERVER = "imap.gmail.com"
SMTP_PORT   = 993

def add_incident_to_blockchain(reporter_mac_id, severity, gps_latitude, gps_longitude, date_and_time, details):
    mydb = mysql.connector.connect(
              host="localhost",
              user="Harry",
              passwd="passpasshello",
              database="blockchain_database"
            )
    mycursor = mydb.cursor()
    mycursor.execute("SELECT public_key, private_key FROM user_information WHERE mac_id='"+reporter_mac_id+"'")
    myresult = mycursor.fetchall()
                        
    public_key = myresult[0][0]
    private_key = myresult[0][1]

    value=10
    if severity=="Low":
        value=10
    elif severity=="Medium":
        value=20
    elif severity=="High":
        value=30

    url = "http://localhost:8080/generate/transaction"
    data = {"sender_address": public_key, "sender_private_key": private_key, "severity": severity, "gps_latitude": gps_latitude, "gps_longitude": gps_longitude, "date_and_time": date_and_time, "details": details, "value": value}
    response = requests.post(url, json=data)
    print("\n"+str(response.json())+"\n")

    url = "http://localhost:5000/transactions/new"
    data = response.json()
    response = requests.post(url, json=data)
    print("\n"+str(response.json())+"\n")


def check_vote_status_of_incident(incident_id, reporter_mac_id, severity, gps_latitude, gps_longitude, date_and_time, details):
        time.sleep(60)
        print(str(datetime.datetime.now()) + ": Checking if incident with ID: "+str(incident_id)+" was upvoted or downvoted by nearby vehicles...")
        mydb = mysql.connector.connect(
              host="localhost",
              user="Harry",
              passwd="passpasshello",
              database="blockchain_database"
            )
        mycursor = mydb.cursor()
        mycursor.execute("SELECT count(*) FROM vote_information WHERE incident_id='"+str(incident_id)+"' AND vote_status='Upvoted'")
        myresult = mycursor.fetchall()
        upvote_count = myresult[0][0]

        mycursor.execute("SELECT count(*) FROM vote_information WHERE incident_id='"+str(incident_id)+"' AND vote_status='Downvoted'")
        myresult = mycursor.fetchall()
        downvote_count = myresult[0][0]

        current_reputation = 0
        new_reputation = 0

        if upvote_count >= downvote_count:
            print(str(datetime.datetime.now()) + ": The incident with ID: "+str(incident_id)+" is approved. Adding the incident to the blockchain...")
            add_incident_to_blockchain(reporter_mac_id, severity, gps_latitude, gps_longitude, date_and_time, details)
            
            sql = "UPDATE incidents SET incident_status='Approved' WHERE incident_id='"+str(incident_id)+"'"
            mycursor.execute(sql)
            mydb.commit()

            mycursor.execute("SELECT reputation FROM user_information WHERE mac_id='"+str(reporter_mac_id)+"'")
            myresult = mycursor.fetchall()
            current_reputation = myresult[0][0]

            if current_reputation>95:
                new_reputation = 100
            else:
                new_reputation = current_reputation + 5

            sql = "UPDATE user_information SET reputation="+str(new_reputation)+" WHERE mac_id='"+str(reporter_mac_id)+"'"
            mycursor.execute(sql)
            mydb.commit()

            value=10
            if severity=="Low":
                value=10
            elif severity=="Medium":
                value=20
            elif severity=="High":
                value=30
            sql = "UPDATE user_information SET wallet_balance=wallet_balance+"+str(value)+" WHERE mac_id='"+str(reporter_mac_id)+"'"
            mycursor.execute(sql)
            mydb.commit()

        else:
            print(str(datetime.datetime.now()) + ": The incident with ID: "+str(incident_id)+" is disapproved")

            sql = "UPDATE incidents SET incident_status='Disapproved' WHERE incident_id='"+str(incident_id)+"'"
            mycursor.execute(sql)
            mydb.commit()

            mycursor.execute("SELECT reputation FROM user_information WHERE mac_id='"+str(reporter_mac_id)+"'")
            myresult = mycursor.fetchall()
            current_reputation = myresult[0][0]

            if current_reputation<10:
                new_reputation = 0
            else:
                new_reputation = current_reputation - 10

            sql = "UPDATE user_information SET reputation="+str(new_reputation)+" WHERE mac_id='"+str(reporter_mac_id)+"'"
            mycursor.execute(sql)
            mydb.commit()


def read_email_from_gmail():
    mail = imaplib.IMAP4_SSL(SMTP_SERVER)
    mail.login(FROM_EMAIL,FROM_PWD)
    mail.select('inbox')

    type, data = mail.search(None, 'ALL')
    mail_ids = data[0]

    id_list = mail_ids.split()   
    first_email_id = int(id_list[0])
    previous_latest_email_id = first_email_id

    mydb = mysql.connector.connect(
      host="localhost",
      user="Harry",
      passwd="passpasshello",
      database="blockchain_database"
    )

    while True:
        print(str(datetime.datetime.now()) + ": Checking for new e-mails...")

        mail.select('inbox')
        try:
            type, data = mail.search(None, 'ALL')
            mail_ids = data[0]

            id_list = mail_ids.split()   
            latest_email_id = int(id_list[-1]) + 1

            for i in range(previous_latest_email_id, latest_email_id): 
                typ, data = mail.fetch(str(i), '(RFC822)' )
                for response_part in data:
                    if isinstance(response_part, tuple):
                        msg = email.message_from_string(response_part[1].decode('utf-8'))
                        email_subject = msg['subject']
                        email_from = msg['from']
                        email_content = msg.get_payload()
                        # print('From : ' + str(email_from) + '\n')
                        # print('Subject : ' + str(email_subject) + '\n')
                        # print('Content : \n' + str(email_content))
                        # print("-----------------------------------------------------------------------------")
                        print(str(datetime.datetime.now()) + ": Parsing the retrieved e-mail...")
                        for line in str(email_content).splitlines():
                            if line.strip():
                                key = line.split(":",1)[0]
                                value = line.split(":",1)[1]
                                # print("key="+key+" value="+value)
                                if key=="Reporter MAC ID":
                                    reporter_mac_id=value.strip()
                                if key=="Severity":
                                    severity=value.strip()
                                if key=="GPS Coordinate - Latitude":
                                    gps_latitude=value
                                if key=="GPS Coordinate - Longitude":
                                    gps_longitude=value
                                if key=="Date and Time":
                                    date_and_time=value
                                if key=="Details":
                                    details=value

                        #Insert the retrieved incident details into the database
                        mycursor = mydb.cursor()

                        sql = "INSERT INTO incidents (reporter_mac_id, severity, gps_latitude, gps_longitude, date_and_time, details) VALUES (%s, %s, %s, %s, %s, %s)"
                        val = (reporter_mac_id, severity, gps_latitude, gps_longitude, date_and_time, details)
                        mycursor.execute(sql, val)

                        mydb.commit()

                        print(mycursor.rowcount, "record inserted.")

                        incident_id = mycursor.lastrowid

                        mycursor.execute("SELECT mac_id FROM user_information")
                        mac_id_list = mycursor.fetchall()
                        for x in mac_id_list:
                            mycursor = mydb.cursor()
                            sql = "INSERT INTO vote_information (incident_id, mac_id, vote_status) VALUES (%s, %s, %s)"
                            val = (incident_id, x[0], "Not Voted Yet")
                            mycursor.execute(sql, val)
                            mydb.commit()

                        check_vote_status_thread = threading.Thread(target=check_vote_status_of_incident, args=(incident_id, reporter_mac_id, severity, gps_latitude, gps_longitude, date_and_time, details))
                        check_vote_status_thread.start()

            previous_latest_email_id = latest_email_id

        except Exception as e:
            print(str(e))

        time.sleep(5)

read_email_from_gmail()