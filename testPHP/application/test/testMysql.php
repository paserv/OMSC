 <?php
 	ini_set('max_execution_time', 10000);
	include_once '../controllers/Controller.php';
	include_once '../dto/DBUser.php';
	
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
	?>