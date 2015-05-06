<?php
function getDirs() {
	$dirs = array(
			"root" => $_SERVER["DOCUMENT_ROOT"],
			"models" =>  __DIR__ . '/models/',
			"dto" => __DIR__ . '/dto/',
			"configuration" => __DIR__ . '/configuration/',
			"controllers" =>  __DIR__ . '/controllers/',
			"library" =>  __DIR__ . '/library/',
			"tcp" => '_c',
	);
	return $dirs;
}

function controller_autoload() {
	$dirs = getDirs();
	
	$file1 = $dirs['models'] . 'FBModel.php';
	$file2 = $dirs['models'] . 'DBModel.php';
	$file3 = $dirs['models'] . 'FusionModel.php';
	$file4 = $dirs['models'] . 'DummyModel.php';
	$file5 = $dirs['dto'] . 'SocialUser.php';
	$file6 = $dirs['dto'] . 'DBUser.php';
	
	$dep_array = array($file1, $file2, $file3, $file4, $file5, $file6);
	
	require_array($dep_array);
}

function FBModel_autoload() {
	$dirs = getDirs();
	$tcp = $dirs['tcp'];
	
	$file1 = $dirs['library'] . '/facebook-php-sdk/autoload.php';
	$file2 = $dirs['configuration'] . 'FBConfig' . $tcp . '.php';
	$file3 = $dirs['models'] . 'AbstractSocialModel.php';
	$file4 = $dirs['dto'] . 'SocialUser.php';
	$file5 = $dirs['controllers'] . 'SocialException.php';

	$dep_array = array($file1, $file2, $file3, $file4, $file5);

	require_array($dep_array);
}

function FusionModel_autoload() {
	$dirs = getDirs();
	$tcp = $dirs['tcp'];
	
	$file1 = $dirs['library'] . '/google-php-api/autoload.php';
	$file2 = $dirs['configuration'] . 'FusionConfig' . $tcp . '.php';
	$file3 = $dirs['dto'] . 'DBUser.php';
	
	$dep_array = array($file1, $file2, $file3);

	require_array($dep_array);
}

function DBModel_autoload() {
	$dirs = getDirs();
	$tcp = $dirs['tcp'];
	
	$file1 = $dirs['configuration'] . 'DBConfig' . $tcp . '.php';
	$file2 = $dirs['dto'] . 'DBUser.php';

	$dep_array = array($file1, $file2);

	require_array($dep_array);
}

function DummyModel_autoload() {
	$dirs = getDirs();
	$file1 = $dirs['models'] . 'AbstractSocialModel.php';
	$file2 = $dirs['dto'] . 'SocialUser.php';
	$dep_array = array($file1, $file2);
	require_array($dep_array);
}

function DBUser_autoload() {
	$dirs = getDirs();
	$file1 = $dirs['dto'] . 'SocialUser.php';
	$dep_array = array($file1);
	require_array($dep_array);
}

function loginRegister_autoload() {
	$dirs = getDirs();
	$file1 = $dirs['controllers'] . 'Controller.php';
	$file2 = $dirs['dto'] . 'SocialUser.php';
	$dep_array = array($file1, $file2);
	require_array($dep_array);
}

function search_autoload() {
	$dirs = getDirs();
	$file1 = $dirs['controllers'] . 'Controller.php';
	$dep_array = array($file1);
	require_array($dep_array);
}

function require_array($dep_array) {
	foreach ($dep_array as $file) {
		require_once($file);
	}
}