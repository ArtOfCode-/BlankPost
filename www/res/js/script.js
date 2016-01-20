$(document).ready(function() {
	
	$("a.comment-action").attr("href", "#").css("opacity", "1");
	
	$("span.date").each(function(index, value) {
		$(value).attr("title", $(value).text())
			.text(moment($(value).text()).fromNow());
	});
	
	if(typeof(data) !== "undefined") {
		$("table.sorted").DataTable({
			data: data
		});
	}
	
	$("a.admin-action").on("click", function(e) {
		e.preventDefault();
		var confirmation = confirm("Sure? This action cannot be undone. Clicking OK will " + $(this).data("desc") + ".");
		if(confirmation) {
			$.ajax({
				type: $(this).data("request-type"),
				url: $(this).data("url"),
				data: {
					id: $(this).data("id") || -1
				},
				success: function(data) {
					if(data === "success") {
						alert("Action completed successfully.");
					}
					else {
						alert("Action failed to complete.");
					}
				},
				error: function(data) {
					alert("Action failed to complete.");
				}
			});
		}
	});
	
	$("a.comment-action").on("click", function(e) {
		e.preventDefault();
		var action = $(this).data("action");
		var baseUrl = "/posts/comments";
		if(action === "get") {
			// action.get: retrieve comments and display
			var parentId = $("div#article-container").data("post-id");
			fetchComments(baseUrl, parseInt(parentId, 10));
		}
		else if(action === "add") {
			// action.add: create a new comment and save it
			$("#add-comment-input").css("display", "block");
		}
		else {
			console.log("element = ANCHOR_ELEMENT {class = 'comment-action'}");
			console.log("element.userAction('click').action !== 'get' && element.userAction('click').action !== 'add'");
			console.error("Could not complete action: unknown action method.");
		}
	});
	
	$("button#comment-submit").on("click", function() {
		var baseUrl = "/posts/comments";
		var parentId = $("div#article-container").data("post-id");
		addComment(baseUrl, parentId);
	});
	
	function addComment(baseUrl, parentId) {
		var commentText = $("#comment-input").val();
		var request = baseUrl + "/add";
		$.post(request, {
			"text": commentText,
			"parent": parentId
		})
		.done(function(data) {
			if(data == "ok") {
				$("#comment-container").html("");
				fetchComments(baseUrl, parentId);
			}
			else {
				$("#comment-status").text("There was an error adding your comment.");
			}
			$("#comment-input").val("");
			$("#add-comment-input").css("display", "none");
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			$("#comment-status").text("There was an error adding your comment: " + jqXHR.responseText);
		});
	}
	
	function fetchComments(baseUrl, parentId) {
		var request = baseUrl + "/get";
		$.post(request, {"parent": parentId})
		.done(function(data) {
			var json;
			try {
				json = JSON.parse(data);
			}
			catch(e) {
				$("#comment-status").text("There was an error fetching comments.");
				console.error("Error fetching comments: exception thrown at JSON.parse. Exception follows.");
				console.log(e);
				json = {};		// so that the next load of processing doesn't also throw
			}
			
			if(json.length == 0) {
				$("#comment-status").text("There are no comments to display.");
				return;
			}
			
			var templates = {
				"text": $("div.comment-templates > #comment-text-template").text(),
				"author": $("div.comment-templates > #comment-author-template").text()
			};
			
			for(var i = 0; i < json.length; i++) {
				var commentContainer = $("<div></div>", {
					"class": "comment"
				});
				$("<div></div>").text(templates["text"].replace("{{text}}", json[i]["text"])).appendTo(commentContainer);
				$("<div></div>").text(templates["author"].replace("{{author}}", json[i]["author"])
					.replace("{{date}}", moment(json[i]["date"]).fromNow()))
					.attr("title", json[i]["date"])
					.addClass("post-details")
					.appendTo(commentContainer);
				$("div#comment-container").append(commentContainer);
			}
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			console.error("Error fetching comments: $.post(request) failed. Logs: request \\n jqXHR, textStatus, errorThrown.");
			console.log(request);
			console.log(jqXHR, textStatus, errorThrown);
			$("#comment-status").text("There was an error fetching comments: " + jqXHR.responseText);
		});
	}
	
});