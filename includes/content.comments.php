<div class="comments-container small">
	<noscript>
		Comments rely on having JavaScript enabled. You have JavaScript disabled in your browser, so comment 
		functionality won't work.
	</noscript><br/>
	<a data-action="get" class="comment-action"><strong>Show comments</strong></a>
	<span class="separator"></span>
	<?php if(is_logged_in()) { ?>
		<a data-action="add" class="comment-action"><strong>Add a comment</strong></a>
	<?php } else { ?>
		<span class="fake-disabled-link" title="You must be logged in to comment.">Add a comment</span><br/>
		You must be logged in to comment. <a href="/login">Log in</a> or <a href="/login/signup">sign up</a>.<br/>
	<?php } ?>
	<br/>
	<span id="comment-status"></span><br/>
	<div id="add-comment-input" style="display: none;">
		<textarea id="comment-input" rows="5" cols="70"></textarea><br/><br/>
		<button id="comment-submit">Comment</button>
	</div>
	<div id="comment-container">
		
	</div>
	<div class="comment-templates" style="display:none;">
		<span id="comment-text-template">
			{{text}}
		</span>
		<span id="comment-author-template">
			Posted by {{author}}, {{date}}
		</span>
	</div>
</div>