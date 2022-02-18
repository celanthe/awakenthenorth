<!DOCTYPE html>
<script src="js/tinymce/jquery.tinymce.min.js"></script>
<script src="js/tinymce/tinymce.min.js"></script>
	
	<form method="post" action="template.php">
	<textarea id="text" name="text"></textarea><br>
	
	<input type="submit" value="">
	<script>
tinymce.init({
  selector: 'textarea#text',
  height: 500,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | help',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});
</script>

<?
if (!empty($_POST["text"])) {
	echo '<textarea><pre>'.$_POST["text"].'</pre></textarea>';
}