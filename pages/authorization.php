<?php
	require('../admin/config.php');
	if (isset($_SESSION['id'])) {
		header('Location:' . $_site);
	} else {
		if (isset($_POST['submit_authorization'])) {
			$login_user = checker_sqli(trim(htmlspecialchars($_POST['login'])));
			$password_user = checker_sqli(trim(htmlspecialchars($_POST['password'])));
			$password_user = md5($password_user);
			$query = mysqli_query($_data, "SELECT * FROM `users` WHERE `login` = '$login_user' AND `password` = '$password_user'");
			if (mysqli_num_rows($query)) {
				$users = mysqli_fetch_assoc($query);
				$_SESSION['id'] = $users['id'];
				unset($_POST);
				header('Location:' . $_site . 'pages/home.php');
			} else {
				$error_message_a = $_language[$_lang]['error_authorization'];
				unset($_POST);
			}
		}
		if (isset($_POST['submit_registration'])) {
			$first_name = checker_sqli($_POST['first_name']);
			$last_name = checker_sqli($_POST['last_name']);
			$gender = $_POST['gender'];
			$name = $first_name . ' ' . $last_name;
			mysqli_query($_data, "UPDATE `users` SET `name` = '$name', `gender` = '$gender' WHERE `id` = '1'");
			header('Location:' . $_site . 'pages/registration.php');
		}
		if (isset($_POST['english'])) {
			mysqli_query($_data, "UPDATE `users` SET `language` = 'English' WHERE `id` = '1'");
			header('Location:' . $_site);
		}
		if (isset($_POST['russian'])) {
			mysqli_query($_data, "UPDATE `users` SET `language` = 'Russian' WHERE `id` = '1'");
			header('Location:' . $_site);
		}
	}
	require('../templates/header.php');
?>
		<section class="authorization">
			<div class="container">
				<div class="row">
					<?php /*Header */ ?>
					<div class="wrapper offset-4 col-4">
						<div class="login block">
							<form action="" class="form" method="post">
								<div class="error"><?=$error_message_a?></div>
								<input id="input" type="text" name="login" placeholder="<?=$_language[$_lang]['login_input'];?>" required >
								<input id="input" type="password" name="password" placeholder="<?=$_language[$_lang]['password_input'];?>" required >
								<input class="submit submit_authorization button-blue" type="submit" name="submit_authorization" value="<?=$_language[$_lang]['authorization_input'];?>">
							</form>
						</div>
						<div class="registration_demo block">
							<form action="" class="form" method="post">
								<div class="title-block">
									<?=$_language[$_lang]['registration_start'];?>
								</div>
								<div class="error"><?=$error_message_r?></div>
								<input id="input" type="text" name="first_name" placeholder="<?=$_language[$_lang]['first_name_input'];?>" required >
								<input id="input" type="text" name="last_name" placeholder="<?=$_language[$_lang]['last_name_input'];?>" required >
								<p><?=$_language[$_lang]['gender_select'];?></p>
								<input type="radio" name="gender" value="1" checked="">
								<label><?=$_language[$_lang]['female']?></label>
								<input type="radio" name="gender" value="0">
								<label><?=$_language[$_lang]['male']?></label>
								<input class="submit submit_registration button-green" type="submit" name="submit_registration" value="<?=$_language[$_lang]['registration_continue_input'];?>">
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