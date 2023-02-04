<?php 
	session_start();
	$_data = mysqli_connect('127.0.0.1', 'root', 'root', 'vk');
	$_site = 'http://vk.localhost/';
	$_title = 'VK';
	if (!isset($_SESSION['id_view'])) {
		$_SESSION['id_view'] = '1';
	}
	if (isset($_SESSION['id'])) {
		$_id_user = $_SESSION['id'];
		$_user_sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$_id_user'");
		$_user = mysqli_fetch_assoc($_user_sql);
		$_lang_user = $_user['language'];
	} else {
		$sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '1'");
		$_lang = mysqli_fetch_assoc($sql)['language'];
		unset($sql);
	}

	function checker_sqli($value) {
		$result = '';
		for ($char = 0; $char < strlen($value); $char++) {
			if ($value[$char] != "'") {
				$result = $result . $value[$char];
			}
		}
		return $result;
	}

	function print_image($value, $_data, $size = null) {
		if (strlen($value) < 4) {
			$photo = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '1'");
			$photo = mysqli_fetch_assoc($photo);
			$photo = $photo['photo'];
			$image = new Imagick();
			$image->readimageblob($photo);
			if ($size == 'small-preview') {
				$image = '<img class="small-preview" src="data:image/png;base64,' . base64_encode($image->getimageblob()) . '"/>';
			} elseif ($size == 'medium-preview') {
				$image = '<img class="medium-preview" src="data:image/png;base64,' . base64_encode($image->getimageblob()) . '"/>';
			} elseif ($size == 'big-preview') {
				$image = '<img class="big-preview" src="data:image/png;base64,' . base64_encode($image->getimageblob()) . '"/>';
			} else {
				$image = '<img src="data:image/png;base64,' . base64_encode($image->getimageblob()) . '"/>';
			}
		} else {
			$image = new Imagick();
			$image->readimageblob($value);
			if ($size == 'small-preview') {
				$image = '<img class="small-preview" src="data:image/png;base64,' . base64_encode($image->getimageblob()) . '"/>';
			} elseif ($size == 'medium-preview') {
				$image = '<img class="medium-preview" src="data:image/png;base64,' . base64_encode($image->getimageblob()) . '"/>';
			} elseif ($size == 'big-preview') {
				$image = '<img class="big-preview" src="data:image/png;base64,' . base64_encode($image->getimageblob()) . '"/>';
			} else {
				$image = '<img src="data:image/png;base64,' . base64_encode($image->getimageblob()) . '"/>';
			}
		}
		echo $image;
	}

	function print_friend($id, $_data, $_language, $_lang_user) {
		$user_sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id'");
		$user = mysqli_fetch_assoc($user_sql);
		if ($user['count_friend'] != '0') {
			require('../templates/friends_grid.php');
		}
	}

	function why_gender($gender, $_lang_user) {
		switch ($gender) {
			case '1':
				if ($_lang_user == 'Russian') return "Женский";
				if ($_lang_user == 'English') return 'Female';
				break;
			case '0':
				if ($_lang_user == 'Russian') return "Мужской";
				if ($_lang_user == 'English') return "Male";
				break;
			default:
				if ($_lang_user == 'Russian') return "Боевой вертолет";
				if ($_lang_user == 'English') return "Attack helicopter";
				break;
		}
	}

	function get_newsWall($item, $_data, $_language, $_lang_user, $first) {
		$id_send = $item['id_send'];
		$sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id_send'");
		$sql = mysqli_fetch_assoc($sql);
		$photo = $sql['photo'];
		if ($item['type'] == 'photo') {
			$news_start = $_language[$_lang_user]['update_photo'];
		}
		$id_user = "," . $_SESSION['id'] . ",";
		$id_user_liked = $item['id_user_liked'];
		$src_img = "";
		$class_img = "";
		$id_accept = $item['id_accept'];
		if (strpos($id_user_liked, $id_user)) {
			$src_img = "../img/like_active.svg";
			$class_img = "liked";
		} else {
			$src_img = "../img/like.svg";
		}
		if ($first == 1) {
			?>
			<div class="item block" style="padding: 0;">
				<div class="title">
					<span><?=$_language[$_lang_user]['news_wall_title']?></span>
				</div>
				<hr>
				<div class="object" style="padding: 15px;">
					<div class="title-item">
						<span>
							<a href="#" class="friend-button-view" id="<?=$sql['id']?>">
								<?php print_image($photo, $_data, 'medium-preview'); ?>
							</a>
						</span>
						<span>
							<p class="author"><a href="#" class="friend-button-view" id="<?=$sql['id']?>"><?=$sql['name']?></a><?=$news_start?></p>
							<p class="date"><?=substr($item['date'], 0, 10)?></p>
						</span>
						<?php
						if ($id_accept == $_SESSION['id']) {
							?>
							<a href="#" class="delete-news-wall" id="delete-news-wall-<?=$item['id']?>" ><img src="../img/cross_popup.png" title="<?=$_language[$_lang_user]['delete_news_wall']?>"></a>
							<form method="post" action="delete_news_wall.php" class="delete_news_wall">
								<input type="submit" name="delete_news_wall" class="input-support" id="delete-news-wall-<?=$item['id']?>">
								<input type="text" class="input-support" name="id_item" value="<?=$item['id']?>">
							</form>
							<?php
						}
						?>
					</div>
					<div class="description">
						<?php
						if ($item['type'] == 'photo') {
							echo print_image($item['photo'], $_data);
						} else {
							echo $item['text'];
						}
						?>
					</div>
					<form action="user.php" name="form_friend" method="post" style="display:none">
						<input type="hidden" name="id_user_view" value="<?=$sql['id']?>">
						<input class="form<?=$sql['id']?>" type="submit" id="sendButton" style="display: none;" />
					</form> 
					<hr class="button-wall"> 
					<div class="other-function">
						<span>
							<img src="<?=$src_img?>" class="like-button <?=$class_img?>" id="<?=$item['id']?>">
							<span><?=$item['count_like']?></span>
						</span>
					</div>
				</div>
			</div>
			<?php
		} else {
			?>
			<div class="item block" style="padding: 15px">
				<div class="title-item">
					<span>
						<a href="#" class="friend-button-view" id="<?=$sql['id']?>">
							<?php print_image($photo, $_data, 'medium-preview'); ?>
						</a>
					</span>
					<span>
						<p class="author"><a href="#" class="friend-button-view" id="<?=$sql['id']?>"><?=$sql['name']?></a><?=$news_start?></p>
						<p class="date"><?=substr($item['date'], 0, 10)?></p>
					</span>
					<?php
					if ($id_accept == $_SESSION['id']) {
						?>
						<a href="#" class="delete-news-wall" id="delete-news-wall-<?=$item['id']?>" ><img src="../img/cross_popup.png" title="<?=$_language[$_lang_user]['delete_news_wall']?>"></a>
						<form method="post" action="delete_news_wall.php" class="delete_news_wall">
							<input type="submit" name="delete_news_wall" class="input-support" id="delete-news-wall-<?=$item['id']?>">
							<input type="text" class="input-support" name="id_item" value="<?=$item['id']?>">
						</form>
						<?php
					}
					?>
				</div>
				<div class="description">
					<?php
						if ($item['type'] == 'photo') {
							echo print_image($item['photo'], $_data);
						} else {
							echo $item['text'];
						}
					?>
				</div>
				<form action="user.php" name="form_friend" method="post" style="display:none">
					<input type="hidden" name="id_user_view" value="<?=$sql['id']?>">
					<input class="form<?=$sql['id']?>" type="submit" id="sendButton" style="display: none;" />
				</form>
				<hr class="button-wall"> 
				<div class="other-function">
					<span>
						<img src="<?=$src_img?>" class="like-button <?=$class_img?>" id="<?=$item['id']?>">
						<span><?=$item['count_like']?></span>
					</span>
				</div>
			</div>
			<?php
		}
	}

	function edit_liked($object, $id, $type) {
		// type: 1 - add, 0 - remove
		$result = '';
		if (!$type) {
			$pos = strpos($object, $id);
			$result = substr($object, 0, $pos) . substr($object, $pos + strlen($id) - 1);
		} else {
			$result = $object . substr($id, 1);
		}
		return $result;
	}

	function edit_friend($id, $id_friend, $_data, $type, $returned) {
		$user = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id_friend'");
		$user = mysqli_fetch_assoc($user);
		$second_user = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id'");
		$second_user = mysqli_fetch_assoc($second_user);
		$list_friend = $user['id_friend'];
		$second_list_friend = $second_user['id_friend'];
		if ($type) {
			$list_friend = $list_friend . $id . ",";
			$second_list_friend = $second_list_friend . $id_friend . ",";
			mysqli_query($_data, "UPDATE `users` SET `id_friend` = '$list_friend', `count_friend` = `count_friend` + 1 WHERE `id` = '$id_friend'");
			mysqli_query($_data, "UPDATE `users` SET `id_friend` = '$second_list_friend', `count_friend` = `count_friend` + 1 WHERE `id` LIKE '$id'");
		} else {
			$id = ',' . $id . ',';
			$id_friend = ',' . $id_friend . ',';
			$pos = strpos($list_friend, $id);
			$list_friend = substr($list_friend, 0, $pos) . substr($list_friend, $pos + strlen($pos) + 1);
			$pos = strpos($second_list_friend, $id_friend);
			$second_list_friend = substr($second_list_friend, 0, $pos) . substr($second_list_friend, $pos + strlen($pos) + 1);
			$id = substr($id, 1, strlen($id) - 2);
			$id_friend = substr($id_friend, 1, strlen($id_friend) - 2);
			mysqli_query($_data, "UPDATE `users` SET `id_friend` = '$list_friend', `count_friend` = `count_friend` - 1 WHERE `id` = '$id_friend'");
			mysqli_query($_data, "UPDATE `users` SET `id_friend` = '$second_list_friend', `count_friend` = `count_friend` - 1 WHERE `id` = '$id'");
		}
		header('Location:' . $_site . $returned);
	}

	function is_friend($id_friend, $id, $_data) {
		$sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` = '$id'");
		$list_friend = mysqli_fetch_assoc($sql)['id_friend'];
		$id_friend = "," . $id_friend . ",";
		if (strpos($list_friend, $id_friend)) {
			return 1;
		} else {
			return 0;
		}
	}

	function set_log($_data, $id_user, $type_event, $message = null) {
		switch ($type_event) {
			case 'registration':
				mysqli_query($_data, "INSERT INTO `log` (`id_user`, `event`) VALUES ('$id_user', 'New user registration.')");
				break;
			case 'new_name':
				mysqli_query($_data, "INSERT INTO `log` (`id_user`, `event`) VALUES ('$id_user', '$message')");
				break;
			case 'new_password':
				mysqli_query($_data, "INSERT INTO `log` (`id_user`, `event`) VALUES ('$id_user', '$message')");
				break;
		}
	}

	require('language.php');
?>