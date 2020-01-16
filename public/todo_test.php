<?php
require_once("includes/db_connect.php");
?>
<head>
	<title>To-Do List - Archeage Unchained</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript">
function getDbRowIdFromString(html_attr_id) {
	var row_id_parts = html_attr_id.split("_");
	var db_row_id = row_id_parts[1];

	return db_row_id;
}
function toggleBoxSlide(box) {
	if (box.hasClass("inactive")) {
		box.removeClass("inactive");
	} else {
		box.addClass("inactive");
	}
	return true;
}
function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}
$(document).ready(function(){
	$(".todo_wrapper").sortable({
		placeholder: "sortable_placeholder",
		update: function (event, ui) {
			var data = $(this).sortable('serialize');
			data += "&mode=update_sort";
			console.log(data);
			$.ajax({
				data: data,
				type: 'POST',
				url: 'todo_process.php'

			}).done(function(e) {
				console.log(e);
			});
		}
	});
	$(".text_wrapper").click(function(e) {
		var parent_row = $(this).parents(".todo_row");
		var display_box = $(this).parent(".todo_display");
		var edit_box = parent_row.children(".todo_edit_box");
		var edit_textarea = edit_box.children("textarea");

		toggleBoxSlide(display_box);
		toggleBoxSlide(edit_box);

		var val = edit_textarea.val();

		if(val.charAt(val.length-1) != " ") {
			val += " ";
		}

		edit_textarea.focus().val("").val(val); //reset textarea to get cursor to end
	});

	$(".todo_edit_textarea").on("keypress", function (e) {
		if(e.which == 13 && !e.shiftKey) {
			$(this).blur();
		}
	});
	$(".todo_edit_textarea").on("blur",function (e) {
		var text_box = $(this);
		var new_text = text_box.val();
		var parent_row = text_box.parents(".todo_row");
		var row_id = getDbRowIdFromString(parent_row.attr("id"));

		new_text = $.trim(new_text);

		var data;
		data  = "mode=update";
		data += "&todo_edit_text="+new_text;
		data += "&row_id="+row_id;
		console.log(data);
		$.ajax({
			data: data,
			dataType: "json",
			type: 'POST',
			url: 'todo_process.php'

		}).done(function(e) {
			console.log(e);
			text_box.val(new_text);

			var display_box = parent_row.children(".todo_display");
			var display_text = display_box.find(".todo_display_text");
			var edit_box = parent_row.children(".todo_edit_box");



			display_text.html(nl2br(new_text));


			toggleBoxSlide(display_box);
			toggleBoxSlide(edit_box);
		});
	});
	$(".todo_textarea_new").keypress(function (e) {
		var text_box = $(this);
		var parent_row = text_box.parents(".todo_row");
		if(e.which == 13 && !e.shiftKey) {
			if ($.trim(text_box.val()) != "") {
				var data = "new_todo_text="+text_box.val();
				data += "&mode=new";
				console.log(data);
				$.ajax({
					data: data,
					dataType: "json",
					type: 'POST',
					url: 'todo_process.php'

				}).done(function(e) {
					text_box.blur();
					text_box.val("");
					text_box.focus();

					console.log(e);
					var new_row_id = e['new_row_id'];
					var new_todo_text = e['new_todo_text'];
					var output = "";
					output += "	<div class=\"todo_row\" id=\"tr_"+new_row_id+"\">\n";
					output += "		<div class=\"todo_display\">\n";
					output += "			<div class=\"text_wrapper\">\n";
					output += "				<span class=\"todo_display_text\">"+new_todo_text+"</span>\n";
					output += "			</div>\n";
					output += "			<div class=\"todo_buttons_wrapper\">\n";
					output += "				<div class=\"todo_button_wrapper\">\n";
					output += "					<div class=\"todo_button copy_button\">\n";
					output += "						<img src=\"images/copy_icon.png\" />\n";
					output += "					</div>\n";
					output += "				</div>\n";
					output += "				<div class=\"todo_button_wrapper\">\n";
					output += "					<div class=\"todo_button complete_button\">\n";
					output += "						<img src=\"images/confirm_icon.png\" />\n";
					output += "					</div>\n";
					output += "				</div>\n";
					output += "				<div class=\"todo_button_wrapper\">\n";
					output += "					<div class=\"todo_button delete_button\">\n";
					output += "						<img src=\"images/padlock_icon.png\" />\n";
					output += "					</div>\n";
					output += "				</div>\n";
					output += "			</div>\n";
					output += "		</div>\n";
					output += "		<div class=\"todo_edit_box inactive\">\n";
					output += "			<textarea name=\"text_"+new_row_id+"\" rows=\"3\" cols=\"40\" class=\"todo_textarea todo_edit_textarea\">"+new_todo_text+"</textarea>\n";
					output += "			<div class=\"todo_buttons_wrapper\">\n";
					output += "				<div class=\"todo_button_wrapper\">\n";
					output += "					<div class=\"todo_button copy_button\">\n";
					output += "						<img src=\"images/copy_icon.png\" />\n";
					output += "					</div>\n";
					output += "				</div>\n";
					output += "				<div class=\"todo_button_wrapper\">\n";
					output += "					<div class=\"todo_button complete_button\">\n";
					output += "						<img src=\"images/confirm_icon.png\" />\n";
					output += "					</div>\n";
					output += "				</div>\n";
					output += "				<div class=\"todo_button_wrapper\">\n";
					output += "					<div class=\"todo_button delete_button\">\n";
					output += "						<img src=\"images/padlock_icon.png\" />\n";
					output += "					</div>\n";
					output += "				</div>\n";
					output += "			</div>\n";
					output += "		</div>\n";
					output += "	</div>\n";
					$(".todo_wrapper").append(output);
					$("#new_todo_delete_button_"+new_row_id).click(function(e) {
						var parent_row = $(this).parents(".todo_row");

						var data = "mode=delete&post_id="+new_row_id;
						$.ajax({
							data: data,
							type: 'POST',
							url: 'todo_process.php'

						}).done(function(e) {
							parent_row.remove();
						});
					});
				});
			} else {
				$(this).blur();
			}
		}
	});
	$(".delete_button").click(function(e) {
		var delete_button = $(this);
		if($(this).hasClass("confirmed")) {
			var parent_row = $(this).parents(".todo_row");
			var row_id = getDbRowIdFromString(parent_row.attr("id"));

			var data = "mode=delete&post_id="+row_id;
			$.ajax({
				data: data,
				type: 'POST',
				url: 'todo_process.php'

			}).done(function(e) {
				parent_row.remove();
			});
		} else {
			$(this).addClass("confirmed");
			$(this).fadeOut(200,function() {
				$(this).html("<img src=\"images/delete_icon.png\" />").fadeIn(200);
				$(this).fadeOut(3000,function() {
					$(this).html("<img src=\"images/padlock_icon.png\" />").fadeIn(600);
					$(this).removeClass("confirmed");
				});
			});
		}
	});
});

	</script>
	<style type="text/css">
	.blackbg {
		background: black;
	}
