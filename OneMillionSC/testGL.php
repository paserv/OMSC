<?php
// require_once 'library/GeoLocation/GeoLocation.php';

$latitude = 42.1345;
$longitude = 12.432;
$ray = 100;
// $unit_of_measurement = 'kilometers';

// $gl = GeoLocation::fromDegrees($latitude, $longitude);
// $result = $gl->boundingCoordinates($ray, $unit_of_measurement);

// $min = $result[0];
// $max = $result[1];
// echo "Min Lat: " . $min->getLatitudeInDegrees() . " Min Lng: " . $min->getLongitudeInDegrees() . "<br>";
// echo "Max Lat: " . $max->getLatitudeInDegrees() . " Max Lng: " . $max->getLongitudeInDegrees() . "<br>";

require_once 'models/DBModel.php';

$model = new DBModel();

$res = $model->searchByCoords($latitude, $longitude, $ray);

foreach ($res as $currUser) {
	$currUser->stringify();
	echo "<br>";
}
?>