<?php
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		if (isset($_POST['message_user']) or isset($_SESSION['message_id'])) {
			$id = $_POST['id_message_user'];
			if (!isset($id)) {
				$id = $_SESSION['message_id'];
			}
			$user = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id'");
			$user = mysqli_fetch_assoc($user);
		} else {
			header('Location:', $_site);
		}
		$_this = $_language[$_lang_user]['messenger_menu']; 
		require('../templates/header_user.php');
		?>
<section class="message">
	<div class="container">
		<div class="row">
			<?php require('../templates/left-menu.php'); ?>
			<div class="right-message col-lg-6">
				<div class="block">
					<div class="title">
						<div class="back">
							<a href="messenger.php">
								<img src="../img/back.svg">
								<?=$_language[$_lang_user]['back']?>
							</a>
						</div>
						<div class="name">
							<a href="#"  id="<?=$user['id']?>" class="friend-button-view">
								<?=$user['name']?>
							</a>
							<form action="user.php" name="form_friend" method="post" style="display:none">
								<input type="hidden" name="id_user_view" value="<?=$user['id']?>">
								<input class="form<?=$user['id']?>" type="submit" id="sendButton" style="display: none;" />
							</form>
						</div>
						<div class="setting-message">
							<a href="#">
								<img src="../img/setting.svg">
							</a>
							<a href="#"  id="<?=$user['id']?>" class="friend-button-view">
								<?php print_image($user['photo'], $_data, 'small-preview'); ?>
							</a>
						</div>
					</div>
					<hr>
					<div class="grid" id="grid">
						<?php
						$id_friend = $user['id'];
						$id = $_SESSION['id'];
						$sql = mysqli_query($_data, "SELECT * FROM `message` WHERE (`id_accept` = '$id' AND `id_send` = '$id_friend') OR (`id_accept` = '$id_friend' AND `id_send` = '$id') AND `type` = '0'");
						while($object = mysqli_fetch_assoc($sql)) {
							$id_send = $object['id_send'];
							$id_accept = $object['id_accept'];
							$send_info = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id_send'");
							$send_info = mysqli_fetch_assoc($send_info);
							if (!isset($prev)) {
								$prev = substr($object['date'], 8, 2);
							}
							if ($prev != substr($object['date'], 8, 2)) {
								echo '<span class="new-date">' . substr($object['date'], 5, 5) . "</span>";
								$prev = substr($object['date'], 8, 2);
							}
							?>
							<div class="item">
								<div class="photo">
									<a href="#" class="friend-button-view" id="<?=$send_info['id']?>">
										<?php print_image($send_info['photo'], $_data); ?>
									</a>
									<form action="user.php" name="form_friend" method="post" style="display:none">
										<input type="hidden" name="id_user_view" value="<?=$send_info['id']?>">
										<input class="form<?=$send_info['id']?>" type="submit" id="sendButton" style="display: none;" />
									</form> 
								</div>
								<div class="content">
									<span class="name">
										<a href="#" class="friend-button-view" id="<?=$send_info['id']?>">
										<?=explode(' ', $send_info['name'])[0] ?>
										</a>
										<span>
											<?=substr($object['date'], 11, 5);?>
										</span>
									</span>
									
									<span class="message">
										<?=$object['message']?>
									</span>
								</div>
							</div>
							<?php
						}
						?>
						<div class="temp-object"></div>
					</div>
					<div class="message-input">
						<form>
							<a href="#" class="other-function"></a>
							<input type="text" name="message-input" placeholder="<?=$_language[$_lang_user]['new_message']?>" id="<?=$user['id']?>">
							<input type="button" class="name-message" name="message-button" value="">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var grid = document.getElementById("grid");
	grid.scrollTop = grid.scrollHeight;
</script>
	<?php
		require('../templates/footer.php');
	}
?>