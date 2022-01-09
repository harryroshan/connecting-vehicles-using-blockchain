<?php
	session_start();
	if($_SESSION['email_id']==null)
	{
		header('location:index.php');
	}
?>
<html>
	<head>
		<title>Connecting Vehicles Using Blockchain</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="fontawesome-free-5.4.1-web\css\all.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="scripts/jquery-3.3.1.js"></script>
		<script src="scripts/popper.min.js"></script>
		<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php
			require_once('mysqli_connect.php');
			$query="SELECT name,reputation,registration_no,mac_id FROM user_information where email_id=?";
			$stmt=mysqli_prepare($dbc,$query);
			mysqli_stmt_bind_param($stmt,"s",$_SESSION['email_id']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$name,$reputation,$registration_no,$mac_id);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			mysqli_close($dbc);
		?>
		<nav>
			<div style="display: inline-block; padding-top: 10px; padding-bottom: 9px;">
				<a class="top_nav" href="dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
	  			<a class="top_nav" href="vote_on_nearby_incidents.php"><i class="fas fa-car-crash"></i>Vote On Nearby Incidents</a>
	  			<a class="top_nav" href="#"><i class="fas fa-comment-alt"></i>Report New Incident</a>
	  		</div>
  			<div id="profile_icon" class="top_nav dropdown" style="display: inline-block; padding-top: 10px; padding-bottom: 10px;">
  				<button type="button" class="btn btn-link" style="padding-bottom: 0px;" data-toggle="dropdown">
  					<i class="fas fa-user-circle fa-lg"></i>
  				</button>
  				<div class="dropdown-menu">
  					<a class="dropdown-item" href="change_password.php"><i class="fas fa-wrench"></i> Change Password</a>
  					<a class="dropdown-item" href="logout_handler.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
  				</div>
  			</div>
		</nav>
		<br>
		<br>
		<br>
		<div class="container">
			<div class="row">
				<div id="main_section" class="col-sm-12">
					<h1 id="main_section_heading"><i class="fas fa-tachometer-alt"></i> DASHBOARD</h1>
					<h3 style="display: inline-block;">Hello <?php echo $name; ?>!</h3>
					<h3 style="float: right">Your Reputation Score: <?php echo $reputation; ?></h3>
					<br>
					<br>
					<hr>
					<h4>Your Vehicle's Details</h4>
					<hr>
					<table id="vehicle_info">
						<tr><td>Registration No.:</td><td><?php echo $registration_no; ?></td></tr>
						<tr><td>MAC ID:</td><td><?php echo $mac_id; ?></td></tr>
					</table>
					<br>
					<br>
					<hr>
					<h4>Recent Incidents Reported By You</h4>
					<hr>
					<table id="my_incidents">
						<tr>
							<th>Incident ID</th><th>Reporter's MAC ID</th><th>Severity</th>
							<th>Type of Incident</th><th>GPS Co-ordinates</th><th>Date</th>
							<th>Time</th><th>Details</th><th>Status</th>
						</tr>
						<tr>
							<td>1000</td><td>00:00:00:00:00:00</td><td>High</td>
							<td>Accident</td><td>46.43, 23.83</td><td>19/04/2019</td>
							<td>22:39</td><td>Vehicle met with an accident</td><td>Approved</td>
						</tr>
						<tr>
							<td>1001</td><td>00:00:00:00:00:00</td><td>High</td>
							<td>Accident</td><td>46.43, 23.83</td><td>19/04/2019</td>
							<td>22:40</td><td>Vehicle met with an accident</td><td>Approved</td>
						</tr>
						<tr>
							<td>1002</td><td>00:00:00:00:00:00</td><td>High</td>
							<td>Accident</td><td>46.43, 23.83</td><td>19/04/2019</td>
							<td>22:41</td><td>Vehicle met with an accident</td><td>Rejected</td>
						</tr>
					</table>
					<br>
					<br>
				</div>
			</div>
		</div>
	</body>
</html>