.todo_wrapper {
	display:inline-block;
	font-size:small;
}
.form_wrapper {
	display:inline-block;
}
.form_title {
	text-align:center;
	font-size:large;
	font-weight:bold;
}
.todo_row {
	margin: 2px 0px;
    border: 1px solid black;
	width:350px;
	padding: 3px;
}
.todo_row span {
}
.todo_row input {

}
.todo_time_input {

}
.todo_row,
.sortable_placeholder {

}
.sortable_placeholder {
	border:2px dashed black;
	border-radius:3px;
	box-sizing:border-box;
	min-height:20px;
}
.text_wrapper {
	width: 200px;
    padding: 6px;
	display:flex;
}
.text_wrapper span {
}
.timer_wrapper {
	display: flex;
    flex-flow: row nowrap;
	margin: auto 0px;
}

.todo_display,
.todo_edit_box {
	display:flex;
	justify-content:space-between;
	min-height:55px;
}
.todo_button_wrapper {
    margin: auto 3px;
	border: 1px solid black;
}
.todo_button {
	display: flex;
	align-items: center;
	justify-content: center;

	width: 24px;
    height: 24px;
    line-height: 24px;
    text-align: center;
    cursor: pointer;
    font-weight: bold;
}
.delete_button:hover {
	background:red;
	color:white;
}
.complete_button:hover {
	background:green;
}
.new_todo {
}
.todo_textarea {
	resize:none;
	width:100%;
}
.todo_edit_box {

}
.inactive {
	display:none;
}
.checkbox_wrapper {

}
.checkbox_wrapper input {

}
.todo_buttons_wrapper {
	display:flex;
}
.todo_edit_textarea {
	width:100%;
}
.todo_button img {
	width: 16px;
	height: 16px;
}
	</style>
