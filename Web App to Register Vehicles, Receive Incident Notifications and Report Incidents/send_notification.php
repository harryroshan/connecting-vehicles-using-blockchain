<?php
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');

	require_once('mysqli_connect.php');

	$incident_status = "New Incident";
	$query="SELECT incident_id, severity, gps_latitude, gps_longitude, date_and_time, details FROM incidents WHERE incident_status=? ORDER BY incident_id";
	$stmt=mysqli_prepare($dbc,$query);
	mysqli_stmt_bind_param($stmt,"s",$incident_status);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt ,$incident_id, $severity, $gps_latitude, $gps_longitude, $date_and_time, $details);
	mysqli_stmt_store_result($stmt);
	if(mysqli_stmt_fetch($stmt))
	{
		sleep(5);
		$query2="UPDATE incidents SET incident_status=\"Sent For Voting\" WHERE incident_id=?";
		$stmt2=mysqli_prepare($dbc,$query2);
		mysqli_stmt_bind_param($stmt2,"i",$incident_id);
		mysqli_stmt_execute($stmt2);
		$affected_rows=mysqli_stmt_affected_rows($stmt2);
		mysqli_stmt_close($stmt2);

		$details = trim($details);

		echo "data: {\"incident_id\":{$incident_id}, \"severity\":\"{$severity}\", \"gps_latitude\":\"{$gps_latitude}\", \"gps_longitude\":\"{$gps_longitude}\", \"date_and_time\":\"{$date_and_time}\", \"details\":\"{$details}\"}\n\n";
		flush();
	}
	mysqli_stmt_close($stmt);
?>