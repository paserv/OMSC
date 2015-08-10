	<footer class="page-footer blue darken-3 footer">
		<div class="footer-copyright container-footer blue darken-3" style="padding:0 20px 0 20px">
			<div class="grey-text text-lighten-3 left">Total members: 
			<?php
			if (isset ( $_SESSION ["total_users"] )) {
				echo ($_SESSION ["total_users"]);
			}
			?> 
			</div>
			<a class="grey-text text-lighten-3 right share-img-footer" href="https://plus.google.com/share?url=http://www.aoapao.com" target="_blank"><img src="public/img/plus_share.png"></a>
			<a class="grey-text text-lighten-3 right share-img-footer" href="https://twitter.com/intent/tweet?url=http://aoapao.com" target="_blank"><img src="public/img/twitter_share.png"></a>
			<a class="grey-text text-lighten-3 right share-img-footer" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Faoapao.com" target="_blank"><img src="public/img/facebook_share.png"></a>
			<div class="grey-text text-lighten-3 right">Share on: </div>
		</div>
	</footer>
