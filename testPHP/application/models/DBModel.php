<?php
include_once '../configuration/DBconfig.php';
include_once '../dto/DBUser.php';

class DBModel {
	function getConnection() {
		$conn = new mysqli ( DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE );
		if ($conn->connect_error) {
			die ( "Connection failed: " . $conn->connect_error );
			return NULL;
		}
		return $conn;
	}
	function deleteUser($idUser) {
		$conn = $this->getConnection ();
		$sql = "DELETE FROM user WHERE user.socialId like " . $idUser;
		$result = $conn->query($sql);
		$conn->close ();
	}
	function isUserRegistered($idUser) {
		$conn = $this->getConnection ();
		$sql = "SELECT COUNT * FROM user WHERE user.socialId like " . $idUser;
		$result = $conn->query($sql);
		$conn->close ();
		if ($result->num_rows > 0) {
			return TRUE;
		}
		return FALSE;
	}
	static function escapeUrl($conn, $url) {
		$urlEscaped = $url;
		$urlEscaped = urlencode ( $urlEscaped );
		$urlEscaped = $conn->real_escape_string ( $urlEscaped );
		return $urlEscaped;
	}
	function insertUser(DBUser $dbData) {
		$conn = $this->getConnection ();
		$avatUrl = DBModel::escapeUrl ( $conn, $dbData->avatarUrl );
		$profileUrl = DBModel::escapeUrl ( $conn, $dbData->socialPageUrl );
		$sql = "INSERT INTO user (socialId, name, email, avatarUrl, description, socialPageUrl, latitude, longitude, timestamp, socialNetwork) VALUES ('$dbData->socialId', '$dbData->name', '$dbData->email', '$dbData->avatarUrl', '$dbData->description', '$dbData->socialPageUrl', '$dbData->latitude', '$dbData->longitude', '$dbData->timestamp', '$dbData->socialNetwork')";
		if ($conn->query ( $sql ) === FALSE) {
			$error =  $conn->error;
			$conn->close ();
			throw new Exception("Error: " . $sql . "<br>" . $error);
		} 
		$conn->close ();
	}
	
	function insertFakeFusionUser(DBUser $dbData) {
		$conn = $this->getConnection ();
		$profileUrl = DBModel::escapeUrl ( $conn, $dbData->socialPageUrl );
		$location = "'" . $dbData->latitude . "," . $dbData->longitude . "'";
		$sql = "INSERT INTO fusionuser (socialId, name, email, avatarUrl, description, socialPageUrl, latitude, longitude, timestamp, socialNetwork) VALUES ('$dbData->socialId', '$dbData->name', '$dbData->email', '$dbData->avatarUrl', '$dbData->description', '$dbData->socialPageUrl', '$dbData->latitude', '$dbData->longitude', '$dbData->timestamp', '$dbData->socialNetwork')";
		if ($conn->query ( $sql ) === TRUE) {
			echo "New Fake Fusion User created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close ();
	}
	
}

?>
