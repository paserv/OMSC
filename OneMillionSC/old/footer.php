<div id="footer">
	<div class="wrap">
		<div class="left_col">
			Total members: 
			<?php 
				if (isset($_SESSION ["total_users"])) { 
					echo ($_SESSION ["total_users"]); 
				} 
				?>
		</div>
		<div class="right_col">
			Share on&nbsp
			<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Faoapao.com" target="_blank"><img src="public/img/facebook_share.png"></a>
			<!-- <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button"></div> -->
			<a href="https://twitter.com/intent/tweet?url=http://aoapao.com" target="_blank"><img src="public/img/twitter_share.png"></a>
			<!-- <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://aoapoa.com" data-count="none" data-hashtags="omsc">Tweet</a> -->
			<a href="https://plus.google.com/share?url=http://www.aoapao.com" target="_blank"><img src="public/img/plus_share.png"></a>
			<!-- <a href="https://plus.google.com/share?url=http://www.aoapao.com" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="public/img/plus_share.png" alt="Share on Google+"/></a> -->
			&nbsp&nbsp
		</div>
	</div>
</div>