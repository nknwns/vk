<?php 
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		$id = $_POST['id_user_view'];
		if (isset($id)) {
			$_SESSION['id_view'] = $id;
		}
		if (!isset($_POST['id_user_view'])) {
			$id = $_SESSION['id_view'];
		}
		if ($id == $_SESSION['id']) {
			header('Location:' . $site . 'account.php');
		}
		$name_type_friend = 'is_friend';
		if (!is_friend($id, $_SESSION['id'], $_data)) {
			$type_friend = 'button-blue';
			$name_type_friend = 'add_friend';
		}
		$user = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id'");
		$user = mysqli_fetch_assoc($user);
		if (isset($_POST['like_submit'])) {
			$item_id = $_POST['like_input'];
			$user_id = $_SESSION['id'];
			$sql = mysqli_query($_data, "SELECT * FROM `news-wall` WHERE `id` = '$item_id'");
			$sql = mysqli_fetch_assoc($sql);
			$_SESSION['id_view'] = $sql['id_accept'];
			$id_liked = $sql['id_user_liked'];
			$user_id = "," . $user_id . ",";
			if (strpos($id_liked, $user_id)) {
				$id_liked = edit_liked($id_liked, $user_id, 0);
				mysqli_query($_data, "UPDATE `news-wall` SET `id_user_liked` = '$id_liked', `count_like` = `count_like` - 1 WHERE `id` = '$item_id'");
			} else {
				$id_liked = edit_liked($id_liked, $user_id, 1);
				mysqli_query($_data, "UPDATE `news-wall` SET `id_user_liked` = '$id_liked', `count_like` = `count_like` + 1 WHERE `id` = '$item_id'");
			}
		}
		if (isset($_POST['add_friend_user'])) {
			edit_friend($_SESSION['id'], $user['id'], $_data, 1, 'user.php');
			echo "hm";
		}
		if (isset($_POST['is_friend_user'])) {
			edit_friend($_SESSION['id'], $user['id'], $_data, 0, 'user.php');
		}
		$_this = $user['name'];
		require('../templates/header_user.php');
	}
?>
<section class="account">
	<div class="container">
		<div class="row">
			<?php require('../templates/left-menu.php'); ?>
			<div class="left-account-info col-3">
				<div class="avatar block">
					<a href="#">
						<?php print_image($user['photo'], $_data); ?>
					</a>
					<form action="new_message.php" method="post">
						<input class="button-blue" type="submit" name="message_user" value="<?=$_language[$_lang_user]['write_message']?>">
						<input type="text" name="id_user" class="input-support" value="<?=$user['id']?>">
					</form>
					<form action="" method="post">
						<input class="<?=$type_friend?>" type="submit" name="<?=$name_type_friend?>_user" value="<?=$_language[$_lang_user][$name_type_friend]?>">
					</form>
				</div>
				<?php print_friend($user['id'], $_data, $_language, $_lang_user) ?>
			</div>
			<div class="right-account-info col-5">
				<div class="description-user block">
					<div class="name-user">
						<p><?=$user['name'];?></p>
						<span><?=$user['status']?></span>
					</div>
					<hr>
					<div class="info-user">
						<p><span><?=$_language[$_lang_user]['birthday_input']?>:</span><?=$user['birthday']?></p>
						<p><span><?=$_language[$_lang_user]['city_input']?>:</span><?=$user['city']?></p>
						<p><span><?=$_language[$_lang_user]['gender']?>:</span><?=why_gender($user['gender'], $_lang_user);?></p>
						<p><span><?=$_language[$_lang_user]['language_input']?>:</span><?=$user['language']?></p>
					</div>
					<hr>
					<?php
					if ($user['count_friend'] != '0') {
						?>
						<div class="other-info-user">
							<a href="#" class="view-friend-list-button"><?=$user['count_friend']?><span><?=$_language[$_lang_user]['friend-profile']?></span></a>
						</div>
						<?php
					}
					?>
				</div>
				<div class="news-wall-message block">
					<div class="photo">
						<a href="#">
							<?php print_image($_user['photo'], $_data); ?>
						</a>
					</div>
					<div class="message-input">
						<form action="submit_news_wall.php" method="post">
							<input type="text" name="message-wall-user" class="message-wall-user" placeholder="<?=$_language[$_lang_user]['news_wall_input_user']?>" required>
							<input type="text" name="message-wall-user-id" value="<?=$user['id']?>" style="display: none">
							<input class="button-blue" type="submit" name="submit_news_wall" value="<?=$_language[$_lang_user]['news_wall_submit']?>">
						</form>
					</div>
				</div>
				<div class="grid">
					<?php
						$id_accept = $user['id'];
						$sql = mysqli_query($_data, "SELECT * FROM `news-wall` WHERE `id_accept` = '$id_accept' ORDER BY `id` DESC");
						$num = 0;
						while ($item = mysqli_fetch_assoc($sql)) {
							if ($num == 0) {
								get_newsWall($item, $_data, $_language, $_lang_user, 1);
								$num++;
							} else {
								get_newsWall($item, $_data, $_language, $_lang_user, 0);
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
?>