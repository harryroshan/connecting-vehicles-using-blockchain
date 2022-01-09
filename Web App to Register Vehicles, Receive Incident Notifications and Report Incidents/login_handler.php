<html>
	<head>
		<title>Login Handler</title>
	</head>
	<body>
		<?php
			session_start();
			session_destroy();
			session_start();
			if(isset($_POST['log_in']))
			{
				$data_missing=array();
				if(empty($_POST['email_id']))
				{
					$data_missing[]='Email ID';
				}
				else
				{
					$email_id=trim($_POST['email_id']);
				}
				if(empty($_POST['password']))
				{
					$data_missing[]='Password';
				}
				else
				{
					$pass_word=$_POST['password'];
				}

				if(empty($data_missing))
				{
					require_once('mysqli_connect.php');
					$query="SELECT count(*) FROM user_information where email_id=? and password=SHA1(?)";
					$stmt=mysqli_prepare($dbc,$query);
					mysqli_stmt_bind_param($stmt,"ss",$email_id,$pass_word);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt,$cnt);
					mysqli_stmt_fetch($stmt);
					mysqli_stmt_close($stmt);
					//echo $cnt;
					/*$affected_rows=mysqli_stmt_affected_rows($stmt);
					$response=@mysqli_query($dbc,$query);
					echo $affected_rows;
					*/
					if($cnt==1)
					{
						$query="SELECT email_id,name,mac_id,registration_no,reputation,wallet_balance,public_key,private_key FROM user_information where email_id=?";
						$stmt=mysqli_prepare($dbc,$query);
						mysqli_stmt_bind_param($stmt,"s",$email_id);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt,$email_id,$name,$mac_id,$registration_no,$reputation,$wallet_balance,$public_key,$private_key);
						mysqli_stmt_fetch($stmt);
						mysqli_stmt_close($stmt);

						$user_info->email_id = $email_id;
						$user_info->name = $name;
						$user_info->mac_id = $mac_id;
						$user_info->registration_no = $registration_no;
						$user_info->reputation = $reputation;
						$user_info->wallet_balance = $wallet_balance;
						$user_info->public_key = $public_key;
						$user_info->private_key = $private_key;
						
						$user_info_json = json_encode($user_info);

						setcookie("user_info", $user_info_json, time() + (86400 * 30), "/");

						echo "Logged in <br>";
						$_SESSION['email_id'] = $email_id;
						$_SESSION['mac_id'] = $mac_id;
						echo $_SESSION['email_id']." is logged in";
						header("location: dashboard.php");
					}
					else
					{
						echo "Login Error";
						session_destroy();
						header('location: index.php?msg=failed');
					}
					mysqli_close($dbc);
				}
				else
				{
					echo "The following data fields were empty<br>";
					foreach($data_missing as $missing)
					{
						echo $missing ."<br>";
					}
				}
			}
			else
			{
				echo "Log In request not received !";
			}
		?>
	</body>
</html>