<html>
	<head>
		<title>Logout Handler</title>
	</head>
	<body>
		<?php
			session_start();
			session_destroy();

			setcookie("user_info", "", time() - 3600);

			header("location: index.php");
		?>
	</body>
</html>