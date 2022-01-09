<?php
	session_start();
?>
<html>
	<head>
		<title>Connecting Vehicles Using Blockchain</title>
	</head>
	<body>
		<?php
			if(isset($_POST['report_incident']))
			{
				$data_missing=array();
				if(empty($_POST['severity']))
				{
					$data_missing[]='Severity';
				}
				else
				{
					$severity=trim($_POST['severity']);
				}
				if(empty($_POST['gps_coord_1']))
				{
					$data_missing[]='GPS Coordinate - Latitude';
				}
				else
				{
					$gps_coord_1=$_POST['gps_coord_1'];
				}
				if(empty($_POST['gps_coord_2']))
				{
					$data_missing[]='GPS Coordinate - Longitude';
				}
				else
				{
					$gps_coord_2=$_POST['gps_coord_2'];
				}
				if(empty($_POST['details']))
				{
					$data_missing[]='Details';
				}
				else
				{
					$details=$_POST['details'];
				}

				if(empty($data_missing))
				{

					require_once('mysqli_connect.php');
					$query="SELECT mac_id FROM user_information where email_id=?";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"s",$_SESSION['email_id']);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt,$reporter_mac_id);
					mysqli_stmt_fetch($stmt);
					mysqli_stmt_close($stmt);

					$date = date("Y-m-d");
					$time = date("H:i:s");

					$query="SELECT reputation, wallet_balance FROM user_information where email_id=?";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"s",$_SESSION['email_id']);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt,$reputation,$wallet_balance);
					mysqli_stmt_fetch($stmt);
					mysqli_stmt_close($stmt);

					$amount_to_be_spent = 0;
					if($severity=="High")
						$amount_to_be_spent = 30;
					else if($severity=="Medium")
						$amount_to_be_spent = 20;
					else if($severity=="Low")
						$amount_to_be_spent = 10;

					if(intval($reputation) < 70 or intval($wallet_balance) < $amount_to_be_spent)
					{
						if(intval($reputation) < 70)
						{
							echo "Reputation = ".$reputation;
							echo "Unable to report the incident due to insufficent reputation!";
							header('location:report_new_incident.php?msg=insufficient_reputation');
						}
						if(intval($wallet_balance) < $amount_to_be_spent)
						{
							echo "Wallet balance = ".$wallet_balance;
							echo "Unable to report the incident due to insufficent wallet balance!";
							header('location:report_new_incident.php?msg=insufficient_balance');
						}
					}
					else
					{
						$new_wallet_balance = $wallet_balance-$amount_to_be_spent;
						$query="UPDATE user_information SET wallet_balance = ? WHERE email_id = ?;";
						$stmt=mysqli_prepare($dbc,$query);
						mysqli_stmt_bind_param($stmt,"ss",$new_wallet_balance,$_SESSION['email_id']);
						mysqli_stmt_execute($stmt);
						$affected_rows=mysqli_stmt_affected_rows($stmt);
						echo $affected_rows."<br>";
						mysqli_stmt_close($stmt);
						mysqli_close($dbc);
						//----------------------------------------------------------------------
						require_once "vendor/autoload.php";

						$mail = new PHPMailer\PHPMailer\PHPMailer();

						$mail->SMTPOptions = array(
						    	'ssl' => array(
						        'verify_peer' => false,
						        'verify_peer_name' => false,
						        'allow_self_signed' => true
						    )
						);

						//Enable SMTP debugging. 
						$mail->SMTPDebug = 3;                               
						//Set PHPMailer to use SMTP.
						$mail->isSMTP();            
						//Set SMTP host name                          
						$mail->Host = "smtp.gmail.com";
						//Set this to true if SMTP host requires authentication to send email
						$mail->SMTPAuth = true;                          
						//Provide username and password     
						$mail->Username = "blockchain.project.2019@gmail.com";                 
						$mail->Password = "blockchain2019";                           
						//If SMTP requires TLS encryption then set it
						$mail->SMTPSecure = "tls";                           
						//Set TCP port to connect to 
						$mail->Port = 587;                                   

						$mail->From = "blockchain.project.2019@gmail.com";
						$mail->FromName = "Vehicle";

						$mail->addAddress("blockchain.project.2019@gmail.com", "Mail Server");

						#$mail->isHTML(true);

						$mail->Subject = "Incident Alert";
						$mail->Body = "Reporter MAC ID: ".$reporter_mac_id."\nSeverity: ".$severity."\nGPS Coordinate - Latitude: ".$gps_coord_1."\nGPS Coordinate - Longitude: ".$gps_coord_2."\nDate and Time: ".$date." ".$time."\nDetails: ".$details;
						// $mail->AltBody = "This is the plain text version of the email content";

						if(!$mail->send()) 
						{
						    echo "Mailer Error: " . $mail->ErrorInfo;
						    header('location:report_new_incident.php?msg=failed');
						} 
						else 
						{
						    echo "Message has been sent successfully";
						    header('location:report_new_incident.php?msg=success');
						}
						//----------------------------------------------------------------------
					}
				}
				else
				{
					echo "The following data fields were empty<br>";
					foreach($data_missing as $missing)
					{
						echo $missing ."<br>";
					}
					header('location:report_new_incident.php?msg=failed');
				}
			}
			else
			{
				echo "Report Incident request not received !";
			}
		?>
	</body>
</html>