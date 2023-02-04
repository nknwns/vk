<?php
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	}
	if (isset($_POST['submit_edit'])) {
		$new_password = $_POST['new_password_input'];
		$old_password = $_POST['old_password_input'];
		$id = $_SESSION['id'];
		$error_message = "";
		if ($new_password == '') {
			$new_language = $_POST['language'];
			mysqli_query($_data, "UPDATE `users` SET `language` = '$new_language' WHERE `id` = '$id'");
			header('Location:' . $site . 'setting.php');
		} else {
			if (md5($old_password) == $_user['password']) {
				set_log($_data, $id, 'new_password', 'Change password. New password: ' . $new_password);
				$new_password = md5($new_password);
				mysqli_query($_data, "UPDATE `users` SET `password` = '$new_password' WHERE `id` = '$id'");
				header('Location:' . $site . 'setting.php');
			} else {
				$error_message = $_language[$_lang_user]['error_new_password'];
			}
		}
		unset($_POST);
	}

	$_this = $_language[$_lang_user]['edit-profle'];
	require('../templates/header_user.php');
?>
<section class="edit setting">
	<div class="container">
		<div class="row">
			<?php require('../templates/left-menu.php'); ?>
			<div class="basic-info col-5">
				<div class="block">
					<div class="title-top">
						<span>
							<?=$_language[$_lang_user]['setting-general']?>
						</span>
					</div>
					<div class="description">
						<form action="" method="post">
							<span>
								<label><?=$_language[$_lang_user]['new_password']?></label>
								<input type="text" name="new_password_input" placeholder="<?=$_language[$_lang_user]['password_input']?>">
							</span>
							<span>
								<label><?=$_language[$_lang_user]['old_password']?></label>
								<input type="text" name="old_password_input" placeholder="<?=$_language[$_lang_user]['password_input']?>">
							</span>
							<p class="error error-small"><?=$error_message?></p>
							<hr>
							<span>
								<label><?=$_language[$_lang_user]['language_input']?></label>
								<select name="language" value="<?=$_user['language']?>">
									<option value="English">English</option>
									<option value="Russian">Русский</option>
								</select>
							</span>
							<hr>
							<span>
								<input type="submit" name="submit_edit" value="<?=$_language[$_lang_user]['edit_profile_submit']?>" class="button-blue">
							</span>
						</form>
					</div>
					<div class="title-bottom">
						<a href="#"><?=$_language[$_lang_user]['delete_user']?></a>
					</div>
				</div>
			</div>
			<div class="config-edit col-3">
				<div class="block">
					<div class="grid">
						<div class="item active">
							<?=$_language[$_lang_user]['setting-general']?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php 
	require('../templates/footer.php');
?>