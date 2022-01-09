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
				<div id="login_area" class="col-md-6">
					<h3>Connecting Vehicles Using Blockchain</h3>
					<br>
					<form method="post" action="login_handler.php">
						<input class="login_area_input" type="email" name="email_id" placeholder="Enter your email ID" required><br><br>
						<input class="login_area_input" type="password" name="password" placeholder="Enter your password" required><br><br>
						<?php
							if(isset($_GET["msg"]) && $_GET["msg"] == 'failed')
							{
								echo "<span style='color:red'>The email ID and/or password is incorrect</span></br></br>";
							}
						?>
						<input id="login_button" type="submit" name="log_in" value="Log In">
					</form>
					<a href="signup.php">Want to register a new account? Click here</a>
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