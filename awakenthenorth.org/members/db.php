<?php
error_reporting(0);
require("meekrodb.php");
MDB::$user = 'intheexp_cmr';
MDB::$password = 'password';
MDB::$dbName = 'intheexp_cmr';
$settings=MDB::query("SELECT * FROM atn_config");
foreach ($settings as $row) {
	
	define($row["name"], $row["value"]);
}
date_default_timezone_set('America/Denver');

if(isset($user) && $user->isLoggedIn() && (hasPerm([2],$user->data()->id) || hasPerm([3],$user->data()->id))){
	define(ISADMIN, true);
	//echo hasPerm([2],$user->data()->id);
} else {
	define(ISADMIN, false);
}
?>