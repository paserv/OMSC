<?php
require_once 'autoload.php';
DBModel_autoload();

class DBModel {
	function getConnection() {
		$conn = new mysqli ( DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE );
		if ($conn->connect_error) {
			throw new Exception("Connection to database unaivailable ", 200);
		}
		return $conn;
	}
	function deleteUser($idUser) {
		$conn = $this->getConnection ();
		$sql = "DELETE FROM user WHERE user.socialId like " . $idUser;
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception("Impossible to delete User ", 201);
		}
		$conn->close ();
	}
	function isUserRegistered($idUser) {
		$conn = $this->getConnection ();
		$sql = "SELECT * FROM user WHERE user.socialId = " . $idUser;
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception("Impossible check User is registered", 202);
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
			throw new Exception("Impossible search User", 203);
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
			throw new Exception("Impossible search by ID", 204);
		} else if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$currUser = new DBUser($row["socialId"], $row["name"], $row["email"], $row["lat"], $row["lng"], $row["description"], $row["socialPageUrl"], $row["avatarUrl"], $row["timestamp"], $row["socialNetwork"]);
			$conn->close ();
			return $currUser;
		}
	}
	function searchByNameAndCoords($name, $lat, $lng, $ray) {
		$res = array();
		
		if ($ray > 100) {
			$ray = 100;
		}
		
		$unit_of_measurement = 'kilometers';
		$gl = GeoLocation::fromDegrees($lat, $lng);
		$result = $gl->boundingCoordinates($ray, $unit_of_measurement);
		
		$minLat = $result[0]->getLatitudeInDegrees();
		$minLng = $result[0]->getLongitudeInDegrees();
		
		$maxLat = $result[1]->getLatitudeInDegrees();
		$maxLng = $result[1]->getLongitudeInDegrees();
		
		$conn = $this->getConnection ();
		$sql = "SELECT * FROM user WHERE (user.lat >= " . $minLat . " AND Lat <= " . $maxLat . ") AND (user.lng >= " . $minLng . " AND user.lng <= " . $maxLng . ") HAVING user.name like '%" . $name . "%'";
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception("Impossible search by Coords", 211);
		} else if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$currUser = new DBUser($row["socialId"], $row["name"], $row["email"], $row["lat"], $row["lng"], $row["description"], $row["socialPageUrl"], $row["avatarUrl"], $row["timestamp"], $row["socialNetwork"]);
				array_push($res, $currUser);
			}
			return $res;
		} else {
			throw new Exception("No Result found in search by Name And Coords", 213);
		}
		$conn->close ();
	}
	function countUsers() {
		$result = 0;
		$conn = $this->getConnection ();
		$sql = "SELECT COUNT(socialId) as total_users FROM user WHERE 1";
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception ( "Select count error", 210 );
		} else if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$result = $row["total_users"];
		}
		$conn->close ();
		return $result;
	}
	function searchByCoords($lat, $lng, $ray) {
		$res = array();
		
		if ($ray > 100) {
			$ray = 100;
		}
		
		$unit_of_measurement = 'kilometers';
		$gl = GeoLocation::fromDegrees($lat, $lng);
		$result = $gl->boundingCoordinates($ray, $unit_of_measurement);
		
		$minLat = $result[0]->getLatitudeInDegrees();
		$minLng = $result[0]->getLongitudeInDegrees();
		
		$maxLat = $result[1]->getLatitudeInDegrees();
		$maxLng = $result[1]->getLongitudeInDegrees();
		
		$conn = $this->getConnection ();
		$sql = "SELECT * FROM user WHERE (user.lat >= " . $minLat . " AND Lat <= " . $maxLat . ") AND (user.lng >= " . $minLng . " AND user.lng <= " . $maxLng . ")";
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception("Impossible search by Coords", 211);
		} else if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$currUser = new DBUser($row["socialId"], $row["name"], $row["email"], $row["lat"], $row["lng"], $row["description"], $row["socialPageUrl"], $row["avatarUrl"], $row["timestamp"], $row["socialNetwork"]);
				array_push($res, $currUser);
			}
			return $res;
		} else {
			throw new Exception("No Result found in search by Coords", 212);
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
			throw new Exception ( "User Already Registered", 205 );
		}
		if ($this->areUsersMoreThan ( 1000000 )) {
			throw new Exception ( "One Million Users already registered", 206 );
		}
		$conn = $this->getConnection ();
		$avatUrl = DBModel::escapeUrl ( $conn, $dbData->avatarUrl );
		$profileUrl = DBModel::escapeUrl ( $conn, $dbData->socialPageUrl );
		$sql = "INSERT INTO user (socialId, name, email, avatarUrl, description, socialPageUrl, lat, lng, timestamp, socialNetwork) VALUES ('$dbData->socialId', '$dbData->name', '$dbData->email', '$dbData->avatarUrl', '$dbData->description', '$dbData->socialPageUrl', '$dbData->latitude', '$dbData->longitude', '$dbData->timestamp', '$dbData->socialNetwork')";
		if ($conn->query ( $sql ) === FALSE) {
			$error = $conn->error;
			$conn->close ();
			throw new Exception ( "Error insert user", 207 );
		}
		$conn->close ();
	}
	function updateUser(DBUser $dbData) {
		if (!$this->isUserRegistered ( $dbData->socialId )) {
			throw new Exception ( "Error User Not Registered", 208 );
		}
		$conn = $this->getConnection ();
		$avatUrl = DBModel::escapeUrl ( $conn, $dbData->avatarUrl );
		$profileUrl = DBModel::escapeUrl ( $conn, $dbData->socialPageUrl );
		$sql = "UPDATE user SET description = '$dbData->description', lat = '$dbData->latitude', lng = '$dbData->longitude' WHERE socialId = '$dbData->socialId'";
		if ($conn->query ( $sql ) === FALSE) {
			$error = $conn->error;
			$conn->close ();
			throw new Exception ( "Error update User", 209 );
		}
		$conn->close ();
	}
	function areUsersMoreThan($num) {
		$conn = $this->getConnection ();
		$sql = "SELECT COUNT(*) as total_users FROM user WHERE 1";
		$result = $conn->query ( $sql );
		if (!$result) {
			throw new Exception ( "Select count error", 210 );
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
