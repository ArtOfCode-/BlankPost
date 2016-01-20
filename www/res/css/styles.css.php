<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
	header("Content-Type: text/css; charset: UTF-8");
?>

body {
	margin: 0;
	font-family: '<?php echo get_config_value("design", "body_font"); ?>';
	font-size: <?php echo get_config_value("design", "body_font_size"); ?>px;
	color: <?php echo get_config_value("design", "body_font_color"); ?>;
}

.component-left {
	width: 30%;
	height: 100%;
	min-height: 100%;
	float: left;
	background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
		url('<?php echo get_config_value("design", "left_panel_background_path"); ?>');
	position: fixed;
	color: white;
}

.component-right {
	width: 70%;
	height: 100%;
	min-height: 100%;
	float: right;
}

.container {
	width: 95%;
	height: 100%;
	margin: 20px auto;
}

.container-center {
	text-align: center;
}

.container-padded {
	width: 90%;
	padding: 50px 0;
	margin: 0 60px;
}

.component-left img {
	width: 50%;
	text-align: center;
	border-radius: 50%;
	margin: 20px 0 0 0;
}

.component-left h2 {
	font-size: 17px;
	font-weight: normal;
	font-family: '<?php echo get_config_value("design", "body_font"); ?>';
}

.internal-links {
	font-size: 15px;
}

.component-left a {
	color: white;
	text-decoration: underline;
}
.component-left a:hover {
	color: white;
	text-decoration: none;
}

.contacts a {
	text-decoration: none;
}
.contacts a:hover {
	text-decoration: none;
}

.detail img {
	display: inline-block;
	height: 26px;
	width: 26px;
	border-radius: 0;
	margin: 0 5px;
}

.component-right h1, h2, h3 {
	font-family: '<?php echo get_config_value("design", "heading_font"); ?>';
	font-size: <?php echo get_config_value("design", "heading_font_size"); ?>px;
	margin-bottom: 10px;
}

.component-right h4, h5, h6 {
	font-family: '<?php echo get_config_value("design", "heading_font"); ?>';
	font-size: <?php echo get_config_value("design", "subheading_font_size"); ?>px;
	margin-bottom: 5px;
}

.component-right blockquote {
	width: 90%;
	margin-left: auto;
	margin-right: auto;
	border-left: 4px solid <?php echo get_config_value("design", "primary_callout"); ?>;
	background: <?php echo get_config_value("design", "callout_light"); ?>;
	padding: 7px 15px;
}

.component-right img {
	display: block;
	max-width: 90%;
	max-height: 400px;
	margin-left: auto;
	margin-right: auto;
}

.component-right hr {
	width: 95%;
	border: 0;
	border-top: 1px solid #DDD;
	margin: 10px 0;
}

.component-right .post-details {
	font-size: 14px;
	color: #999;
	display: block;
	margin: 10px;
}

.component-right a {
	text-decoration: none;
	color: <?php echo get_config_value("design", "primary_callout"); ?>;
}
.component-right a:hover {
	text-decoration: underline;
	color: <?php echo get_config_value("design", "primary_callout"); ?>;
}

.center {
	text-align: center;
	padding: 5px 0;
}

.small {
	font-size: 14px;
}

.info {
	font-size: 13px;
	color: #777;
}

a.info {
	color: #777;
	text-decoration: underline;
}
a.info:hover {
	color: #777;
	text-decoration: none;
}

.error {
	color: #a55;
}

a.error {
	color: #a55;
	font-weight: bold;
	text-decoration: none;
}
a.error:hover {
	color: #a55;
	font-weight: bold;
	text-decoration: underline;
}

.bottom {
	bottom: 0;
	left: 0;
	width: 100%;
}

label {
	font-variant: small-caps;
}

input[type=text], input[type=password], input[type=email], input[type=number] {
	padding: 5px;
	border: 1px solid gray;
	background: #eee;
	border-radius: 3px;
	margin: 3px 3px 6px 3px;
	min-width: 200px;
	font-family: '<?php echo get_config_value("design", "body_font"); ?>';
}

input[disabled] {
	background: #ccc;
	color: #000;
}

button, input[type=submit] {
	background: <?php echo get_config_value("design", "primary_callout"); ?>;
	border: none;
	border-radius: 3px;
	padding: 7px 10px;
	color: white;
	margin: 3px;
	font-family: '<?php echo get_config_value("design", "body_font"); ?>';
	font-size: <?php echo get_config_value("design", "body_font_size"); ?>px;
	font-variant: small-caps;
}

input.heading-input {
	font-size: <?php echo get_config_value("design", "heading_font_size"); ?>;
	font-family: <?php echo get_config_value("design", "heading_font"); ?>;
	padding: 5px;
	background: white;
	width: 95%;
}

textarea {
	font-family: <?php echo get_config_value("design", "body_font"); ?>;
	font-size: <?php echo get_config_value("design", "body_font_size"); ?>;
	padding: 5px;
	border-radius: 3px;
}
textarea#post-body, textarea[name=config-file] {
	height: 500px;
	width: 95%;
}

table {
	width: 97.5%;
}

thead {
	background: <?php echo get_config_value("design", "primary_callout"); ?>;
	color: white;
	font-family: <?php echo get_config_value("design", "heading_font"); ?>;
	font-size: <?php echo get_config_value("design", "body_font_size"); ?>;
}

tr.even {
	background: <?php echo get_config_value("design", "emphasis_background"); ?>;
}

tr.odd:hover, tr.even:hover {
	background: <?php echo get_config_value("design", "active_background"); ?>;
}

td {
	vertical-align: center;
	text-align: center;
	padding: 10px;
}

span.separator::before {
	content: '|';
	color: #DDD;
}

noscript {
	color: #a55;
}

a.comment-action {
	opacity: 0.25;
}

span#comment-status {
	color: #a55;
}

div.comment {
	border-bottom: 1px solid #DDD;
	padding: 10px;
}

span.fake-disabled-link {
	color: gray;
	font-weight: bold;
}
