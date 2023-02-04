<?php
	require('../admin/config.php');
	if (isset($_POST['view_friend_list'])) {
		$_SESSION['view_friend_list'] = $_POST['view_friend_list'];
		unset($_POST['view_friend_list']);
		header('Location:' . $_site . 'pages/friend.php');
	}
?>