<?php
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		if (isset($_POST['submit_upload_photo'])) {
			$image = addslashes(file_get_contents($_FILES['file']['tmp_name']));
			$id = $_user['id'];
			mysqli_query($_data, "UPDATE `users` SET `photo` = '$image' WHERE `users`.`id` = '$id'");
			mysqli_query($_data, "INSERT INTO `news-wall` (`type`, `id_send`, `id_accept`, `photo`, `id_user_liked`) VALUES ('photo', '$id', '$id', '$image', '0,')");
			unset($_POST);
			header('Location:' . $site . 'account.php');
		}
		
		if (isset($_POST['like_post'])) {
			$id_post = $_POST['item_id'];
			$id_user = $_SESSION['id'];
			$sql = mysqli_query($_data, "SELECT * FROM `news-wall` WHERE `id` = '$id_post'");
			$sql = mysqli_fetch_assoc($sql);
			$list_liked = $sql['id_user_liked'];
			$id_user = "," . $id_user . ",";
			if (strpos($list_liked, $id_user)) {
				$list_liked = edit_liked($list_liked, $id_user, 0);
				mysqli_query($_data, "UPDATE `news-wall` SET `id_user_liked` = '$list_liked', `count_like` = `count_like` - 1 WHERE `id` = '$id_post'");
			} else {
				$list_liked = edit_liked($list_liked, $id_user, 1);
				mysqli_query($_data, "UPDATE `news-wall` SET `id_user_liked` = '$list_liked', `count_like` = `count_like` + 1 WHERE `id` = '$id_post'");
			}
		}

		if (isset($_POST['save_status'])) {
			$new_status = checker_sqli($_POST['new_status']);
			$id = $_SESSION['id'];
			mysqli_query($_data, "UPDATE `users` SET `status` = '$new_status' WHERE `id` = '$id'");
			header('Location:' . $_site . 'pages/account.php');
		}

		$_this = $_user['name'];
		require('../templates/header_user.php');
	}
?>
<div class="black-window"></div>
<div class="container">
	<div class="row">
		<div class="edit-photo-block animate__animated block">
				<div class="title title-top">
					<?=$_language[$_lang_user]['upload_photo_title']?>
					<a href="#" class="close-upload-photo"><img src="../img/cross_popup.png"></a>
				</div>
				<div class="description">
					<?=$_language[$_lang_user]['upload_photo_description']?>
					<br>
					<form class="upload-photo" action="" method="post" enctype="multipart/form-data">
						<input type="file" name="file" class="upload-photo">
						<input class="button-blue" type="submit" name="submit_upload_photo" value="<?=$_language[$_lang_user]['select_photo']?>">
					</form>
				</div>
				<div class="title title-bottom">
					<?=$_language[$_lang_user]['problem_upload_photo']?>
				</div>
			</div>
	</div>
</div>
<section class="account">
	<div class="container">
		<div class="row">
			<?php require('../templates/left-menu.php'); ?>
			<form class="status-user-edit block offset-4 col-5" action="" method="post" class="animate__animated">
				<input type="text" name="new_status" value="<?=$_user['status']?>">
				<input type="submit" class="button-blue" name="save_status" value="<?=$_language[$_lang_user]['edit_profile_submit']?>">
			</form>
			<div class="left-account-info col-3">
				<div class="avatar block">
					<a href="#" class="edit-photo">
						<?php print_image($_user['photo'],$_data); ?>
					</a>
					<a href="edit_account.php" class="button-edit"><?=$_language[$_lang_user]['edit_menu']?></a>
				</div>
				<?php print_friend($_SESSION['id'], $_data, $_language, $_lang_user) ?>
			</div>
			<div class="right-account-info col-5">
				<div class="description-user block">
					<div class="name-user">
						<p><?=$_user['name'];?></p>
						<span class="status-user"><?=$_user['status']?></span>
					</div>
					<hr>
					<div class="info-user">
						<p><span><?=$_language[$_lang_user]['birthday_input']?>:</span><?=$_user['birthday']?></p>
						<p><span><?=$_language[$_lang_user]['city_input']?>:</span><?=$_user['city']?></p>
						<p><span><?=$_language[$_lang_user]['gender']?>:</span><?=why_gender($_user['gender'], $_lang_user);?></p>
						<p><span><?=$_language[$_lang_user]['language_input']?>:</span><?=$_user['language']?></p>
					</div>
					<hr>
					<?php 
					if ($_user['count_friend'] != '0') {
						?>
						<div class="other-info-user">
							<a href="#" class="view-friend-list-button"><?=$_user['count_friend']?><span><?=$_language[$_lang_user]['friend-profile']?></span></a>
						</div>
						<?php
					}	
					?>
				</div>
				<div class="news-wall-message block">
						<div class="photo">
							<a href="account.php">
								<?php print_image($_user['photo'], $_data); ?>
							</a>
						</div>
						<div class="message-input">
							<form action="submit_news_wall.php" method="post">
								<input type="text" name="message-wall-user" class="message-wall-user" placeholder="<?=$_language[$_lang_user]['news_wall_input']?>" required>
								<input type="text" name="message-wall-user-id" value="<?=$_SESSION['id']?>" style="display: none">
								<input class="button-blue" type="submit" name="submit_news_wall" value="<?=$_language[$_lang_user]['news_wall_submit']?>">
							</form>
						</div>
				</div>
				<div class="grid">
					<?php
						$id_accept = $_SESSION['id'];
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