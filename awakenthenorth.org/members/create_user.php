<?
error_reporting(E_ALL);
require("db.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/users/init.php';

$fields=array(
              'username' => "testone",
              'fname' => ucfirst("test"),
              'lname' => ucfirst("test"),
              'email' => "test@test.com",
              'password' => password_hash("password", PASSWORD_BCRYPT, array('cost' => 12)),
              'permissions' => 1,
              'account_owner' => 1,
              'join_date' => date("Y-m-d H:i:s"),
              'email_verified' => 1,
              'active' => 1,
              'vericode' => randomstring(15),
              'force_pr' => 0,
            );
/*
            $db->insert('users',$fields);
            $theNewId=$db->lastId();
            $addNewPermission = array('user_id' => $theNewId, 'permission_id' => 1);
            $db->insert('user_permission_matches',$addNewPermission);
            include($abs_us_root.$us_url_root.'usersc/scripts/during_user_creation.php');
			echo $theNewId;

MDB::insert("users", $fields);
$theNewId=MDB::insertId();
$addNewPermission = array('user_id' => $theNewId, 'permission_id' => 1);
MDB::insert('user_permission_matches',$addNewPermission);
echo $theNewId;
*/


$url = 'https://www.awakenthenorth.org/wp-json/wp/v2/users/register';
 
//Initiate cURL.
$ch = curl_init($url);
 
//The JSON data.
$jsonData = array(
    'username' => 'testuser',
    'password' => 'password',
	'email' => 'test@test.com'
);
 
//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);
 
//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);
 
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
//Execute the request
$result = curl_exec($ch);
print_r($result);
?>