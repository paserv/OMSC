<?php
require '../db/dbcrud.php';
function run_pipeline($fbid, $fbfullname, $femail) {
	insert_user($fbid, $fbfullname, $femail);
}
?>