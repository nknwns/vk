<?php 
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		if (isset($_POST['message_user'])) {
			$id_user = $_POST['id_user'];
			$_SESSION['message_id'] = $id_user;
			$sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id_user'");
			$sql = mysqli_fetch_assoc($sql);
			$message_list = $_user['id_user_message'];
			$id_user = "," . $id_user . ",";
			if (strpos($message_list, $id_user)) {
				header('Location:' . $_site . 'pages/message_user.php');
			} else {
				$id_user = $sql['id'];
				$id = $_SESSION['id'];
				$message_list = $message_list . $id_user . ",";
				mysqli_query($_data, "UPDATE `users` SET `id_user_message` = '$message_list' WHERE `id` = '$id'");
				$message_list = $sql['id_user_message'];
				$message_list = $message_list . $id . ",";
				mysqli_query($_data, "UPDATE `users` SET `id_user_message` = '$message_list' WHERE `id` = '$id_user'");
				header('Location:' . $_site . 'pages/message_user.php');
			}
		}
	}
?>