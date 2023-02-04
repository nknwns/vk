<?php 
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		$id = $_user['id'];
		$message_list = $_user['id_user_message'];
		$message_list = substr($message_list, 2, strlen($message_list) - 3);
		$message_list = "(" . $message_list . ")";
		$user_list = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` IN " . $message_list . "ORDER BY `date` DESC");
		if (isset($_POST['find_message_user'])) {
			$search = $_POST['name_message_user'];
			$search = '%' . $search . '%';
			$user_list = mysqli_query($_data, "SELECT * FROM `users` WHERE `name` LIKE '$search' AND `id` IN " . $message_list);
		}

		$_this = $_language[$_lang_user]['messenger_menu']; 
		require('../templates/header_user.php');
		?>
<section class="messenger">
	<div class="container">
		<div class="row">
			<?php require('../templates/left-menu.php') ?>
			<div class="right-messenger col-lg-6">
				<div class="block">
					<div class="title">
						<form action="" method="post">
							<input type="submit" name="find_message_user" value="">
							<input type="text" name="name_message_user" placeholder="<?=$_language[$_lang_user]['search']?>">
						</form>
					</div>
					<hr>
					<div class="grid">
						<?php
						if ($user_list) {
							while ($object = mysqli_fetch_assoc($user_list)) {
							$id_user = $object['id'];
							$last_message = mysqli_query($_data, "SELECT * FROM `message` WHERE (`id_send` = '$id' AND `id_accept` = '$id_user') OR (`id_send` = '$id_user' AND `id_accept` = '$id') ORDER BY `id` DESC");
							$last_message = mysqli_fetch_assoc($last_message);
							$id_send = $last_message['id_send'];
							$user = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id_send'");
							?>
							<div class="item">
								<a href="#" class="message-user" id="message-user-<?=$object['id']?>">
									<div class="photo">
										<?php print_image($object['photo'], $_data, 'medium-preview'); ?>
									</div>
									<div class="description">
										<span class="name-date"><span><?=$object['name']?></span><span><?=substr($last_message['date'], 5, 5)?></span></span>
										<span class="last-message">
											<?php
												if ($id_send == $_user['id']) {
													print_image($_user['photo'], $_data, 'small-preview');
												}
											?>
											<?=$last_message['message']?></span>
									</div>
								</a>
								<form action="message_user.php" method="post">
									<input type="submit" class="input-support" name="message_user" id="message-user-<?=$object['id']?>">
									<input type="test" class="input-support" name="id_message_user" value="<?=$object['id']?>">
								</form>
							</div>
							<hr>
							<?php
						}
						}
						?>
					</div>
				</div>
			</div>
			<div class="user-list col-lg-2">
				<div class="block"></div>
			</div>
		</div>
	</div>
</section>
		<?php
		require('../templates/footer.php');
	}
?>