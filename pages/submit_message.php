<?php
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		if (isset($_POST['message_submit'])) {
			$id_user = $_POST['id_user'];
			$text = $_POST['text'];
			$text = checker_sqli($text);
			$type = $_POST['type'];
			$id = $_SESSION['id'];
			mysqli_query($_data, "INSERT INTO `message` (`message`, `id_send`, `id_accept`, `type`) VALUES ('$text', '$id', '$id_user', $type)");
			mysqli_query($_data, "UPDATE `users` SET `count_message` = `count_message` + 1 WHERE `id` = '$id'");
			?>
			<div class="item">
				<div class="photo">
					<a href="#" class="friend-button-view" id="<?=$_user['id']?>">
						<?php print_image($_user['photo'], $_data); ?>
					</a>
					<form action="user.php" name="form_friend" method="post" style="display:none">
						<input type="hidden" name="id_user_view" value="<?=$_user['id']?>">
						<input class="form<?=$_user['id']?>" type="submit" id="sendButton" style="display: none;" />
					</form> 
				</div>
				<div class="content">
					<span class="name">
						<a href="#" class="friend-button-view" id="<?=$_user['id']?>">
						<?=explode(' ', $_user['name'])[0] ?>
						</a>
						<span>
							now
						</span>
					</span>
					
					<span class="message">
						<?=$text?>
					</span>
				</div>
			</div>
			<?php
		} else {
			header('Location:', $_site);
		}
	}
?>