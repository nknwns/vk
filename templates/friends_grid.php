<div class="friends block">
	<div class="title">
		<a href="#" class="view-friend-list-button">
			<?=$_language[$_lang_user]['friend_menu']?><span><?=$user['count_friend']?></span>
		</a>
		<form action="friend.php" method="post">
			<input type="submit" style="display: none" class="view-friend-list" name="view_friend_list" value="<?=$user['id']?>">
		</form>
	</div>
	<div class="grid">
		<?php 
			$lst = $user['id_friend'];
			$lst = "(" . substr($lst, 2, strlen($lst) - 3) . ")";
			$friends_sql = mysqli_query($_data, "SELECT * FROM `users` WHERE `id` IN " . $lst . "LIMIT 6");
			while ($friend_info = mysqli_fetch_assoc($friends_sql)) {
				?>
				<div class="item">
					<a href="#" id="<?=$friend_info['id']?>" class="friend-button-view">
						<?php print_image($friend_info['photo'], $_data, 'medium-preview'); ?>
						<?=explode(' ', $friend_info['name'])[0]?>
					</a>
				</div>
				<form action="user.php" name="form_friend" method="post" style="display:none">
					<input type="hidden" name="id_user_view" value="<?=$friend_info['id']?>">
					<input class="form<?=$friend_info['id']?>" type="submit" id="sendButton" style="display: none;" />
				</form> 
				<?php
			}
		?>
	</div>
</div>