import smtplib, ssl

port = 465  # For SSL
sender_email = "blockchain.project.2019@gmail.com"
receiver_email = "blockchain.project.2019@gmail.com"

def send_mail(reporter_mac_id, severity, latitude, longitude, date_and_time, details):
    message = "Subject: Incident Alert\n\nReporter MAC ID: "+reporter_mac_id+"\nSeverity: "+severity+"\nGPS Coordinate - Latitude: "+latitude+"\nGPS Coordinate - Longitude: "+longitude+"\nDate and Time: "+date_and_time+"\nDetails: "+details
    # Create a secure SSL context
    context = ssl.create_default_context()
    
    with smtplib.SMTP_SSL("smtp.gmail.com", port, context=context) as server:
        server.login("blockchain.project.2019@gmail.com", "blockchain2019")
        server.sendmail(sender_email, receiver_email, message)