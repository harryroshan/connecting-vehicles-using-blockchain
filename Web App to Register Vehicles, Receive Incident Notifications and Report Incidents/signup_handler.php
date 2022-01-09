<html>
	<head>
		<title>Signup Handler</title>
	</head>
	<body>
		<?php
			require "php-restclient/restclient.php";

			session_start();
			session_destroy();
			session_start();
			if(isset($_POST['sign_up']))
			{
				$data_missing=array();
				if(empty($_POST['email']))
				{
					$data_missing[]='Email';
				}
				else
				{
					$email=trim($_POST['email']);
				}
				if(empty($_POST['name']))
				{
					$data_missing[]='Name';
				}
				else
				{
					$name=$_POST['name'];
				}
				if(empty($_POST['mac1']) || empty($_POST['mac2']) || empty($_POST['mac3']) || empty($_POST['mac4']) || empty($_POST['mac5']) || empty($_POST['mac6']))
				{
					$data_missing[]='MAC ID';
				}
				else
				{
					$mac1=trim($_POST['mac1']);
					$mac2=trim($_POST['mac2']);
					$mac3=trim($_POST['mac3']);
					$mac4=trim($_POST['mac4']);
					$mac5=trim($_POST['mac5']);
					$mac6=trim($_POST['mac6']);
					$mac_id=$mac1.":".$mac2.":".$mac3.":".$mac4.":".$mac5.":".$mac6;
				}
				if(empty($_POST['reg1']) || empty($_POST['reg2']) || empty($_POST['reg3']) || empty($_POST['reg4']))
				{
					$data_missing[]='Registration no.';
				}
				else
				{
					$reg1=trim($_POST['reg1']);
					$reg2=trim($_POST['reg2']);
					$reg3=trim($_POST['reg3']);
					$reg4=trim($_POST['reg4']);
					$registration_no=$reg1."-".$reg2."-".$reg3."-".$reg4;
				}
				if(empty($_POST['password1']))
				{
					$data_missing[]='Password1';
				}
				else
				{
					$password1=$_POST['password1'];
				}
				if(empty($_POST['password2']))
				{
					$data_missing[]='Password2';
				}
				else
				{
					$password2=$_POST['password2'];
				}

				if(empty($data_missing))
				{
					if($password1 != $password2)
					{
						echo "Entered password and Re-entered password does not match!";
						session_destroy();
						echo mysqli_error();
						header('location:signup.php?msg=password_failed');
					}
					else
					{
						$api = new RestClient([
						    'base_url' => "http://localhost:8080"
						]);

						$result = $api->get("/wallet/new");

						if($result->info->http_code == 200)
						    $keys = json_decode(strval($result->response), true);
							echo "REST Output: ";
							print_r($keys);

						$public_key=$keys['public_key'];
						$private_key=$keys['private_key'];

						require_once('mysqli_connect.php');
						$query="INSERT INTO user_information(email_id,name,mac_id,registration_no,password,public_key,private_key) VALUES (?,?,?,?,SHA1(?),?,?)";
						$stmt=mysqli_prepare($dbc,$query);
						mysqli_stmt_bind_param($stmt,"sssssss",$email,$name,$mac_id,$registration_no,$password1,$public_key,$private_key);
						mysqli_stmt_execute($stmt);
						$affected_rows=mysqli_stmt_affected_rows($stmt);
						echo $affected_rows."<br>";
						mysqli_stmt_close($stmt);
						/*
						$response=@mysqli_query($dbc,$query);
						*/
						if($affected_rows==1)
						{
							mysqli_close($dbc);
							echo "User is successfully signed up<br>";
							header('location:signup.php?msg=success');
							$_SESSION['email_id']=$email;
							echo $_SESSION['email_id']." is logged in";
						}
						else
						{
							$query="SELECT count(*) FROM user_information where email_id=?";
							$stmt=mysqli_prepare($dbc,$query);
							mysqli_stmt_bind_param($stmt,"s",$email);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_bind_result($stmt,$cnt);
							mysqli_stmt_fetch($stmt);
							mysqli_stmt_close($stmt);
							if($cnt>0)
							{
								mysqli_close($dbc);
								echo "Signup Error";
								session_destroy();
								echo mysqli_error();
								header('location:signup.php?msg=email_failed');
							}
							else
							{
								$query="SELECT count(*) FROM user_information where mac_id=?";
								$stmt=mysqli_prepare($dbc,$query);
								mysqli_stmt_bind_param($stmt,"s",$mac_id);
								mysqli_stmt_execute($stmt);
								mysqli_stmt_bind_result($stmt,$cnt);
								mysqli_stmt_fetch($stmt);
								mysqli_stmt_close($stmt);
								if($cnt>0)
								{
									mysqli_close($dbc);
									echo "Signup Error";
									session_destroy();
									echo mysqli_error();
									header('location:signup.php?msg=mac_id_failed');
								}
								else
								{
									$query="SELECT count(*) FROM user_information where registration_no=?";
									$stmt=mysqli_prepare($dbc,$query);
									mysqli_stmt_bind_param($stmt,"s",$registration_no);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_bind_result($stmt,$cnt);
									mysqli_stmt_fetch($stmt);
									mysqli_stmt_close($stmt);
									if($cnt>0)
									{
										mysqli_close($dbc);
										echo "Signup Error";
										session_destroy();
										echo mysqli_error();
										header('location:signup.php?msg=registration_no_failed');
									}
								}
							}
						}
					}
				}
				else
				{
					echo "The following data fields were empty<br>";
					foreach($data_missing as $missing)
					{
						echo $missing ."<br>";
					}
					session_destroy();
				}
			}
			else
			{
				echo "Sign Up request not received !";
			}
		?>
	</body>
</html>
