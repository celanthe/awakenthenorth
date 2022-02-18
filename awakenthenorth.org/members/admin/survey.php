<?
header('Content-Type: text/html; charset=ISO-8859-1');
require("/home/intheexp/atn.bigskyheathen.com/members/db.php");
error_reporting(E_ALL);
$entries=MDB::query("SELECT * FROM wp_mlw_results");
$totals=array();
$questions=array();
foreach ($entries as $entry) {
//	echo "Name: ".$entry["name"]."<br>";
	//$data = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $entry["quiz_results"]);
$fixed_data = preg_replace_callback ( '!s:(\d+):"(.*?)";!', function($match) {      
    return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
},$entry["quiz_results"] );
	$data=unserialize($fixed_data);
	$data=$data[1];
	foreach ($data as $q) {
		//print_r($q);
		$totals[$q["id"]][]=$q[1];
		$questions[$q["id"]]=$q["question_title"];
	}
	
}
//echo "<pre>";
//print_r($totals);
?>
<style>
td {
	border-bottom: 1px solid black;
}
</style>

<?
foreach ($totals as $id=>$info) {
	echo "<br><br><b>Question:</b> ".$questions[$id]."<br>";
	echo "<pre>";
	
	$counteddata=array_count_values($info);
	echo "<table>";
	echo "<tr><td>Answer text:</td><td>Times answered:</td></tr>";
	foreach ($counteddata as $ans=>$tot) {
			
			if (empty($ans)) { $ans="No Answer"; }
			echo "<tr><Td>".wordwrap($ans,40,"<br>")."</td><td><center>".$tot."</center></td></tr>";
			
	}
	echo "</table>";
}