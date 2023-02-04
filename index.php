<?php
	require( 'admin/config.php' );
	if (isset($_SESSION['id'])) {
		header( 'Location:' . $_site . 'pages/home.php' );
	} else {
		header( 'Location:' . $_site . 'pages/authorization.php' );
	}
?>