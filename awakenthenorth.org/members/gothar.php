<?php

require_once '/home/intheexp/atn.bigskyheathen.com/members/users/init.php';
require("/home/intheexp/atn.bigskyheathen.com/members/db.php");
require("/home/intheexp/atn.bigskyheathen.com/members/functions.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
error_reporting(E_ALL);
if(isset($user) && $user->isLoggedIn()){
	$loggedin = 1;
} else {
	$loggedin=0;
}
if (!securePage($_SERVER['PHP_SELF'])){die();}
$author=$user->data()->fname." ".$user->data()->lname;

if (isset($_GET["page"])) { $page=$_GET["page"]; } else { $page="index"; }
pgheader();
echo "<br><br>";
//date, time, where, what, upload photos, ect
if ($page=="index") {
	echo '<h2>Goðar Portal</h2><br>';
	echo '<a href="gothar.php?page=csreport">Submit Community Service Report</a><br>';
	echo '<a href="gothar.php?page=view&what=cslist">View Submitted CS Reports</a><br>';
}
if ($page=="csreport") {
	echo '<h2>Submit Community Service Report</h2>';
	?>
	Use the following form to log your Community Service Hours.<br>
	You will be able to upload photos and documents, if any, on the next page.<br>
	<form method="post" action="gothar.php?page=save&what=cshours">
	<table>
	<tr><td>Event Date:</td><td><input type="date" name="date" value="<? echo date("Y-m-d", time()); ?>" max="<? echo date("Y-m-d", time()); ?>"></td></tr>
	<tr><td>Event Start:</td><td><input type="time" name="starttime" pattern="[0-9]{2}:[0-9]{2}"></td></tr>
	<tr><td>Event End:</td><td><input type="time" name="endtime" pattern="[0-9]{2}:[0-9]{2}"></td></tr>
	<tr><td>Event Location:</td><td>
	<textarea name="location"></textarea></td></tr>
	<tr><td>What you did:</td><td>
	<textarea name="what"></textarea></td></tr>
	<tr><td>Other Notes:</td><td>
	<textarea name="notes"></textarea></td></tr>
	</table>
	<input type="submit" value="Submit Report"></form>
	<?
}
if ($page=="view") {
	if (isset($_GET["what"])) { $what=$_GET["what"]; } else { //redirect("gothar.php"); 
	}
	if ($what=="cslist") {
		$list=MDB::query("SELECT * FROM atn_gothar_cshours WHERE userid=%i", $user->data()->id);
		echo "<table><tr><td>Date</td><td>Hours</td></tr>";
		foreach ($list as $row) {
			echo '</tr><td><a href="gothar.php?page=view&what=csentry&id='.$row["id"].'">'.date("m/d/y", strtotime($row["date"])).'</a></td><td>'.duration($row["total"]).'</td></tr>';
		}
		echo '</table>';
		
	}

	if ($what=="csentry") {
		if (isset($_GET["id"])) { $eid=$_GET["id"]; } else { echo "error"; exit(); }
		$entry=MDB::queryFirstRow("SELECT * FROM atn_gothar_cshours WHERE id=%i", $eid);
		if (($entry["userid"]==$user->data()->id) || hasPerm([2,3],$user->data()->id)){
			$uploads=MDB::query("SELECT * FROM atn_uploads WHERE type=%s && lid=%i", "gotharcs", $eid);
			?>
			<h2>View Community Service Entry</h2>
			<table>
			<tr><td>Report Submitted:</td><td><? echo date("m/d/y", $entry["added"]); ?></td></tr>
			<tr><td>Submitted By:</td><td><? echouser($entry["userid"]); ?></td></tr>
			<tr><td>Event Date:</td><td><? echo date("m/d/y", strtotime($entry["date"])); ?></td></tr>
			<tr><td>Start Time:</td><td><? echo date("g:i a", strtotime($entry["start"])); ?></td></tr>
			<tr><td>End Time:</td><td><? echo date("g:i a", strtotime($entry["end"])); ?></td></tr>
			<tr><td>Duration:</td><td><? echo duration($entry["total"]); ?></td></tr>
			<tr><td>Location:</td><td><? echo $entry["location"]; ?></td></tr>
			<tr><td>Type:</td><td><? echo $entry["what"]; ?></td></tr>
			<tr><td>Notes:</td><td><? echo $entry["notes"]; ?></td></tr>
			<tr><td>Files Attached:</td><td><? echo MDB::count(); ?></td></tr>
			</table>
			<?
			if ($uploads) {
				foreach ($uploads as $row) {
					echo '<a href="https://members.awakenthenorth.org/atnuploads/'.$row["filename"].'">'.$row["filename"].'</a><br>';
				}
			}
			
		}

	}
}
if ($page=="save") {
	if (isset($_GET["what"])) { $what=$_GET["what"]; } else { //redirect("gothar.php"); 
	}
	if ($what=="cshours") {
		
		if (isset($_POST["starttime"])) {
		$userid=$user->data()->id;
		$date=$_POST["date"];
		$starttime=$_POST["starttime"];
		$endtime=$_POST["endtime"];
		$location=$_POST["location"];
		$what=$_POST["what"];
		$notes=$_POST["notes"];
		$time1 = new DateTime($starttime);
		$time2 = new DateTime($endtime);
		$interval = $time1->diff($time2);
		$hours=$interval->format('%h');
		$minutes=$interval->format('%i');
		$total=($hours*60)+ $minutes;
		MDB::insert("atn_gothar_cshours", array("userid"=>$userid, "added"=>time(), "date"=>$date, "start"=>$starttime, "end"=>$endtime, "total"=>$total, "location"=>$location, "what"=>$what, "notes"=>$notes));
		$id=MDB::insertId();
		echo '<h2>Report Submitted</h2>';
		echo '<a href="gothar.php?page=view&what=csentry&id='.$id.'"><b>Click Here</b></a> to view your completed entry.<br><br>';
		?>
		<h2>Upload Photos and Documentation</h2>
		If you have photos, or filled out forms that you would like to submit, you may do so below:<br>
		<link href="includes/dropzone.css" type="text/css" rel="stylesheet" />
		<script src="includes/dropzone.min.js"></script>
		<div id="dropzone" style="width: 400px;"><form action="fup.php?type=gotharcs&id=<? echo $id; ?>&user=<? echo $userid; ?>" class="dropzone needsclick" id="demo-upload">
		<div class="dz-message needsclick">
		<button type="button" class="dz-button">Drop files here or click to upload.</button><br />
		</div>
		Acceptable File Types: 
		Images: jpg, png<br>
		Documents: pdf<br>
		Video: mp4, mov<br>
		<?
		
		} else {
			echo "Unable to save. Please try again.";
			exit();
		}
	}
}
if ($page=="upload") {
	?>
	<link href="includes/dropzone.css" type="text/css" rel="stylesheet" />
	<script src="includes/dropzone.min.js"></script>
	<div id="dropzone" style="width: 400px;"><form action="fup.php?type=gotharcs&id=5&user=<? echo $user->data()->username; ?>" class="dropzone needsclick" id="demo-upload">
	<div class="dz-message needsclick">
    <button type="button" class="dz-button">Drop files here or click to upload.</button><br />
	</div>
	<?
}
?>