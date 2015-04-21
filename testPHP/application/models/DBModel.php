<?php
include_once '../configuration/DBconfig.php';
include_once '../dto/DBUserData.php';
class DBModel {
	function getConnection() {
		$conn = new mysqli ( DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE );
		if ($conn->connect_error) {
			die ( "Connection failed: " . $conn->connect_error );
			return NULL;
		}
		return $conn;
	}
	static function escapeUrl($conn, $url) {
		$urlEscaped = $url;
		$urlEscaped = urlencode ( $urlEscaped );
		$urlEscaped = $conn->real_escape_string ( $urlEscaped );
		return $urlEscaped;
	}
	function insertUser(DBUserData $dbData) {
		$conn = $this->getConnection ();
		$avatUrl = DBModel::escapeUrl ( $conn, $dbData->avatarUrl );
		$profileUrl = DBModel::escapeUrl ( $conn, $dbData->socialPageUrl );
		$sql = "INSERT INTO user (id, name, email, avatarUrl, description, socialPageUrl, latitude, longitude) VALUES ('$dbData->id', '$dbData->name', '$dbData->email', '$avatUrl', '$dbData->description', '$profileUrl', '$dbData->latitude', '$dbData->longitude')";
		if ($conn->query ( $sql ) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close ();
	}
}

?>
