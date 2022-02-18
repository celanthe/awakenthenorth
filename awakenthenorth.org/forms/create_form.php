<?
require("db.php");

if (!isset($_GET["page"])) {
	
	?>
	<center>
	<h1>Create New Form</h1>
	<form method="post" action="create_form.php?page=new">
	Form Name: <input type="text" name="name"><br>
	Form Short Code: <input type="text" name="shortcode"><br>
	Note: Short Code can not have any spaces, punctuation, special characters, just A-Z a-z 0-9 and underscores _<br>
	Form Description: <textarea name="desc"></textarea><br>
	Note: Form Description will be displayed above form on form entry page.</br>
	Form Info: <textarea name="info"></textarea><br>
	Note: Form Info will only be displayed on admin page.</br>
	You will be able to add form elements and email addresses to send form responses to on the next page.
	<input type="submit" value="Start New Form"></form>
	<?
	exit();
} else {
	$page=$_GET["page"];
}
if ($page=="new") {
	$name=$_POST['name'];
	$shortcode=preg_replace('/[^\w-]/', '', $_POST['shortcode']);
	$desc=$_POST['desc'];
	$info=$_POST['info'];
	$email=$_POST['email'];
	MDB::insert('atn_forms', ['shortcode'=>$shortcode, 'created'=>time(), 'desc'=>$desc, 'info'=>$info, 'status'=>0]);
	$id=MDB::insertId();
	header("Location: edit_form.php?id=".$id);
}