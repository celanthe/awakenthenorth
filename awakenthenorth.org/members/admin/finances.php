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
$author=$user->data()->fname." ".$user->data()->lname;

if (isset($_GET["page"])) { $page=$_GET["page"]; } else { $page="index"; }
if ($page=="create") {
if (isset($_GET["type"])) { $type=$_GET["type"]; } else { $type=""; }

if ($type=="campaign") {
	$name=$_POST["name"];
	$description=$_POST["description"];
	$ftype=$_POST["ftype"];
	MDB::insert("atn_tracking_campaign", array("name"=>$name, "description"=>$description, "status"=>0, "type"=>$ftype));
	$cid=MDB::insertId();
	$page="view";
}
if ($type=="category") {
	if (!isset($cid)) { if (isset($_GET["cid"])) { $cid=$_GET["cid"]; } else { echo "no cid"; exit(); } }
	$name=$_POST["name"];
	$description=$_POST["description"];
	$ftype=$_POST["ftype"];
	if ($ftype=="total") {
	$values=$_POST["values"];
	$values = str_replace(" ", "", $values);
	$val=explode(";", $values);
	$values=json_encode($val);
	} else {
		$values="";
	}
	$code=strtolower($name);
	$code=preg_replace("/[^A-Za-z0-9]/", "", $code);
	$code = str_replace(" ", "", $code);
	$code=substr($code, 0, 8);
	$code=$code.substr(time(), -3);


	MDB::insert("atn_tracking_categories", array("code"=>$code, "campaign"=>$cid, "name"=>$name, "description"=>$description, "type"=>$ftype, "values"=>$values));
	echo "category added";
	$page="view";
	$cid=$_GET["cid"]=MDB::insertId();
}	

if ($type=="add") {
	error_reporting(E_ALL);
	if (!isset($cid)) { if (isset($_GET["cid"])) { $cid=$_GET["cid"]; } else { echo "no cid"; exit(); } }
	$category=$_POST["category"];
	$description=$_POST["description"];
	$amount=$_POST["amount"];
	$date=$_POST["date"];
	if (!empty($date)) {
		$date=strtotime($date);
	} else { 
		$date=time();
	}
	echo "Adding";
	MDB::insert("atn_tracking", array("campaign"=>$cid, "category"=>$category, "amount"=>$amount, "description"=>$description, "date"=>$date));
	$page="view";
	
}
}
?>
<!DOCTYPE html>
<html>
<title>Finances Administration</title>
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
if ($page=="index") { ?>
<h2>Financial Administration</h2><br>

<?
error_reporting(E_ALL);
$campaigns=MDB::query("SELECT * FROM atn_tracking_campaign");
if ($campaigns) {
echo '<table><tr><td>Campaign</td><td>Status</td><td>Description</td></tr>';
foreach ($campaigns as $row) {
	echo "<tr><td><a href=\"finances.php?page=view&cid=".$row["id"]."\">".$row["name"]."</a></td><td>".cstatus($row["status"])."</td><td>".$row["description"]."</td></tr>";
}
echo "</table>";
} else {
	echo "<b>There are currently no campaigns.</b><br><br>";
}
?>
<a href="finances.php?page=addcampaign">Add Tracking Campaign</a><br>
</div>

<?
}
if ($page=="edit") {
	//page=edit&type=entry&id=".$row["id"].
	if (isset($_GET["type"])) { $type=$_GET["type"]; } else { echo "No Type"; exit(); }
	
	if ($type=="entry") {
		if (isset($_GET["id"])) { $id=$_GET["id"]; } else { echo "No Id"; exit(); }
		$data=MDB::queryFirstRow("SELECT * FROM atn_tracking WHERE id=%i", $id);
		$campaign=MDB::queryFirstRow("SELECT * FROM atn_tracking_campaign WHERE id=%i", $data["campaign"]);
		$category=MDB::queryFirstRow("SELECT * FROM atn_tracking_categories WHERE id=%i", $data["category"]);
		echo '<a href="finances.php?page=view&cid='.$data["campaign"].'">Return to Campaign.</a><br><br>';
		echo 'Campaign: '.$campaign["name"].'<br>
		Category: '.$category["name"].'<br>
		Date Added: '.date("m/d/Y", $data["date"]).'<br>';
		?>
		<form method="post" action="finances.php?page=save&type=entry&id=<? echo $id; ?>&redir=<? echo base64_encode("finances.php?page=edit&type=entry&id=".$id); ?>">
		Amount: <input type="text" name="amount" value="<? echo $data["amount"]; ?>"><br>
		Description: <input type="text" name="description" value="<? echo $data["description"]; ?>"><br>
		<input type="submit" value="Save Update"></form><br><br>
		<a href="finances.php?page=delete&type=entry&id=<? echo $id; ?>&redir=<? echo base64_encode("finances.php?page=view&cid=".$data["campaign"]); ?>"">Delete Entry</a>
		
		<?
	}
	if ($type=="cstatus") {
		if (isset($_GET["do"]) && isset($_GET["cid"])) {
		$do=$_GET["do"];
		$cid=$_GET["cid"];
		
		if ($do=="activate") { MDB::update("atn_tracking_campaign", array("status"=>1), "id=%i", $cid); }
		if ($do=="deactivate") { MDB::update("atn_tracking_campaign", array("status"=>0), "id=%i", $cid); }
		}
		echo '<meta http-equiv="refresh" content="0;url=finances.php?page=view&cid='.$cid.'" />';
	}
	
}
if ($page=="delete") {
	if (isset($_GET["type"])) { $type=$_GET["type"]; }
	if (isset($_GET["id"])) { $id=$_GET["id"]; } else { $type=""; }
	$redir=base64_decode($_GET["redir"]);
	if ($type=="entry") {
		MDB::delete("atn_tracking", "id=%i", $id);
		echo "Entry Deleted. Redirecting...";
		echo '<meta http-equiv="refresh" content="1;url='.$redir.'" />';
	} else {
		echo "Entry Not Found. Redirecting...";
		echo '<meta http-equiv="refresh" content="1;url='.$redir.'" />';
	}
}
if ($page=="save") {
	if (isset($_GET["type"])) { $type=$_GET["type"]; }
	if (isset($_GET["id"])) { $id=$_GET["id"]; } else { $type=""; }
	$redir=base64_decode($_GET["redir"]);
	if ($type=="entry") {
		$amount=$_POST["amount"];
		$description=$_POST["description"];
		MDB::update("atn_tracking", array("amount"=>$amount, "description"=>$description), "id=%i", $id);
		echo "Update Saved. Redirecting...";
		echo '<meta http-equiv="refresh" content="1;url='.$redir.'" />';
	}

	
}
if ($page=="view") {
	if (!isset($cid)) { if (isset($_GET["cid"])) { $cid=$_GET["cid"]; } else { echo "no cid"; exit(); } }
	$cinfo=MDB::queryFirstRow("SELECT * FROM atn_tracking_campaign WHERE id=%i", $cid);
	?>
	<h2><a href="finances.php">Back to Tracking Home</a></h2>
	<h2>Campaign: <? echo $cinfo["name"]; ?></h2>
	Description: <? echo $cinfo["description"]; ?><br><br>
	Status: <b><? echo cstatus($cinfo["status"]); ?></b><Br>
	<?
	if ($cinfo["status"]==0) {
		echo '<a href="finances.php?page=edit&type=cstatus&do=activate&cid='.$cid.'">Activate Campaign</a><br><br>';
	} else {
		echo '<a href="finances.php?page=edit&type=cstatus&do=deactivate&cid='.$cid.'">Deactivate Campaign</a><br><br>';
	}
	?>
	<hr width="50%">
	<?
	$cats=MDB::query("SELECT * FROM atn_tracking_categories WHERE campaign = %i", $cid);
	if ($cats) {
		echo "<table><tr><td>Name</td><td>Type</td><td>Value</td><td>Description</td></tr>";
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
			echo "<tr><td>".$row["name"]."</td><td>".$row["type"]."</td><td>".$value[$row["id"]]."</td><td>".$row["description"]."</td></tr>";
		}
		$caty=1;
		echo "</table>";
	} else {
		echo "This campaign does not have any items to track.<br>";
		$caty=0;
	}
	?>
	<a href="finances.php?page=addtrack&cid=<? echo $cid; ?>">Add tracking category</a><br><br><Br>
	</center>
	<?
	
	if ($caty=="1") {
		?><div style="align: left; margin: 0 auto; width: 50%">
		<form method="post" action="finances.php?page=create&type=add&cid=<? echo $cid; ?>">
		<b><?
		if ($cinfo["type"]=="1") { echo "This campaign tracks finances, so only enter dollar amounts."; }
		if ($cinfo["type"]=="2") { echo "This campaign tracks quantites, so only enter numerical amounts."; }
		?></b><br>
		Tracking Category: <select name="category"><? foreach ($cats as $row) { if ($row["type"] != "total") { echo '<option value="'.$row["id"].'">'.$row["name"].'</option>'; } } ?></select><br>
		Amount: <input type="text" name="amount" size="5"> <br>
		Note: <input type="text" name="description"><br>
		Date: <input type="text" value="<? echo date("m/d/Y", time()); ?>" name="date" id="date"><br>
		<input type="submit" value="Save"></form>
		</div>


		<?
		
	}
	echo "<br><br>";
	echo '<div style="align: left; margin: 0 auto; width: 50%"><h2>Entries:</h2>';
	$entries=MDB::query("SELECT * FROM atn_tracking WHERE campaign=%i ORDER BY date DESC", $cid);
	if ($entries) {
		echo "<table><tr><td>Category</td><td>Amount</td><td>Date</td><td>Note</td><td></td></tr>";
		foreach ($entries as $row) {
			$cat=MDB::queryFirstRow("SELECT * FROM atn_tracking_categories WHERE id=%i", $row["category"]);
			echo "<tr><td>".$cat["name"]."</td><td>".$row["amount"]."</td><td>".date("m/d/Y", $row["date"])."</td><td>".$row["description"]."</td><td><a href=\"finances.php?page=edit&type=entry&id=".$row["id"]."\">Edit</a></td></tr>";
		}
		echo "</table>";
	}
	echo '</div>';
}
if ($page=="addtrack") {
	if (!isset($cid)) { if (isset($_GET["cid"])) { $cid=$_GET["cid"]; } else { echo "no cid"; exit(); } }
	$campaign=MDB::queryFirstRow("SELECT * FROM atn_tracking_campaign WHERE id=%i", $cid);
	echo "<h2>Campaign: ".$campaign["name"]."</h2><br>
	Current Tracking Categories for this Campaign:<br>
	<table>
	<tr><td>Identifier</td><td>Name</td><td>Description</td><td>Type</td><td>Values</td></tr>";
	$categories=MDB::query("SELECT * FROM atn_tracking_categories where campaign=%i", $cid);
	if ($categories) {
		foreach ($categories as $row) {
			echo '<tr><td>'.$row["code"].'</td><td>'.$row["name"].'</td><td>'.$row["description"].'</td><td>'.$row["type"].'</td><td>'.$values.'</td></tr>';
		}
		echo '</table>';
	} else {
		echo '</table>There are no categories set up yet.<Br>';
	}
	?>
	<form method="post" action="finances.php?page=create&type=category&cid=<? echo $cid; ?>">
	Name: <input type="text" name="name"><br>
	Description: <input type="text" name="description"><br>
	Tracking Type: 
	<?
	if ($campaign["type"]==1) {
		echo '<select name="ftype"><option name="income">Income</option><option value="expense">Expense</option><option value="total">Total</option></select><br>';
	} else if ($campaign["type"]==2) {
		echo '<select name="ftype"><option name="add">Add</option><option value="subtract">Subtract</option><option value="total">Total</option></select><br>';
		echo "This campaign is to track numerical totals. Example, number of members, attendees to an event, number of pocket alter requests.<br>
		Usually, you'll want two entires for each item. For example: Altar requests recieved, Altar requests fulfilled.";
	}
	echo 'If you want to compute totals, ie number of altar requests fulfilled subtracted from requests received, or income from donations, sales, membership, minus expenses, select total as the type above, then enter the
	identifiers of the rows you want to include, seperated by a semicolon in the field below.<br>
	Total Fields: <input type="text" name="values" placeholder="identifier1;identifier2;identifier3"><br>';
	echo '<input type="submit" value="Add Category"></form>';
}
if ($page=="addcampaign") {
?>
<h2>Add Tracking Campaign</h2><br>
<form method="post" action="finances.php?page=create&type=campaign">
Campaign Name: <input type="text" name="name"><br>
Description: <input type="text" name="description"><br>
Type: <select name="ftype"><option value="1">Financial</option><option value="2">Quantity</option></select><br>
<input type="submit" value="Create Campaign"></form>
<?	
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
