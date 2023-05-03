<?php

require_once "functions.php";

Database::getConnection();
Database::insertData();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<!-- Navigation -->
	<a href="/"><button>List Lyrics</button></a>

	<!-- Insert data message -->
	<?php if(isset($_POST["message"])) : ?>
		<div class="message"><?= $_POST["message"] ?> (Click to dismiss)</div>
	<?php endif; ?>

	<form method="post">
		<div>
			<label for="title">Title</label>
			<input type="text" id="title" name="title" autofocus>
		</div>
		<div>
			<label for="lyrics">Lyrics</label>
			<textarea rows="28" id="lyrics" name="lyrics"></textarea>
		</div>
		<div class="btn-submit">
			<button type="submit">Insert Lyrics</button>
		</div>
	</form>

	<script>
		// Dismiss message
		document.querySelector(".message").addEventListener("click", function() {
			this.style.display = "none";
		});
	</script>
</body>
</html>