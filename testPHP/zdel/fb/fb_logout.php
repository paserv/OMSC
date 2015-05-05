<?php
session_start ();
session_unset ();
$_SESSION ['FBID'] = NULL;
$_SESSION ['FULLNAME'] = NULL;
$_SESSION ['EMAIL'] = NULL;
$_SESSION ['access_token'] = NULL;
header ( "Location: ../test_fb.php" );
?>
