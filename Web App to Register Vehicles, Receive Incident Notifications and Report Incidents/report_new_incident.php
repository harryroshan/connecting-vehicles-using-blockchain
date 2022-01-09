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
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   		integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   		crossorigin=""/>
		<script src="scripts/jquery-3.3.1.js"></script>
		<script src="scripts/popper.min.js"></script>
		<script src="bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
		<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   		integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   		crossorigin=""></script>
   	</head>
	<body onload="getLocation();">
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
	  			<!-- <a class="top_nav" href="vote_on_nearby_incidents.php"><i class="fas fa-car-crash"></i>Vote On Nearby Incidents</a> -->
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
		<div class="container" style="min-width: 450px;">
			<div class="row">
				<div class="col">
				</div>
				<div id="main_section" class="col-md-7">
					<center>
						<h1 id="main_section_heading" style="padding-bottom: 10px"><i class="fas fa-comment-alt"></i> REPORT NEW INCIDENT</h1>
						<form name="report_incident_form" method="post" action="report_new_incident_handler.php">
							<p>
							The number of coins to be spent for incidents of different severity are as follows:-
							</p>
							<table id="incident_coin_spend_table">
								<tr>
									<th>Severity of the Incident</th>
									<th>Amount to be spent</th>
								</tr>
								<tr>
									<td>Low</td>
									<td>10 coins</td>
								</tr>
								<tr>
									<td>Medium</td>
									<td>20 coins</td>
								</tr>
								<tr>
									<td>High</td>
									<td>30 coins</td>
								</tr>
							</table>
							<br>
							<?php
								if(isset($_GET["msg"]) && $_GET["msg"] == 'failed')
								{
									echo "<span style='color:red'>An error occured! Failed to report the incident.</span></br></br>";
								}
								else if(isset($_GET["msg"]) && $_GET["msg"] == 'insufficient_reputation')
								{
									echo "<span style='color:red'>Unable to report the incident! You do not have sufficient reputation to report this incident!</span></br></br>";
								}
								else if(isset($_GET["msg"]) && $_GET["msg"] == 'insufficient_balance')
								{
									echo "<span style='color:red'>Unable to report the incident! You do not have sufficient balance in the wallet to report this incident!</span></br></br>";
								}
								else if(isset($_GET["msg"]) && $_GET["msg"] == 'success')
								{
									echo "<span style='color:green'>Reported the incident successfully!</span></br></br>";
								}
							?>
							<table style="width: 100%;">
								<tr>
									<td class="form_option_name">Severity of the Incident: </td>
									<td class="form_option_value">
										<select name="severity">
											<option value="Low">Low</option>
											<option value="Medium">Medium</option>
											<option value="High">High</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="form_option_name">Location of the Incident: </td>
									<td class="form_option_value"><div id="mapid"></div></td>
								</tr>
								<tr>
									<td class="form_option_name">Details of the Incident: </td>
									<td class="form_option_value">
										<textarea style="width:100%;" rows="4" name="details" required>
										</textarea>
									</td>
								</tr>
							</table>
							<input type="hidden" id="gps_coord_1" name="gps_coord_1" required>
							<input type="hidden" id="gps_coord_2" name="gps_coord_2" required>
							<input id="login_button" type="submit" name="report_incident" value="Report Incident">
						</form>
					</center>
				</div>
				<div class="col">
				</div>
			</div>
		</div>
		<script>
		</script>
		<script type="text/javascript">
			function getLocation() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showPosition, function() { displayMap(12.9399, 77.6164); });
				} else { 
						alert("Geolocation is not supported by this browser.");
						displayMap(12.9399, 77.6164);
				}
			}

			function showPosition(position) {
				displayMap(position.coords.latitude, position.coords.longitude);
			}

			function displayMap(latitude, longitude) {
				document.getElementById("gps_coord_1").value = latitude;
				document.getElementById("gps_coord_2").value = longitude;
				var mymap = L.map('mapid').setView([latitude, longitude], 17);
				var marker = L.marker([latitude, longitude], {draggable:'true', autoPan:'true'}).addTo(mymap);
				marker.bindPopup("<b>Location of the Incident</b>").openPopup();
				L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
								attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
								maxZoom: 18,
								id: 'mapbox.streets',
								accessToken: 'pk.eyJ1IjoiaGFycnlyb3NoYW4iLCJhIjoiY2p2eXNtNTlqMGhyMjQ0cGtqcXN0Zmg4MCJ9.SQ9Vot_YpbhSjxZ4UeO95g'
							}).addTo(mymap);

				marker.on('mouseup', onMarkerClick);
				function onMarkerClick(e) {
					document.getElementById("gps_coord_1").value = e.latlng.lat;
					document.getElementById("gps_coord_2").value = e.latlng.lng;
				}
			}
		</script>
	</body>
</html>