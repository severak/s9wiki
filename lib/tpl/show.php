<!DOCTYPE html>
<html><head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/maalo.css"/>
	<title><?php echo $title; ?></title>
	<?php if (isset($author)) { echo '<meta name="author" content="' . $author . '">'; } ?>
	<?php if (isset($head)) { echo $head; } ?>
	</head><body class="reset">
<div class="inverted">
	<div class="container clearfix">
		<div class="dp33"><h1 id="title"><?php echo $title; ?></h1></div>
		<div><?php if (isset($menu)) { echo $menu; } ?></div>
	</div>
</div>
<div class="container clearfix">
<?php echo $text; ?>
</div>
<hr>
<div class="container clearfix">
<small><?php if (isset($footer)) { echo $footer; } ?></small>
</div>
</body></html> 
