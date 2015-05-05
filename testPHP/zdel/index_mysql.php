 <?php
	echo $_GET ['titolo'];
	
	$servername = "localhost";
	$username = "fusion";
	$password = "fusion";
	$dbname = "fusion";
	
	$conn = new mysqli ( $servername, $username, $password, $dbname );
	
	if ($conn->connect_error) {
		die ( "Connection failed: " . $conn->connect_error );
	}
	
	$sql = "INSERT INTO location (descrizione, latitudine, longitudine) VALUES ('Assa', 34.54, 12.23)";
	
	if ($conn->query ( $sql ) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	$conn->close ();
	
	?>