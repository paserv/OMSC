<?php
require_once 'autoload.php';
DBModel_autoload();

class DBModel {
	function getConnection() {
		$conn = new mysqli ( DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE );
		if ($conn->connect_error) {
			throw new Exception("Connection to database unaivailable ", 100);
		}
		return $conn;
	}
	function deleteUser($idUser) {
		$conn = $this->getConnection ();
		$sql = "DELETE FROM user WHERE user.socialId like " . $idUser;
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception("Impossible to delete User ", 100);
		}
		$conn->close ();
	}
	function isUserRegistered($idUser) {
		$conn = $this->getConnection ();
		$sql = "SELECT * FROM user WHERE user.socialId = " . $idUser;
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception("Impossible check User is registered", 200);
		} else if ($result->num_rows > 0) {
			$conn->close ();
			return TRUE;
			}
		$conn->close ();
		return FALSE;
	}
	function searchByName($name) {
		$res = array();
		$conn = $this->getConnection ();
		$sql = "SELECT * FROM user WHERE user.name like '%" . $name . "%' limit " . DB_SEARCH_LIMIT;
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception("Impossible search User", 300);
		} else if ($result->num_rows > 0) {
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
	function searchById($socialId) {
		$conn = $this->getConnection ();
		$sql = "SELECT * FROM user WHERE user.socialId = " . $socialId;
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception("Database problem", 200);
		} else if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$currUser = new DBUser($row["socialId"], $row["name"], $row["email"], $row["lat"], $row["lng"], $row["description"], $row["socialPageUrl"], $row["avatarUrl"], $row["timestamp"], $row["socialNetwork"]);
			$conn->close ();
			return $currUser;
		}
	}
	static function escapeUrl($conn, $url) {
		$urlEscaped = $url;
		$urlEscaped = urlencode ( $urlEscaped );
		$urlEscaped = $conn->real_escape_string ( $urlEscaped );
		return $urlEscaped;
	}
	function insertUser(DBUser $dbData) {
		if ($this->isUserRegistered ( $dbData->socialId )) {
			throw new Exception ( "User Already Registered", 400 );
		}
		if ($this->areUsersMoreThan ( 1000000 )) {
			throw new Exception ( "One Million Users already registered", 500 );
		}
		$conn = $this->getConnection ();
		$avatUrl = DBModel::escapeUrl ( $conn, $dbData->avatarUrl );
		$profileUrl = DBModel::escapeUrl ( $conn, $dbData->socialPageUrl );
		$sql = "INSERT INTO user (socialId, name, email, avatarUrl, description, socialPageUrl, lat, lng, timestamp, socialNetwork) VALUES ('$dbData->socialId', '$dbData->name', '$dbData->email', '$dbData->avatarUrl', '$dbData->description', '$dbData->socialPageUrl', '$dbData->latitude', '$dbData->longitude', '$dbData->timestamp', '$dbData->socialNetwork')";
		if ($conn->query ( $sql ) === FALSE) {
			$error = $conn->error;
			$conn->close ();
			throw new Exception ( "Error: " . $sql . "<br>" . $error, 600 );
		}
		$conn->close ();
	}
	function updateUser(DBUser $dbData) {
		if (!$this->isUserRegistered ( $dbData->socialId )) {
			throw new Exception ( "Error: Not Registered", 700 );
		}
		$conn = $this->getConnection ();
		$avatUrl = DBModel::escapeUrl ( $conn, $dbData->avatarUrl );
		$profileUrl = DBModel::escapeUrl ( $conn, $dbData->socialPageUrl );
		$sql = "UPDATE user SET description = '$dbData->description', lat = '$dbData->latitude', lng = '$dbData->longitude' WHERE socialId = '$dbData->socialId'";
		if ($conn->query ( $sql ) === FALSE) {
			$error = $conn->error;
			$conn->close ();
			throw new Exception ( "Error: " . $sql . "<br>" . $error, 800 );
		}
		$conn->close ();
	}
	function areUsersMoreThan($num) {
		$conn = $this->getConnection ();
		$sql = "SELECT COUNT(*) as total_users FROM user WHERE 1";
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception ( "Select count error", 900 );
		} else if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			if ($row["total_users"] >= 1000000) {
				return true;
			} else return false;
		}
		$conn->close ();
	}
	function insertFakeFusionUser(DBUser $dbData) {
		$conn = $this->getConnection ();
		$profileUrl = DBModel::escapeUrl ( $conn, $dbData->socialPageUrl );
		$location = "'" . $dbData->latitude . "," . $dbData->longitude . "'";
		$sql = "INSERT INTO fusionuser (socialId, name, email, avatarUrl, description, socialPageUrl, lat, lng, timestamp, socialNetwork) VALUES ('$dbData->socialId', '$dbData->name', '$dbData->email', '$dbData->avatarUrl', '$dbData->description', '$dbData->socialPageUrl', '$dbData->latitude', '$dbData->longitude', '$dbData->timestamp', '$dbData->socialNetwork')";
		if ($conn->query ( $sql ) === FALSE) {
			$error = $conn->error;
			$conn->close ();
			throw new Exception ( "Error: " . $sql . "<br>" . $error );
		}
		$conn->close ();
	}
}

?>
