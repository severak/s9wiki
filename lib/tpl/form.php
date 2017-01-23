<?php
if (count($messages)) {
	echo '<ul>';
	foreach ($messages as $msg) {
		echo '<li>' . $msg . '</li>';
	}
	echo '</ul>';
}
?>

<form method="POST">
<textarea name="text" cols="80" rows="25">
<?php echo $text; ?>
</textarea><br/>
<input type="hidden" name="act" value="edit">
page: <input name="page" value="<?php echo $page; ?>"><br/>
commit message: <input name="msg"><br/>
pass: <input name="pass" type="password"><br/>
<input type="submit" name="save" value="Uložit"> <input type="submit" name="prev" value="Náhled"><br/>
</form>
<?php
if (isset($preview)) {
	echo '<hr/><div id="preview">' . $preview . '</div>';
}
?>