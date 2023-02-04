<?php 
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		$user_id = $_SESSION['view_friend_list'];
		$user = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$user_id'");
		$user = mysqli_fetch_assoc($user);
		$_this = ucfirst($_language[$_lang_user]['friend-profile']) . " - " . $user['count_friend'] . " " .$_language[$_lang_user]['friend-profile']; 
		require('../templates/header_user.php');
		?>
<section class="friend">
	<div class="container">
		<div class="row">
			<?php require('../templates/left-menu.php'); ?>
			<div class="friend-list block col-6">
				<div class="title-grey-top title">
					<span class="title-element"><?=$_language[$_lang_user]['all_friend']?><span><?=$user['count_friend'];?></span></span>
					<form action="find_friend.php" method="post">
						<input type="submit" name="find_friend_submit" value="<?=$_language[$_lang_user]['find_friend']?>" class="button-blue">
					</form>
				</div>
				<div class="grid-friend">
		<?php
		$friend_user = "(" . substr($user['id_friend'], 2, strlen($user['id_friend']) - 3) . ")";
		$lst_friend = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` IN $friend_user");
		if ($user['count_friend'] > 0) {
			while ($friend = mysqli_fetch_assoc($lst_friend)) {
			?>
				<div class="item">
					<div class="photo">
						<a href="#" class="friend-button-view" id="<?=$friend['id']?>">
							<?php print_image($friend['photo'], $_data, 'big-preview'); ?>
						</a>
					</div>
					<div class="description">
						<p class="name"><a href="#" class="friend-button-view" id="<?=$friend['id']?>"><?=$friend['name']?></a></p>
						<p></p>
						<p class="city"><?=$friend['city']?></p>
						<p class="write"><a href="#" class="message-user" id="<?=$friend['id']?>"><?=$_language[$_lang_user]['write_message']?></a></p>
						<form action="new_message.php" method="post">
							<input class="input-support" id="message-<?=$friend['id']?>" type="submit" name="message_user" value="<?=$_language[$_lang_user]['write_message']?>">
							<input type="text" name="id_user" class="input-support" value="<?=$friend['id']?>" id="<?=$friend['id']?>">
						</form>
					</div>
				</div>
				<form action="user.php" name="form_friend" method="post" style="display:none">
					<input type="hidden" name="id_user_view" value="<?=$friend['id']?>">
					<input class="form<?=$friend['id']?>" type="submit" id="sendButton" style="display: none;" />
				</form> 
				<hr>
				<?php
			}
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