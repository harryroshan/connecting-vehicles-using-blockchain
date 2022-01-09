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
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
		<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   		integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   		crossorigin=""></script>
		<script type="text/javascript">
			function notify_incident(incident_id, severity, gps_latitude, gps_longitude, date_and_time, details) {
				Swal.fire({
				  	title: '<span style="text-align: center"><i style="color: orange" class="fas fa-car-crash"></i><br>An Incident Occured Nearby</span>',
				  	onOpen: () => {
				  		var mymap = L.map('mapid').setView([gps_latitude, gps_longitude], 17);
						var marker = L.marker([gps_latitude, gps_longitude]).addTo(mymap);
						marker.bindPopup("<b>Incident occured at this location!</b>").openPopup();
						L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
									    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
									    maxZoom: 18,
									    id: 'mapbox.streets',
									    accessToken: 'pk.eyJ1IjoiaGFycnlyb3NoYW4iLCJhIjoiY2p2eXNtNTlqMGhyMjQ0cGtqcXN0Zmg4MCJ9.SQ9Vot_YpbhSjxZ4UeO95g'
									}).addTo(mymap);
				  	},
				  	html:
				  	  '<div id="mapid"></div>' +
				  	  'Severity of the Incident: <strong>' + severity + '</strong><br>' +
				  	  'Date & Time of the Incident: <strong>' + date_and_time + '</strong><br>' +
				  	  'Details: <strong>' + details + '</strong>'
				  	  ,
				 	 showCloseButton: true,
				 	 showCancelButton: true,
				 	 confirmButtonColor: 'green',
  					 cancelButtonColor: '#C00000',
				 	 confirmButtonText:
				 	   '<i class="fa fa-thumbs-up"></i> Upvote',
				 	 cancelButtonText:
				 	   '<i class="fa fa-thumbs-down"></i> Downvote',
				}).then((result) => {
					if(result.value) {
						var mac_id = '<?php echo $_SESSION['mac_id']; ?>';
				    	if(window.XMLHttpRequest)
					    {
					      xmlhttp = new XMLHttpRequest();
					    }
					    xmlhttp.open("GET","update_vote_information.php?incident_id="+incident_id+"&mac_id="+mac_id+"&vote_status=Upvoted",true);
					    xmlhttp.send();
					} else if(result.dismiss == Swal.DismissReason.cancel) {
						var mac_id = '<?php echo $_SESSION['mac_id']; ?>';
				    	if(window.XMLHttpRequest)
					    {
					      xmlhttp = new XMLHttpRequest();
					    }
					    xmlhttp.open("GET","update_vote_information.php?incident_id="+incident_id+"&mac_id="+mac_id+"&vote_status=Downvoted",true);
					    xmlhttp.send();
					} else if(result.dismiss == Swal.DismissReason.backdrop || result.dismiss == Swal.DismissReason.close) {
						var mac_id = '<?php echo $_SESSION['mac_id']; ?>';
				    	if(window.XMLHttpRequest)
					    {
					      xmlhttp = new XMLHttpRequest();
					    }
					    xmlhttp.open("GET","update_vote_information.php?incident_id="+incident_id+"&mac_id="+mac_id+"&vote_status=Did+Not+Vote",true);
					    xmlhttp.send();
					}
				})
			};
		</script>
	</head>
	<body>
		<script type="text/javascript">
			var source = new EventSource("send_notification.php");
			source.onmessage = function(event) {
				incident_data = JSON.parse(event.data);
				notify = notify_incident(incident_data.incident_id, incident_data.severity, incident_data.gps_latitude, incident_data.gps_longitude, incident_data.date_and_time, incident_data.details)
			};
		</script>
		<?php
			require_once('mysqli_connect.php');
			$query="SELECT name,reputation,registration_no,mac_id,wallet_balance FROM user_information where email_id=?";
			$stmt=mysqli_prepare($dbc,$query);
			mysqli_stmt_bind_param($stmt,"s",$_SESSION['email_id']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$name,$reputation,$registration_no,$mac_id,$wallet_balance);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
		?>
		<nav>
			<div style="display: inline-block; padding-top: 10px; padding-bottom: 9px;">
				<a class="top_nav" href="dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
	  			<!-- <a class="top_nav" href="vote_on_nearby_incidents.php"><i class="fas fa-car-crash"></i>Vote On Nearby Incidents</a> -->
	  			<a class="top_nav" href="report_new_incident.php"><i class="fas fa-comment-alt"></i>Report New Incident</a>
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
		<div class="container" style="min-width: 600px;">
			<div class="row">
				<div id="main_section" class="col-sm-12">
					<h1 id="main_section_heading"><i class="fas fa-tachometer-alt"></i> DASHBOARD</h1>
					<h3 style="display: inline-block;">Hello <?php echo $name; ?>!</h3>
					<h3 style="float: right">Reputation Score: <?php echo $reputation; ?></h3>
					<br>
					<h3 style="float: right;">Wallet Balance: <?php echo $wallet_balance; ?></h3>
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
					<?php
						$query="SELECT incident_id, severity, gps_latitude, gps_longitude, date_and_time, details, incident_status FROM incidents WHERE reporter_mac_id IN (SELECT mac_id FROM user_information WHERE email_id = ?) ORDER BY incident_id DESC LIMIT 10";
						$stmt=mysqli_prepare($dbc,$query);
						mysqli_stmt_bind_param($stmt,"s",$_SESSION['email_id']);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt,$incident_id,$severity,$gps_latitude,$gps_longitude,$date_and_time,$details,$incident_status);
						mysqli_stmt_store_result($stmt);
						if(mysqli_stmt_num_rows($stmt)==0)
						{
							echo "<center><h5 style='padding-top: 10px;'>You have not reported any incident</h5></center>";
						}
						else
						{
							echo "<tr>
								<th>Incident ID</th><th>Severity</th>
								<th>Latitude Coords</th><th>Longitude Coords</th>
								<th>Date and Time</th><th>Details</th><th>Status</th>
							</tr>";
							while(mysqli_stmt_fetch($stmt))
							{
								echo "<tr>
									<td>".$incident_id."</td><td>".$severity."</td>
									<td>".$gps_latitude."</td><td>".$gps_longitude."</td><td>".$date_and_time."</td>
									<td>".$details."</td><td>".$incident_status."</td></tr>";
			    			}
			    		}
			    		mysqli_stmt_close($stmt);
			    		mysqli_close($dbc);
					?>
					</table>
					<br>
					<br>
				</div>
			</div>
		</div>
	</body>
</html>