<?php
error_reporting(0);
require("meekrodb.php");
MDB::$user = 'intheexp_cmr';
MDB::$password = 'password';
MDB::$dbName = 'intheexp_cmr';
/*
$setsql=MDB::query("SELECT * FROM res_settings");
// type: 1=string, 2=array
define(DEVSYSTEM, false);
$ressettings=array();
foreach ($setsql as $row) {
	if ($row["type"] == 2) { $value=unserialize($row["value"]); } else { $value=$row["value"]; }
	$ressettings[$row["name"]]=$value;
}
$includes=MDB::query("SELECT * FROM res_includes WHERE status = 1");
//foreach(glob('/home/intheexp/ntdev.chrisclaus.com/res/functions/*.php') as $file) {
     //include_once $file;
//}
foreach ($includes as $file) {
	require("/home/montanah/public_html/admin/functions/".$file["filename"]);
	//echo "Including ".$file["filename"].'<br>';
}
$config["imagespath"]='/home/montanah/public_html/admin/images/';
$config["imagesurl"]='https://www.montanahappycampers.com/admin/images/';
//require("/home/montanah/public_html/reserve/vendor/autoload.php");
require("/home/montanah/public_html/admin/vendor/autoload.php");
use Mailgun\Mailgun;
//$mgClient = new Mailgun('23170a846418b2c215f89a11acb905c4-2d27312c-824394a4');
//$mgDomain = "mg.montanahappycampers.com";
*/
date_default_timezone_set('America/Denver');

?>