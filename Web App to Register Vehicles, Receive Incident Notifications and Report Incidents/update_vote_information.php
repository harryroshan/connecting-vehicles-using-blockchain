<html>
	<head>
		<title>Update Vote Information</title>
	</head>
	<body>
		<?php
			require_once('mysqli_connect.php');

			$query="UPDATE vote_information SET vote_status=? WHERE mac_id=? AND incident_id=?";
			$stmt=mysqli_prepare($dbc,$query);
			mysqli_stmt_bind_param($stmt,"ssi",$_GET['vote_status'],$_GET['mac_id'],$_GET['incident_id']);
			mysqli_stmt_execute($stmt);
			$affected_rows=mysqli_stmt_affected_rows($stmt);
			mysqli_stmt_close($stmt);
		?>
	</body>
</html>