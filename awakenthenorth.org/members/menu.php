<?
require("db.php");
$menu=$_GET["menu"];
$data=MDB::query("SELECT * FROM atn_menu WHERE menu = %s AND type=1 ORDER BY 'order' ASC", $menu);

echo '<table border="1">
<tr><td>ID</td><td>Name</td><td>Link</td><td>Logged In</td><td>Perm</td><td>Order</td><td>Add Child</td></tr>';
foreach ($data as $row) {
	echo '<tr><td><a href="menu.php?menu='.$menu.'&do=edit&item='.$row["id"].'">'.$row["id"].'</a></td><td>'.$row["name"].'</td><td>'.$row["link"].'</td><td>'.$row["loggedin"].'</td><td>'.$row["minlevel"].'</td><td>'.$row["order"].'</td><td><a href="menu.php?menu='.$menu.'&do=addchild&item='.$row["id"].'">Add Child</a></td></tr>';
}