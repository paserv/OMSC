<?php
require_once '../configuration/DBconfig.php';
require_once '../dto/DBUser.php';

#require_once $_SERVER["DOCUMENT_ROOT"] . '/application/configuration/DBConfig.php';
#require_once $_SERVER["DOCUMENT_ROOT"] . '/application/dto/DBUser.php';

$findCoordByNameStatement = "SELECT lat, lng FROM user WHERE name LIKE ?";

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
		$result = $conn->query ( $sql );
		$conn->close ();
	}
	function isUserRegistered($idUser) {
		$conn = $this->getConnection ();
		$sql = "SELECT * FROM user WHERE user.socialId like " . $idUser;
		$result = $conn->query ( $sql );
		$conn->close ();
		if ($result->num_rows > 0) {
			return TRUE;
		}
		return FALSE;
	}
	function searchByName($name) {
		$res = array();
		$conn = $this->getConnection ();
		$sql = "SELECT * FROM user WHERE user.name like '%" . $name . "%' limit 1000";
		$result = $conn->query ( $sql );
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$currUser = new DBUser($row["socialId"], $row["name"], $row["email"], $row["lat"], $row["lng"], $row["description"], $row["socialPageUrl"], $row["avatarUrl"], $row["timestamp"], $row["socialNetwork"]);
				array_push($res, $currUser);
			}
			return $res;
		} else {
			return null;
		}
		$conn->close ();
	}
	static function escapeUrl($conn, $url) {
		$urlEscaped = $url;
		$urlEscaped = urlencode ( $urlEscaped );
		$urlEscaped = $conn->real_escape_string ( $urlEscaped );
		return $urlEscaped;
	}
	function insertUser(DBUser $dbData) {
		if ($this->isUserRegistered ( $dbData->socialId )) {
			throw new Exception ( "Error: Already Registered" );
		}
		$conn = $this->getConnection ();
		$avatUrl = DBModel::escapeUrl ( $conn, $dbData->avatarUrl );
		$profileUrl = DBModel::escapeUrl ( $conn, $dbData->socialPageUrl );
		// Insert Address???
		$sql = "INSERT INTO user (socialId, name, email, avatarUrl, description, socialPageUrl, latitude, longitude, timestamp, socialNetwork) VALUES ('$dbData->socialId', '$dbData->name', '$dbData->email', '$dbData->avatarUrl', '$dbData->description', '$dbData->socialPageUrl', '$dbData->latitude', '$dbData->longitude', '$dbData->timestamp', '$dbData->socialNetwork')";
		if ($conn->query ( $sql ) === FALSE) {
			$error = $conn->error;
			$conn->close ();
			throw new Exception ( "Error: " . $sql . "<br>" . $error );
		}
		$conn->close ();
	}
	function insertFakeFusionUser(DBUser $dbData) {
		$conn = $this->getConnection ();
		$profileUrl = DBModel::escapeUrl ( $conn, $dbData->socialPageUrl );
		$location = "'" . $dbData->latitude . "," . $dbData->longitude . "'";
		$sql = "INSERT INTO fusionuser (socialId, name, email, avatarUrl, description, socialPageUrl, latitude, longitude, timestamp, socialNetwork) VALUES ('$dbData->socialId', '$dbData->name', '$dbData->email', '$dbData->avatarUrl', '$dbData->description', '$dbData->socialPageUrl', '$dbData->latitude', '$dbData->longitude', '$dbData->timestamp', '$dbData->socialNetwork')";
		if ($conn->query ( $sql ) === FALSE) {
			$error = $conn->error;
			$conn->close ();
			throw new Exception ( "Error: " . $sql . "<br>" . $error );
		}
		$conn->close ();
	}
}

?>
