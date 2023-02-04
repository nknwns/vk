<?php 
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		if (isset($_POST['delete_news_wall'])) {
			$id_object = $_POST['id_item'];
			mysqli_query($_data, "DELETE FROM `news-wall` WHERE `id` = '$id_object'");
			header('Location:' . $_site . 'pages/account.php');
		} else {
			header('Location:' . $_site);
		}
	}
?>