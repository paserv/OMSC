	<footer class="page-footer blue darken-4 footer">
		<div class="footer-copyright container-footer blue darken-4" style="padding:0 20px 0 20px">
			<div class="blue-text text-lighten-4 left">Total members: 
			<?php
			if (isset ( $_SESSION ["total_users"] )) {
				echo ($_SESSION ["total_users"]);
			}
			?> 
			</div>
			<a class="blue-text text-lighten-4 right share-img-footer" href="https://plus.google.com/share?url=http://www.aoapao.com" target="_blank"><img src="public/img/plus_share.png"></a>
			<a class="blue-text text-lighten-4 right share-img-footer" href="https://twitter.com/intent/tweet?url=http://aoapao.com" target="_blank"><img src="public/img/twitter_share.png"></a>
			<a class="blue-text text-lighten-4 right share-img-footer" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Faoapao.com" target="_blank"><img src="public/img/facebook_share.png"></a>
			<div class="blue-text text-lighten-4 right">Share on: </div>
		</div>
	</footer>
