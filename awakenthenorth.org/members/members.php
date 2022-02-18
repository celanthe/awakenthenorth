<?php
require_once 'users/init.php';
require("db.php");
require("functions.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
//require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
$msg="";
if(isset($user) && $user->isLoggedIn()){
	$loggedin = 1;
} else {
	$loggedin=0;
}
if (!securePage($_SERVER['PHP_SELF'])){die();}
if (isset($_GET["page"])) { $page=$_GET["page"]; } else { $page="index"; }
if (isset($_GET["do"])) { $do=$_GET["do"]; } else { $do="none"; }
if (!empty($_POST)) {
if ($do=="save") {
	if (isset($_GET["what"])) { $what=$_GET["what"]; } else { $what="none"; }
	
	if ($what=="profile") {
		$memberid=$user->data()->id;
		$profile=MDB::queryFirstRow("SELECT * FROM atn_cmr WHERE acctid=%i", $memberid);
		$data=$_POST;
		//print_r($data);
/*		Array ( [first] => Chris [last] => Claus [name_privacy_privacy] => s [pname] => [rname_privacy_privacy] => s [namedisp] => 1 [pronouns] => he/him 
		[phone] => 4066724043 [phone_privacy_privacy] => c [email] => chris.claus42@gmail.com [email_privacy_privacy] => s [address] => 206 4th st w 
		[address2] => Apt 2 [city] => Billings [state] => MT [zip] => 59101 [country] => USA [address_privacy_privacy] => c 
		[military] => Array ( [military] => no [branch] => [milcountry] => ) [map] => yes 
		[socialmedia] => Array ( [website] => www.awakenthenorth.org [facebook] => facebook.com/chrisclausmt [twitter] => wizardeddas [instagram] => bigskyheathen ) 
		[dob] => 1985-01-03 [dob_privacy_privacy] => s )
		*/
		$olddata=$profile;
		unset($olddata["updates"]);
		$olddata=json_encode($olddata);
		$backup=json_decode($profile["updates"], true);
		$backup[time()]=$olddata;
		$backup=json_encode($backup);
		$newdata=array();
		$newdata["first"]=$data["first"];
		$newdata["last"]=$data["last"];
		$newdata["pname"]=$data["pname"];
		$newdata["namedisp"]=$data["namedisp"];
		$newdata["pronouns"]=$data["pronouns"];
		$newdata["phone"]=$data["phone"];
		$newdata["email"]=$data["email"];
		$newdata["address"]=$data["address"];
		$newdata["address2"]=$data["address2"];
		$newdata["city"]=$data["city"];
		$newdata["state"]=$data["state"];
		$newdata["zip"]=$data["zip"];
		$newdata["country"]=$data["country"];
		$newdata["military"]=json_encode($data["military"]);
		$newdata["map"]=$data["map"];
		$newdata["socialmedia"]=json_encode($data["socialmedia"]);
		$newdata["dob"]=$data["dob"];
		$newdata["privacy"]=json_encode($data["privacy"]);
		$newdata["updates"]=$backup;
		MDB::update("atn_cmr", $newdata, "id=%i", $profile["id"]);
		$msg="<h3>Profile Updated</h3>";
	}
}
}
pgheader();
echo $msg;
echo "<br><br>";
//date, time, where, what, upload photos, ect
if ($page=="index") {
?>
<h2>AtN Member Portal</h2>
<a href="members.php?page=profile">View Your Profile</a><br>

<?
}

if ($page=="profile") {
	$memberid=$user->data()->id;
	$profile=MDB::queryFirstRow("SELECT * FROM atn_cmr WHERE acctid=%i", $memberid);
	$military=json_decode($profile["military"], true);
	$privacy=json_decode($profile["privacy"], true);
	$socialmedia=json_decode($profile["socialmedia"], true);
	?>
	<table>
	<tr><td>Username</td><td><? echo $profile["username"]; ?></td><td></td></tr>
	<tr><td>Name</td><td><? echo $profile["first"]." ".$profile["last"]; ?></td><td><? echo privacy($privacy["name_privacy"]); ?></td></tr>
	<tr><td>Preferred Name</td><td><? echo $profile["pname"]; ?></td><td><? echo privacy($privacy["rname_privacy"]); ?></td></tr>
	<tr><td>Name Display</td><td>
	<? if ($profile["namedisp"]==1) { echo "First Last"; } ?>
	<? if ($profile["namedisp"]==2) { echo "Preferred Name"; } ?>
	<? if ($profile["namedisp"]==3) { echo 'First "Preferred" Last'; } ?>

	</td><td></td></tr>
	<tr><td>Pronouns</td><td><? echo $profile["pronouns"]; ?></td><td></td></tr>
	<tr><td>Phone #</td><td><? echo $profile["phone"]; ?></td><td><? echo privacy($privacy["phone_privacy"]); ?></td></tr>
	<tr><td>Email</td><td><? echo $profile["email"]; ?></td><td><? echo privacy($privacy["email_privacy"]); ?></td></tr>
	<tr><td>Address</td><td><? echo $profile["address"]."<br>".$profile["address2"]."<br>".$profile["city"]." ".$profile["state"]." ".$profile["zip"]."<br>".$profile["country"]; ?></td><td><? echo privacy($privacy["address_privacy"]); ?></td></tr>
	<tr><td>Military Status</td><td><?
	if (strtolower($military["military"])=="no") { echo "Never Served."; }
	else {
		echo "Military Status: ".$military["military"]."<br>
		Branch: ".$military["branch"]."<br>
		Country: ".$military["milcountry"]."<br>";
	} ?></td><td></td></tr>
	<tr><td>Member Map</td><td><? echo $profile["map"]; ?></td><td></td></tr>
	<tr><td>Social Media</td><td>
	Website: <? echo $socialmedia["website"]; ?><br>
	Facebook: <? echo $socialmedia["facebook"]; ?><br>
	Twitter: <? echo $socialmedia["twitter"]; ?><br>
	Instagram: <? echo $socialmedia["instagram"]; ?><br>
	</td><td></td></tr>
	<tr><td>Birthdate</td><td><? echo date("m/d/Y", strtotime($profile["dob"])); ?></td><td><? echo privacy($privacy["dob_privacy"]); ?></td></tr>
	<tr><td>Membership Date</td><td><? echo date("m/d/Y", $profile["joined"]); ?></td><td></td></tr>
	</table>
	<a href="members.php?page=edit">Edit Profile</a><br>
	<?
	
}
if ($page=="edit") {
	$memberid=$user->data()->id;
	$profile=MDB::queryFirstRow("SELECT * FROM atn_cmr WHERE acctid=%i", $memberid);
	$military=json_decode($profile["military"], true);
	$privacy=json_decode($profile["privacy"], true);
	$socialmedia=json_decode($profile["socialmedia"], true);
	//echo "<h1>sm</h1>".$profile["socialmedia"];
	?>
	<form method="post" action="members.php?page=profile&do=save&what=profile">
	<table>
	<tr><td>Username</td><td><? echo $profile["username"]; ?></td><td></td></tr>
	<tr><td>Name</td><td><input type="text" name="first" placeholder="First" size="8" value="<? echo $profile["first"]; ?>"> <input type="text" name="last" size="8" placeholder="Last" value="<? echo $profile["last"]; ?>"></td><td><? echo priv_form("name", $privacy["name_privacy"]); ?></td></tr>
	<tr><td>Preferred Name</td><td><input type="text" name="pname" size="8" value="<? echo $profile["pname"]; ?>"></td><td><? echo priv_form("rname", $privacy["rname_privacy"]); ?></td></tr>
	<tr><td>Name Display</td><td>
	<select name="namedisp" id="namedisp">
<option value="1" <? if ($profile["namedisp"]==1) { echo "SELECTED"; } ?>>First Last</option>
<option value="2" <? if ($profile["namedisp"]==2) { echo "SELECTED"; } ?>>Preferred Name</option>
<option value="3" <? if ($profile["namedisp"]==3) { echo "SELECTED"; } ?>>First "Preferred" Last</option></select>
	</td><td></td></tr>
	<tr><td>Pronouns</td><td><input type="text" name="pronouns" size="8" value="<? echo $profile["pronouns"]; ?>"></td><td></td></tr>
	<tr><td>Phone #</td><td><input type="text" name="phone" size="10" value="<? echo $profile["phone"]; ?>"></td><td><? echo priv_form("privacy", $privacy["phone_privacy"]); ?></td></tr>
	<tr><td>Email</td><td><input type="text" name="email" size="20" value="<? echo $profile["email"]; ?>"></td><td><? echo priv_form("privacy", $privacy["email_privacy"]); ?></td></tr>
	<tr><td>Address</td><td>
	<input type="text" name="address" placeholder="Address" value="<? echo $profile["address"]; ?>">
	<input type="text" name="address2" placeholder="Apt" size="3" value="<? echo $profile["address2"]; ?>"><br>
	<input type="text" name="city" placeholder="City" size="5" value="<? echo $profile["city"]; ?>">
	<input type="text" name="state" placeholder="State" size="5" value="<? echo $profile["state"]; ?>">
	<input type="text" name="zip" placeholder="12345" size="5" value="<? echo $profile["zip"]; ?>"><br>
	<input type="text" name="country" placeholder="Country" value="<? echo $profile["country"]; ?>"><br>
	</td><td><? echo priv_form("privacy", $privacy["address_privacy"]); ?></td></tr>
	<tr><td>Military Status</td><td><?
	if (strtolower($military["military"])=="no") { 
	?>
	<select name="military[military]"><option value="no">Never Served</option><option name="current">Currently Serving</option><option value="retired">Retired/Veteran</option></select><br>
	Branch: <input type="text" name="military[branch]"><br>
	Country: <input type="text" name="military[milcountry]"><br>
	<?
	}
	else {
		echo "Military Status: ";
		//".$military["military"]."<br>
		?>
		<select name="military[military]">
		<option value="no" <? if ($military["military"]=="no") { echo "SELECTED"; }?>>Never Served</option>
		<option name="current" <? if ($military["military"]=="current") { echo "SELECTED"; }?>>Currently Serving</option>
		<option value="retired" <? if ($military["military"]=="retired") { echo "SELECTED"; }?>>Retired/Veteran</option>
		</select><br>
		<?
		echo "Branch: ";
		echo '<input type="text" name="military[branch]" value="'.$military["branch"].'"><br>';
		echo "Country: ";
		echo '<input type="text" name="military[milcountry]" value="'.$military["milcountry"].'"><br>';
	} ?></td><td></td></tr>
	<tr><td>Show on Member Map</td><td>
		<select name="map">
		<option value="no" <? if ($profile["map"]=="no") { echo "SELECTED"; }?>>No</option>
		<option value="yes" <? if ($profile["map"]=="yes") { echo "SELECTED"; }?>>Yes</option>
		</select><br>
	</td><td></td></tr>
	<tr><td>Social Media</td><td>
	Website: <input type="text" name="socialmedia[website]" placeholder="www.website.com" value="<? echo $socialmedia["website"]; ?>"><br>
	Facebook: <input type="text" name="socialmedia[facebook]" placeholder="username" value="<? echo $socialmedia["facebook"]; ?>"><br>
	Twitter: <input type="text" name="socialmedia[twitter]" placeholder="username" value="<? echo $socialmedia["twitter"]; ?>"><br>
	Instagram: <input type="text" name="socialmedia[instagram]" placeholder="username" value="<? echo $socialmedia["instagram"]; ?>"><br>
	</td><td></td></tr>
	<tr><td>Birthdate</td><td><input type="date" name="dob" <? if (!empty($profile["dob"])) { echo 'value="'.date("Y-m-d", strtotime($profile["dob"])).'"'; }?>></td><td><? echo priv_form("dob", $privacy["dob_privacy"]); ?></td></tr>
	<tr><td>Membership Date</td><td><? echo date("m/d/Y", $profile["joined"]); ?></td><td></td></tr>
	</table>
	<input type="submit" value="Save Profile"></form>
<?
}
?>