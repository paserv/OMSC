<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Registration</title>
<script type="text/javascript" src="../../public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="../../public/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="../../public/js/config.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript" src="../../public/js/locationpicker.jquery.min.js"></script>
<script type="text/javascript" src="../../public/js/location_choose.js"></script>
<link href="../../public/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="../../public/css/omsc.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
	<div id="headerseparator"></div>
	<div class="corpo">
		<div class="wrap">
			<div class="left_col">
				<?php 
				include_once '../controllers/Controller.php';
				
				if(isset($_GET['query'])){
					$controller = new Controller();
					$results = $controller->searchByName($_GET['query']);
					if ($results !== null) {
						foreach ($results as $row) {
							?>					
							<div class="searchresult">
								<a href="<?php echo $row["socialPageUrl"]; ?>">
									<img src="<?php echo $row["avatarUrl"]; ?>">
								</a>
								<a href="<?php echo $row["socialPageUrl"]; ?>">
									<img src="../../public/img/<?php echo $row["socialNetwork"]; ?>_pic.png" target="_blank">
								</a>
								<a href="index.php?latitude=<?php echo $row["latitude"]; ?>&longitude=<?php echo $row["longitude"]; ?>" >
									<img src="../../public/img/maps.png">
								</a><br>
								<div class="label">Name</div><br>
								<div><?php echo $row["name"]; ?></div>
								<div class="label">About me</div><br>
								<div><?php echo $row["description"]; ?></div>
							</div>
							
							<?php 
						}
					} else {
						echo "No results found";
						}
				}
				?>
			</div>
			<div class="right_col">
			Map
			</div>
		</div>
	</div>
	
<?php include 'footer.php'; ?>
</body>
</html>