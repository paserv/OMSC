<?php
require '../db/dbconfig.php';
function open_connection(){
	$conn = new mysqli ( DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE );
	
	if ($conn->connect_error) {
		die ( "Connection failed: " . $conn->connect_error );
		return NULL;
	}
	return $conn;
}

function insert_user($fbid, $fbfullname, $femail) {
	$conn = open_connection();
	$sql = "INSERT INTO user (id, name, email) VALUES ('$fbid', '$fbfullname', '$femail')";
	if ($conn->query ( $sql ) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close ();
}
?>
