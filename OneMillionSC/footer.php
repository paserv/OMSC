<div id="footer">
	<div class="wrap">
		<div class="left_col">
			Total members: 
			<?php 
				if (isset($_SESSION ["total_users"])) { 
					echo ($_SESSION ["total_users"]); 
				} else { 
					$controller = new Controller(); 
					$total = $controller->countMembers(); 
					echo ($total);
				}?>
		</div>
		<div class="right_col">
			Share on&nbsp
			<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Faoapao.com" target="_blank"><img src="public/img/facebook_share.png"></a>
			<a href="#" target="_blank"><img src="public/img/twitter_share.png"></a>
			<a href="#" target="_blank"><img src="public/img/plus_share.png"></a>
			&nbsp&nbsp
		</div>
	</div>
</div>