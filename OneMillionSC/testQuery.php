<?php
$lat = 40.9230386;
$lng = 14.309303999999997;
$ray = 0.9; //degree to kilometers -> 1 degree = 111.32 Km

$date = new DateTime();
$first = $date->getTimestamp();
$conn = new mysqli ( "127.0.0.1", "root", "", "test");
if (!$conn->connect_error) {
	$sql = "SELECT name FROM user2 WHERE Contains(GeomFromText(CONCAT('POLYGON((',X(GeomFromText('POINT(" . $lat . " " . $lng . ")')) - " . $ray .", ' ', Y(GeomFromText('POINT(" . $lat . " " . $lng . ")')) - " . $ray .", ',', X(GeomFromText('POINT(" . $lat . " " . $lng . ")')) + " . $ray .", ' ', Y(GeomFromText('POINT(" . $lat . " " . $lng . ")')) - " . $ray .", ',', X(GeomFromText('POINT(" . $lat . " " . $lng . ")')) + " . $ray .", ' ', Y(GeomFromText('POINT(" . $lat . " " . $lng . ")')) + " . $ray .", ',', X(GeomFromText('POINT(" . $lat . " " . $lng . ")')) - " . $ray .", ' ', Y(GeomFromText('POINT(" . $lat . " " . $lng . ")')) + " . $ray .", ',', X(GeomFromText('POINT(" . $lat . " " . $lng . ")')) - " . $ray .", ' ', Y(GeomFromText('POINT(" . $lat . " " . $lng . ")')) - " . $ray .", '))')), location)";
	echo $sql;
	
	$result = $conn->query ( $sql );
	if ($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo $row["name"] . "<br>";
		}
	}
	$conn->close ();
}
$date = new DateTime();
$second = $date->getTimestamp();
echo ($second - $first);

$date = new DateTime();
$third = $date->getTimestamp();
//$conn = new mysqli ( "127.0.0.1", "root", "", "test");
$conn = new mysqli ( "127.0.0.1", "fusion", "fusion", "fusion");
if (!$conn->connect_error) {
	//$sql = "SELECT * FROM user2 WHERE (user2.latitude >= 40.023718405665 AND user2.latitude <= 41.822358794335) AND (user2.longitude >= 13.119045011002 AND user2.longitude <= 15.499562988998)";
	$sql = "SELECT * FROM user WHERE (user.lat >= 40.023718405665 AND user.lat <= 41.822358794335) AND (user.lng >= 13.119045011002 AND user.lng <= 15.499562988998)";
	echo $sql;

	$result = $conn->query ( $sql );
	if ($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo $row["name"] . "<br>";
		}
	}
	$conn->close ();
}
$date = new DateTime();
$fourth = $date->getTimestamp();
echo ($fourth - $third);

?>