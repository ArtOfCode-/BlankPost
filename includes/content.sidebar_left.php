<?php
	require_once("base.php");
?>
<a href="/"><img src="<?php echo get_config_value("site", "avatar_path"); ?>" /></a>
<h1><?php echo get_config_value("site", "title"); ?></h1>
<h2><?php echo get_config_value("site", "description"); ?></h2>
<p class="detail internal-links">
	<a href="/contact">contact</a> &bull; <a href="/posts">posts</a>
</p>
<p class="detail contacts">
    <?php if(get_config_value("links", "email")) { ?>
        <a href="mailto:<?php echo get_config_value("links", "email"); ?>" title="email">
            <img src="/res/images/mail.png" />
        </a>
    <?php } ?>
    <?php if(get_config_value("links", "stack")) { ?>
        <a href="<?php echo get_config_value("links", "stack"); ?>" title="Stack Exchange" target="_blank">
            <img src="/res/images/stack.png" />
        </a>
    <?php } ?>
    <?php if(get_config_value("links", "github")) { ?>
        <a href="<?php echo get_config_value("links", "github"); ?>" title="GitHub" target="_blank">
            <img src="/res/images/github.png" />
        </a>
    <?php } ?>
    <?php if(get_config_value("links", "fb")) { ?>
        <a href="<?php echo get_config_value("links", "fb"); ?>" title="Facebook" target="_blank">
            <img src="/res/images/fb.png" />
        </a>
    <?php } ?>
    <?php if(get_config_value("links", "twitter")) { ?>
        <a href="<?php echo get_config_value("links", "twitter"); ?>" title="Twitter" target="_blank">
            <img src="/res/images/twitter.png" />
        </a>
    <?php } ?>
</p>
<?php
	if(is_logged_in()) {
		?>
		<div class="small bottom">
			Logged in as <?php echo $_SESSION["UserName"]; ?> - <a href="/account">Manage</a> - <a href="/login/logout">Log Out</a>
			<?php if(is_admin_user()) { ?>
			 - <a href="/admin">Admin Control</a>
			<?php } ?>
		</div>
		<?php
	}
	else {
		?>
		<div class="small bottom">
			<a href="/login">Login</a>
		</div>
		<?php
	}
?>
<br/><br/>
<span class="info">This site uses cookies &mdash; <a href="/cookies" class="info">more info</a></span>