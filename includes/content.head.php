<?php
	require_once("base.php");
?>
<meta charset="utf8" />
<meta name="description" content="<?php echo get_config_value("site", "title") . " — " . get_config_value("site", "description"); ?>" />
<meta name="author" content="ArtOfCode" />
<link rel="stylesheet" type="text/css" href="<?php echo get_config_value("design", "fonts_url"); ?>" />
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="/res/css/styles.css.php" />
<link rel="shortcut icon" type="image/ico" href="<?php echo get_config_value("site", "favicon_path"); ?>" />