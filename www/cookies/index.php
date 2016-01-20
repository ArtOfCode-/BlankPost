<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/../includes/base.php");
?>
<!DOCTYPE html>
<html>
<head>
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.head.php"); ?>
	<title><?php echo get_config_value("site", "title"); ?></title>
</head>
<body>
	<div class="component-left">
		<div class="container container-center">
			<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.sidebar_left.php"); ?>
		</div>
	</div>
	<div class="component-right">
		<div class="container container-padded">
			<h3>Cookie Information</h3>
			<p>This site uses cookies for a number of purposes. These cookies are both from this site and from third-party sites.<M/p>
			<h4>The important bit</h4>
			<p>I'm committed to privacy; I wouldn't do anything to you that I'm not willing to do to myself. The cookies this site stores do not and can not identify you personally, and the contents of cookies is considered private information and is not released to third parties (except where those third parties set the cookies; see below).</p>
			<h4>What are cookies?</h4>
			<p>Cookies are essentially small text files that are stored on your computer. They store data which can then be accessed by this website next time you visit.</p>
			<h4>What cookies does this site set?</h4>
			<p>This site sets a number of cookies. Whenever you visit, if you haven't visited before, the following cookies are set:</p>
			<ul>
				<li>Two Google Analytics cookies. These are used to report the fact that you visited the site to Google Analytics. This provides me with information about how many people are using the site. <strong>They can not personally identify you.</strong></li>
				<li>One third-party cookie, set by a website that this site uses to deliver content to you. It's used to identify this website to their servers, and does not identify you.</li>
			</ul>
			<p>If you create an account on the site and log into it, these cookies are set:</p>
			<ul>
				<li>One cookie, used by the software that runs the website, to identify your user account to your computer. This cookie helps prevent other people from hijacking your account. Again, it does not identify you personally.</li>
			</ul>
			<h4>How can you opt out of cookies?</h4>
			<p>None of the cookies set by this site are harmful or invade your privacy. However, if you want to disable cookies, you should do so from within your browser settings. There's a list of ways to do this for each different browser <a href="http://files.investis.com/info/disabling-cookies.html">on this page</a>.</p>
		</div>
	</div>
	
	<?php include($_SERVER["DOCUMENT_ROOT"] . "/../includes/content.resources.php"); ?>
</body>
</html>