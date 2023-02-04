<?php 
	require('../admin/config.php');
	unset($_SESSION['id']);
	header('Location:' . $_site);
?>