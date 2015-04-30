 <?php
 
 	ini_set('max_execution_time', 10000);
	include_once '../controllers/Controller.php';
	/*
	$conn = new mysqli ( "localhost", "fusion", "fusion", "fusion" );
	$sql =	"SELECT * FROM user	WHERE user.lat BETWEEN -1 AND +1 AND user.lng BETWEEN -1 AND +1";
	
	$result = $conn->query ( $sql );
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "ID: " . $row["socialId"]. " - Name: " . $row["name"]. " - Latitude: " . $row["lat"]. " - Longitude:  " . $row["lng"]. "<br>"; 
		}
	} else {
		echo "No Rows";
	}
	$conn->close ();
	*/
	$controller = new Controller();
	$results = $controller->searchByName($_GET['query']);
	if ($results !== null) {
		foreach ($results as $currUser) {
			echo "Lat: " . $currUser->latitude . " Lon: " . $currUser->longitude . " Name: " . $currUser->name . "<br>";
			}		
		} else {
			echo "No results found";
			}
	?>