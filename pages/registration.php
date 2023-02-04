<?php
	require('../admin/config.php');
	if (isset($_SESSION['id'])) {
		header('Location:' . $_site . 'pages/home.php');
	} else {
		if (isset($_POST['submit_registration'])) {
			$host_sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '1'");
			$host_sql = mysqli_fetch_assoc($host_sql);
			$gender = $host_sql['gender'];
			$name = $host_sql['name'];
			$login = checker_sqli($_POST['login']);
			$password = checker_sqli($_POST['password']);
			$birthday = $_POST['birthday'];
			$city = checker_sqli($_POST['city']);
			$language = $_POST['language'];
			$default_photo = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '1'");
			$default_photo = mysqli_fetch_assoc($default_photo);
			$default_photo = $default_photo['photo'];
			$sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `login` = '$login'");
			if (mysqli_num_rows($sql) > 0) {
				$error_message_r = $_language[$_lang]['error_registration'];
			} else {
				if (strlen($password) < 6) {
					$error_message_r = $_language[$_lang]['error_registration_empty'];
				} else {
					$password = md5($password);
					$sql = "INSERT INTO `users` (`login`, `password`, `name`, `birthday`, `city`, `count_friend`, `id_friend`, `count_message`, `id_user_message`, `language`, `gender`) VALUES ('$login', '$password', '$name', '$birthday', '$city', '0', '0,', '0', '0,', '$language', '$gender')";
					mysqli_query($_data, $sql);
					$new_sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `login` = '$login'");
					$id = mysqli_fetch_assoc($new_sql);
					$id = $id['id'];
					$_SESSION['id'] = $id; 
					set_log($_data, $id, 'registration');
					header('Location:' . $_site);
				}
			}
		}
		if (isset($_POST['english'])) {
			mysqli_query($_data, "UPDATE `users` SET `language` = 'English' WHERE `id` = '1'");
			header('Location:' . $_site . 'pages/registration.php');
		}
		if (isset($_POST['russian'])) {
			mysqli_query($_data, "UPDATE `users` SET `language` = 'Russian' WHERE `id` = '1'");
			header('Location:' . $_site . 'pages/registration.php');
		}
	}
	require('../templates/header.php');
?>
		<section class="registration">
			<div class="container">
				<div class="row">
					<?php /*Header */ ?>
					<div class="wrapper offset-4 col-4">
						<div class="registration block">
							<form action="" class="form" method="post">
								<div class="title-block">
									<h3><?=$_language[$_lang]['registration_continue']?><h3>
								</div>
								<div class="error"><?=$error_message_r?></div>
								<input type="text" name="login" placeholder="<?=$_language[$_lang]['login_input'];?>" required >
								<input type="password" name="password" placeholder="<?=$_language[$_lang]['password_input'];?>" required >
								<label><?=$_language[$_lang]['birthday_input']?></label><br>
								<input type="date" name="birthday" class="date_input">
								<input type="text" name="city" placeholder="<?=$_language[$_lang]['city_input'];?>">
								<label><?=$_language[$_lang]['language_input'];?></label>
								<select name="language">
									<option value="English">English</option>
									<option value="Russian">Русский</option>
								</select>
								<input class="submit submit_authorization button-blue" type="submit" name="submit_registration" value="<?=$_language[$_lang]['registration_title'];?>">
							</form>
						</div>
						<div class="language">
							<form action="" method="post">
								<input type="submit" name="english" value="English">
							</form>
							<form action="" method="post">
								<input type="submit" name="russian" value="Русский">
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<script type="text/javascript" src="../js/main.js"></script>
	</body>
</html>