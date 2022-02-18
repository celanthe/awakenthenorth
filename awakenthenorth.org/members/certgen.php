
<?
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
require("/home/intheexp/atn.bigskyheathen.com/members/db.php");
if (isset($_GET["id"])) { $id=$_GET["id"]; } else { exit(); }
$member=MDB::queryFirstRow("SELECT * FROM atn_cmr WHERE id=%i", $id);
if (isset($member["pname"])) {
if ($member["namedisp"]==1) { $name=$member["first"]." ".$member["last"]; }
if ($member["namedisp"]==2) { $name=$member["pname"]; }
if ($member["namedisp"]==3) { $name=$member["first"]." \"".$member["pname"]."\" ".$member["last"]; }
} else {
$name=$member["first"]." ".$member["last"];
}
$name="Your Name Here";
$id="Member Number";
use \setasign\Fpdi\Fpdi;
$pdf = new Fpdi;

$pdf->AddPage("L");
$pdf->setSourceFile('/home/intheexp/atn.bigskyheathen.com/members/membercerttemp.pdf');

// We import only page 1
$tpl = $pdf->importPage(1);

// Let's use it as a template from top-left corner to full width and height
$pdf->useTemplate($tpl, 0, 0, null, null);
$namesize=50;
$numbersize=30;
// Set font and color
$pdf->AddFont('Playball-Regular','','Playball-Regular.php');
$pdf->SetFont('Playball-Regular', '', $namesize); // Font Name, Font Style (eg. 'B' for Bold), Font Size
$pdf->SetTextColor(0, 0, 0); // RGB

// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
$pdf->SetXY(0, 139.7-($namesize/2));

// Add text cell that has full page width and height of our font
$pdf->Cell(279.4, 30, $name, 0, 2, 'C');

$pdf->SetXY(50, 159.7-($numbersize/2));
$pdf->SetFont('Playball-Regular', '', $numbersize); // Font Name, Font Style (eg. 'B' for Bold), Font Size
// Add text cell that has full page width and height of our font
$pdf->Cell(279.4, 30, '#'.$id, 0, 2, 'L');


// Output our new pdf into a file
// F = Write local file
// I = Send to standard output (browser)
// D = Download file
// S = Return PDF as a string
$pdf->Output('new-file.pdf', 'I');

?>