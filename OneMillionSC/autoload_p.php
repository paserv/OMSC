<?php
function getDirs() {
	$dirs = array(
			"root" => $_SERVER["DOCUMENT_ROOT"],
			"models" =>  __DIR__ . '/models/',
			"dto" => __DIR__ . '/dto/',
			"configuration" => __DIR__ . '/configuration/',
			"controllers" =>  __DIR__ . '/controllers/',
	);
	return $dirs;
}

function controller_autoload($tcp) {
	$dirs = getDirs();
	
	$file1 = $dirs['models'] . 'FBModel.php';
	$file2 = $dirs['models'] . 'DBModel.php';
	$file3 = $dirs['models'] . 'FusionModel.php';
	$file4 = $dirs['models'] . 'DummyModel.php';
	$file5 = $dirs['dto'] . 'SocialUser.php';
	$file6 = $dirs['dto'] . 'DBUser.php';
	
	$dep_array = array($file1, $file2, $file3, $file4, $file5, $file6);
	
	foreach ($dep_array as $file) {
		require_once($file);
	}
}

function FBModel_autoload($tcp) {
	$dirs = getDirs();

	$file1 = $dirs['root'] . '/library/facebook-php-sdk/autoload.php';
	$file2 = $dirs['configuration'] . 'FBconfig.php';
	$file3 = $dirs['models'] . 'AbstractSocialModel.php';
	$file4 = $dirs['dto'] . 'SocialUser.php';
	$file5 = $dirs['controllers'] . 'SocialException.php';

	$dep_array = array($file1, $file2, $file3, $file4, $file5);

	foreach ($dep_array as $file) {
		require_once($file);
	}
}

function FusionModel_autoload($tcp) {
	$dirs = getDirs();

	$file1 = $dirs['root'] . '/library/google-php-api/autoload.php';
	$file2 = $dirs['dto'] . 'DBUser.php';

	$dep_array = array($file1, $file2);

	foreach ($dep_array as $file) {
		require_once($file);
	}
}

function DBModel_autoload($tcp) {
	$dirs = getDirs();

	$file1 = $dirs['configuration'] . 'DBConfig.php';
	$file2 = $dirs['dto'] . 'DBUser.php';

	$dep_array = array($file1, $file2);

	foreach ($dep_array as $file) {
		require_once($file);
	}
}

function DummyModel_autoload($tcp) {
	$dirs = getDirs();

	$file1 = $dirs['models'] . 'AbstractSocialModel.php';
	$file2 = $dirs['dto'] . 'SocialUser.php';

	$dep_array = array($file1, $file2);

	foreach ($dep_array as $file) {
		require_once($file);
	}
}

function DBUser_autoload($tcp) {
	$dirs = getDirs();
	$file1 = $dirs['dto'] . 'SocialUser.php';
	require_once($file1);
}