</head>
<body>
<div class="form_wrapper">
	<div class="form_title">To-Do List</div>
	<div class="todo_wrapper">
<?php
/*
$rows = Array(
	Array(
		"text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Phasellus pulvinar dui ac mauris gravida viverra nec a felis.",
		"user_id" => 1,
		"id" => 1,
		"finished" => "38438503583"
	),
	Array(
		"text" => "Craft Seed Bundles",
		"user_id" => 1,
		"id" => 2,
		"finished" => "0"
	),
	Array(
		"text" => "Send Dasserun crafting mats",
		"user_id" => 1,
		"id" => 3,
		"finished" => "0"
	)
);
*/
$user_id = 1;
$stmt = "SELECT * FROM `todo` WHERE `user_id`=:user_id ORDER BY `sort` ASC";
$query = $db->prepare($stmt);
$query->execute(Array("user_id" => $user_id));
$todo_items = $query->fetchAll();
foreach ($todo_items as $t) {
	// calculate remaining time here
	$html_text = nl2br($t['text']);
	echo <<<EOD
	<div class="todo_row" id="tr_{$t['id']}">
		<div class="todo_display">
			<div class="text_wrapper">
				<span class="todo_display_text">{$html_text}</span>
			</div>
			<div class="todo_buttons_wrapper">
				<div class="todo_button_wrapper">
					<div class="todo_button copy_button">
						<img src="images/copy_icon.png" />
					</div>
				</div>
				<div class="todo_button_wrapper">
					<div class="todo_button complete_button">
						<img src="images/confirm_icon.png" />
					</div>
				</div>
				<div class="todo_button_wrapper">
					<div class="todo_button delete_button">
						<img src="images/padlock_icon.png" />
					</div>
				</div>
			</div>
		</div>
		<div class="todo_edit_box inactive">
			<textarea name="text_{$t['id']}" rows="3" cols="40" class="todo_textarea todo_edit_textarea">{$t['text']}</textarea>
			<div class="todo_buttons_wrapper">
				<div class="todo_button_wrapper">
					<div class="todo_button copy_button">
						<img src="images/copy_icon.png" />
					</div>
				</div>
				<div class="todo_button_wrapper">
					<div class="todo_button complete_button">
						<img src="images/confirm_icon.png" />
					</div>
				</div>
				<div class="todo_button_wrapper">
					<div class="todo_button delete_button">
						<img src="images/padlock_icon.png" />
					</div>
				</div>
			</div>
		</div>
	</div>

EOD;
}
?>
	</div>
	<div class="todo_row new_todo">
		<form action="">
			<textarea name="new_todo_text" cols="24" rows="3" class="todo_textarea todo_textarea_new"></textarea>
		</form>
	</div>
</div>
</body>
