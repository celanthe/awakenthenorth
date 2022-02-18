<?php
error_reporting(E_ALL);
require_once '/home/intheexp/atn.bigskyheathen.com/members/users/init.php';
require("/home/intheexp/atn.bigskyheathen.com/members/db.php");
require("/home/intheexp/atn.bigskyheathen.com/members/functions.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
if(isset($user) && $user->isLoggedIn()){
	$loggedin = 1;
} else {
	$loggedin=0;
}
if (!securePage($_SERVER['PHP_SELF'])){die();}

?>
<!DOCTYPE html>
<html>
<title>Finances</title>
	<head>
		<!-- UIkit CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/css/uikit.min.css" />
		<!-- UIkit JS -->
		<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit-icons.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
		<link rel="stylesheet" href="https://members.awakenthenorth.org/includes/datepicker.css">
		<script src="https://members.awakenthenorth.org/includes/datepicker.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
		   .error {
      color: red;
      font-weight: bold;
   }
   
   .uk-card-default {
	   background-color: F0F0F0;
   }
   </style>
<style>
	td {
		border-bottom: 1px solid black;
	}
	</style>   
			<script>


    $(function() {
      var $date = $('#date');
      

      $date.datepicker({
        autoHide: true,
		
      });
      
    });
  </script>
	</head>
<body style="background-color: 000000;">

<div class="uk-container">
<? echo navbar("main"); ?>

<div class="uk-card-default  uk-card-body">
<center><img src="<? echo SITE_URL; ?>logo2.png" width="50%"><br>
<?
if (isset($_GET["page"])) { $page=$_GET["page"]; } else { $page="index"; }
if ($page=="index") { ?>
<h2>Finances</h2><br>
To maintain transparency with our membership, below you will be able to see our finances among other things.<br>
We will track expenses, donations, merchandise sales.<Br>
We will also be tracking requests for Pocket Havamals and Pocket Altars for our military members. These are seperate from<br>
the ones sold in our stores, as they are sent to deployed service members world wide with no cost to them.<br>
This system is new, so it may take us some time to enter in everything up till now. But once we are up to date, it should be updated on a weekly basis.<br><br>

<?
error_reporting(E_ALL);
$campaigns=MDB::query("SELECT * FROM atn_tracking_campaign WHERE `status` >0");
if ($campaigns) {
echo '<table><tr><td>Campaign</td><td>Description</td></tr>';
foreach ($campaigns as $row) {
	echo "<tr><td><a href=\"finances.php?page=view&cid=".$row["id"]."\">".$row["name"]."</a></td><td>".$row["description"]."</td></tr>";
}
echo "</table>";
} else {
	echo "<b>There are currently no active campaigns to view.</b><br><br>";
}
?>

</div>

<?
}

if ($page=="view") {
	if (!isset($cid)) { if (isset($_GET["cid"])) { $cid=$_GET["cid"]; } else { echo "no cid"; exit(); } }
	$cinfo=MDB::queryFirstRow("SELECT * FROM atn_tracking_campaign WHERE id=%i", $cid);
	?>
	<h2><a href="finances.php">Back to Finances Home</a></h2>
	<h2>Campaign: <? echo $cinfo["name"]; ?></h2>
	Description: <? echo $cinfo["description"]; ?><br><br>
	<hr width="50%">
	<?
	$cats=MDB::query("SELECT * FROM atn_tracking_categories WHERE campaign = %i", $cid);
	if ($cats) {
		echo "<table width=\"75%\"><tr><td>Name</td><td>Total</td><td>Description</td></tr>";
		foreach ($cats as $row) {
			if ($row["type"] != "total") {
			$counts=MDB::query("SELECT SUM(amount) AS Total FROM atn_tracking WHERE campaign=%i AND category=%i", $row["campaign"], $row["id"]);
			if (!empty($counts[0]["Total"])) { $value[$row["id"]]=$counts[0]["Total"]; } else { $value[$row["id"]]=0; }
			$vtype[$row["id"]]=$row["type"];
			} else {
				$tot=0;
				foreach ($value as $id=>$num) {
					
					if (strtolower($vtype[$id]) == "income" || strtolower($vtype[$id])=="add") { $tot=$tot+$value[$id]; } else { $tot=$tot-$value[$id]; }
				}
				$value[$row["id"]]=$tot;
			}
			if (strtolower($vtype[$row["id"]])=="income" || strtolower($vtype[$row["id"]])=="expense") { $prefix="$"; $amount=number_format($value[$row["id"]], 2); } else { $prefix=""; $amount=$value[$row["id"]]; }
			echo "<tr><td>".$row["name"]."</td><td>".$prefix.$amount."</td><td>".$row["description"]."</td></tr>";
		}
		$caty=1;
		echo "</table>";
	} else {
		echo "This campaign does not have any items to track yet.<br>";
		$caty=0;
	}
	?>
	</center>
	<?
	

	echo "<br><br>";
	echo '<div style="align: left; margin: 0 auto; width: 50%"><h2>Entries:</h2>';
	$entries=MDB::query("SELECT * FROM atn_tracking WHERE campaign=%i ORDER BY date DESC", $cid);
	if ($entries) {
		echo "<table width=\"100%\"><tr><td>Category</td><td>Amount</td><td>Date</td><td>Note</td></tr>";
		foreach ($entries as $row) {
			$cat=MDB::queryFirstRow("SELECT * FROM atn_tracking_categories WHERE id=%i", $row["category"]);
			if (strtolower($cat["type"])=="income" || strtolower($cat["type"])=="expense") { $prefix="$"; $amount=number_format($row["amount"], 2); } else { $prefix=""; $amount=$row["amount"]; }
			echo "<tr><td>".$cat["name"]."</td><td>".$prefix.$amount."</td><td>".date("m/d/Y", $row["date"])."</td><td>".$row["description"]."</td></tr>";
		}
		echo "</table>";
	}
	echo '</div>';
}



function cstatus($id) {
	switch ($id) {
		case 0:
			$result="Inactive Campaign";
			break;
		case 1:
			$result="Active Campaign";
			break;
	}
	return $result;
}
?>
