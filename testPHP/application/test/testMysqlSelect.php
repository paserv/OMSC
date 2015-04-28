 <?php
	include_once '../models/DBModel.php';
	
	$model = new DBModel();
	$result = $model->searchByName("Paolo");
	
	if ($result !== null) {
		foreach ($result as $row) {
			echo $row["socialId"];
			echo $row["name"];
		}
	}
	

	?>