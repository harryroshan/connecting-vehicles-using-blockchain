<html>
	<head>
		<title>Connecting Vehicles Using Blockchain</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="fontawesome-free-5.4.1-web\css\all.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col">
				</div>
				<div id="signup_area" class="col-md-7">
					<h3>Create Your Account</h3>
					<hr>
					<?php
						if(isset($_GET["msg"]))
						{
							if($_GET["msg"] == 'email_failed')
							{
								echo "<span style='color:red'>There is already an account with the entered email ID</span></br></br>";
							}
							else if($_GET["msg"] == 'password_failed')
							{
								echo "<span style='color:red'>The entered password and re-entered password did not match!<br>Please enter the passwords correctly</span></br></br>";
							}
							else if($_GET["msg"] == 'mac_id_failed')
							{
								echo "<span style='color:red'>The entered vehicle MAC ID has already been registered to another account</span></br></br>";
							}
							else if($_GET["msg"] == 'registration_no_failed')
							{
								echo "<span style='color:red'>The entered vehicle registration number has already been registered to another account</span></br></br>";
							}
							else if($_GET["msg"] == 'success')
							{
								echo "<span style='color:green'>Your account has been created successfully!<br>You can access your dashboard by entering your email ID and password in the login page.</span></br></br>";
							}
						}
					?>
					<form method="post" action="signup_handler.php">
						<table style="width: 100%;">
							<tr>
								<td class="signup_option_name">Email ID: </td>
								<td class="signup_option_value"><input style="min-width:85%" type="email" name="email" placeholder="Enter your email ID" required></td>
							</tr>
							<tr>
								<td class="signup_option_name">Name: </td>
								<td class="signup_option_value"><input style="min-width:85%" type="text" name="name" placeholder="Enter your name" required></td>
							</tr>
							<tr>
								<td class="signup_option_name">MAC ID of your vehicle: </td>
								<td class="signup_option_value">
									<input size=1 maxlength=2 type="text" name="mac1" class="capitalize" required>:<input size=1 maxlength=2 type="text" name="mac2" class="capitalize" required>:<input size=1 maxlength=2 type="text" name="mac3" class="capitalize" required>:<input size=1 maxlength=2 type="text" name="mac4" class="capitalize" required>:<input size=1 maxlength=2 type="text" name="mac5" class="capitalize" required>:<input size=1 maxlength=2 type="text" name="mac6" class="capitalize" required>
								</td>
							</tr>
							<tr>
								<td class="signup_option_name">Registration no. of your vehicle: </td>
								<td class="signup_option_value">
									<input size=1 maxlength=2 type="text" name="reg1" class="capitalize" required>-<input size=1 maxlength=2 type="text" name="reg2" class="capitalize" required>-<input size=1 maxlength=3 type="text" name="reg3" class="capitalize" required>-<input size=2 maxlength=4 type="text" name="reg4" class="capitalize" required>
								</td>
							</tr>
							<tr>
								<td class="signup_option_name">Password: </td>
								<td class="signup_option_value"><input style="min-width:85%" type="password" name="password1" placeholder="Enter your desired password" required></td>
							</tr>
							<tr>
								<td class="signup_option_name">Confirm password: </td>
								<td class="signup_option_value"><input style="min-width:85%" type="password" name="password2" placeholder="Re-enter the password" required></td>
							</tr>
						</table>
						<br>
						<div style="text-align: center">
							<input id="login_button" type="submit" name="sign_up" value="Sign Up">
						</div>
					</form>
				</div>
				<div class="col">
				</div>
			</div>
		</div>
		<script src="scripts/jquery-3.3.1.js"></script>
		<script src="scripts/popper.min.js"></script>
		<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
	</body>
</html>