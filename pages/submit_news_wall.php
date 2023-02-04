<?php 
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		if (isset($_POST['submit_news_wall'])) {
			$id_send = $_SESSION['id'];
			$id_accept = $_POST['message-wall-user-id'];
			$message = checker_sqli($_POST['message-wall-user']);
			mysqli_query($_data, "INSERT INTO `news-wall` (`type`, `id_send`, `id_accept`, `text`, `id_user_liked`) VALUES ('message', '$id_send', '$id_accept', '$message', '0,')");
			unset($_POST);
			$_SESSION['id_view'] = $id_accept;
			header('Location:' . $site . 'user.php');
		}
	}
?>