<div class="left-menu offset-1 col-2">
	<nav>
		<ul>
			<li><a href="account.php"><span><img src="../img/home.svg"></span><?=$_language[$_lang_user]['account_menu']?></span></a></li>
			<li><a href="news.php"><span><img src="../img/news.svg"><?=$_language[$_lang_user]['news_menu']?></span></a></li>
			<li><a href="messenger.php"><span><img src="../img/messenger.svg"><?=$_language[$_lang_user]['messenger_menu']?></span></a></li>
			<li><a href="#" class="view-friend-list-button-left"><span><img src="../img/friend.svg"><?=$_language[$_lang_user]['friend_menu']?></span></a></li>
			<form action="redirect.php" method="post">
				<input type="submit" class="view-friend-list-left input-support" name="view_friend_list" value="<?=$_user['id']?>">
			</form>
		</ul>
	</nav>
</div>