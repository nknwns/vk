<?php 
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		if (isset($_POST['find_friend_submit'])) {
			$search = $_POST['name_friend'];
			if ($search == '') {
				$id = $_SESSION['id'];
				$sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id'");
			} else {
				$sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `name` LIKE '%$search%' AND `id` <> '1'");
			}
		}

		$_this = $_language[$_lang_user]['find_friend']; 
		require('../templates/header_user.php');
		?>
<section class="friend find">
	<div class="container">
		<div class="row">
			<?php require('../templates/left-menu.php'); ?>
			<div class="friend-list block col-6">
				<div class="title-grey-top title">
					<span class="title-element"><?=$_language[$_lang_user]['find_friend']?></span>
					<form action="" method="post">
						<input type="text" name="name_friend" placeholder="<?=$_language[$_lang_user]['news_wall_input_user']?>">
						<input type="submit" name="find_friend_submit" value="<?=$_language[$_lang_user]['find_friend']?>" class="button-blue">
					</form>
				</div>
				<div class="grid-friend">
		<?php
		while ($user_search = mysqli_fetch_assoc($sql)) {
			?>
			<div class="item">
				<div class="photo">
					<a href="#" class="friend-button-view" id="<?=$user_search['id']?>">
						<?php print_image($user_search['photo'], $_data, 'big-preview'); ?>
					</a>
				</div>
				<div class="description">
					<p class="name"><a href="#" class="friend-button-view" id="<?=$user_search['id']?>"><?=$user_search['name']?></a></p>
					<p></p>
					<p class="city"><?=$user_search['city']?></p>
					<?php 
						if ($_SESSION['id'] != $user_search['id']) {
							?>
							<p class="write"><a href="#" class="message-user" id="<?=$user_search['id']?>"><?=$_language[$_lang_user]['write_message']?></a></p>
							<form action="new_message.php" method="post">
								<input class="input-support" id="message-<?=$user_search['id']?>" type="submit" name="message_user" value="<?=$_language[$_lang_user]['write_message']?>">
								<input type="text" name="id_user" class="input-support" value="<?=$user_search['id']?>" id="<?=$user_search['id']?>">
							</form>
							<?php
						}
					?>
				</div>
			</div>
			<form action="user.php" name="form_friend" method="post" style="display:none">
				<input type="hidden" name="id_user_view" value="<?=$user_search['id']?>">
				<input class="form<?=$user_search['id']?>" type="submit" id="sendButton" style="display: none;" />
			</form> 
			<hr>
			<?php
		}
		?>
			</div>
			</div>
		</div>
	</div>
</section>
		<?php
		require('../templates/footer.php');
	}
?>