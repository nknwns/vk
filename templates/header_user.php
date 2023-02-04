<?php 

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title><?=$_this?></title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
 	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script type="text/javascript" src="../js/jquery-3.5.1.min.js"></script>
</head>
	<body>
		<header class="header">
			<div class="container">
				<div class="row">
					<div class="menu offset-1 col-10">
						<ul>
							<li class="profile-btn">
								<span><?=explode(' ', $_user['name'])[0]?></span>
								<?php print_image($_user['photo'], $_data, 'small-preview') ?>
								<ul class="profile-list block">
									<li>
										<a href="account.php">
											<?php print_image($_user['photo'], $_data) ?>
										<span><?=$_user['name']?></span>
										</a>
									</li>
									<hr>
									<li>
										<a href="setting.php">
											<?=$_language[$_lang_user]['setting_title']?>
										</a>
									</li>
									<hr>
									<li>
										<a href="exit.php">
											<?=$_language[$_lang_user]['logout_title']?>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</header>