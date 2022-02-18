<?
require("db.php");

if (!isset($_GET["id"])) {
	$id=$_GET["id"];
	
	$form=MDB::queryFirstRow("atn_forms WHERE id=%i", $id);
	//id	shortcode	created	form	desc	info	status	emai
	?>
	<center><h2>Editing Form: <? echo $form["shortcode"]; ?></h2><br>
	
	
	
	
	<?
	if (!empty($form["form"])) {
		$data=json_decode($form["form"], true);
		/* Data format:
		Associative array
		[0]=>
			[field name]
			[field type] => text, textarea, checkbox, radial, select, date, dropdown, file
			[field entries]=>[one][two][three]...[nnn]
		*/
		foreach ($data as $row) {
			$name=$row["name"];
			$type=$row["type"];
			$entries=$row["entries"];
			echo '<table border="1" cellspacing="0"><tr><td>Field Name</td><td>Field Type</td><td>Field Entries</td></tr>';
			if (!in_array($type, array("text", "textarea", "date", "file"))) {
				echo '<tr><td>'.$name.'</td><td>'.$type.'</td><td>'.$entries.'</td></tr>';
			} else {
				echo '<tr><td>'.$name.'</td><td>'.$type.'</td><td>---</td></tr>';
			}
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
 * @param array      $array
 * @param int|string $position
 * @param mixed      $insert
 */
function array_insert(&$array, $position, $insert)
{
    if (is_int($position)) {
        array_splice($array, $position, 0, $insert);
    } else {
        $pos   = array_search($position, array_keys($array));
        $array = array_merge(
            array_slice($array, 0, $pos),
            $insert,
            array_slice($array, $pos)
        );
    }
}