<?php
	require('../admin/config.php');
	if (!isset($_SESSION['id'])) {
		header('Location:' . $_site);
	}
	if (isset($_POST['submit_edit'])) {
		$name = checker_sqli($_POST['first_name_input']) . " " . checker_sqli($_POST['last_name_input']);
		$gender = $_POST['gender'];
		$birthday = $_POST['birthday'];
		$city = checker_sqli($_POST['city']);
		$id = $_SESSION['id'];
		if ($name != $_user['name']) {
			$old_name = $_user['name'];
			set_log($_data, $id, 'new_name', "Change username. Old: $old_name. New: $name");
		}
		mysqli_query($_data, "UPDATE `users` SET `name` = '$name', `gender` = '$gender', `birthday` = '$birthday', `city` = '$city' WHERE `id` = '$id'");
		unset($_POST);
		header('Location:' . $site . 'edit_account.php');
	}

	$_this = $_language[$_lang_user]['edit-profle'];
	require('../templates/header_user.php');
?>
<section class="edit">
	<div class="container">
		<div class="row">
			<?php require('../templates/left-menu.php'); ?>
			<div class="basic-info col-5">
				<div class="block">
					<div class="title-top">
						<span>
							<?=$_language[$_lang_user]['basic-info']?>
						</span>
					</div>
					<div class="description">
						<form action="" method="post">
							<span>
								<label><?=$_language[$_lang_user]['first_name_input']?>:</label>
								<input required type="text" name="first_name_input" placeholder="<?=explode(' ', $_user['name'])[0]?>" value="<?=explode(' ', $_user['name'])[0]?>">
							</span>
							<span>
								<label><?=$_language[$_lang_user]['last_name_input']?>:</label>
								<input required type="text" name="last_name_input" placeholder="<?=explode(' ', $_user['name'])[1]?>" value="<?=explode(' ', $_user['name'])[1]?>">
							</span>
							<span>
								<label><?=$_language[$_lang_user]['gender_select']?>:</label>
								<select name="gender" value="<?=$_user['gender']?>">
									<option value="0"><?=$_language[$_lang_user]['male']?></option>
									<option value="1"><?=$_language[$_lang_user]['female']?></option>
									<option value="2"><?=$_language[$_lang_user]['helicopter']?></option>
								</select>
							</span>
							<span>
								<label>
									<?=$_language[$_lang_user]['birthday_input']?>:
								</label>
								<input type="date" name="birthday" class="date_input" value="<?=substr($_user['birthday'], 0, 10)?>">
							</span>
							<span>
								<label>
									<?=$_language[$_lang_user]['city_input']?>:
								</label>
								<input required type="text" name="city" placeholder="<?=$_user['city']?>" value="<?=$_user['city']?>">
							</span>
							<hr>
							<span>
								<input type="submit" name="submit_edit" value="<?=$_language[$_lang_user]['edit_profile_submit']?>" class="button-blue">
							</span>
						</form>
					</div>
				</div>
			</div>
			<div class="config-edit col-3">
				<div class="block">
					<div class="title">
						<span class="photo">
							<a href="account.php">
								<?php print_image($_user['photo'], $_data) ?>
							</a>
						</span>
						<span class="name">
							<a href="account.php">
								<?=$_user['name']?>
							</a>
						</span>
					</div>
					<hr>
					<div class="grid">
						<div class="item active">
							<?=$_language[$_lang_user]['basic-info']?>
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