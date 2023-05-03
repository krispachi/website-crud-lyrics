<?php

// Message when lyrics not found
if(!isset($_GET["lyrics"])) {
	echo "<p style='margin: 4em 2em 0 4em; display: inline-block'>Which lyrics sir?</p><a href='/' style='display: inline-block; text-decoration: none; color: steelblue'>List Lyrics</a>";
	exit();
}

require_once "functions.php";

Database::getConnection();
$lyrics = Database::queryDataById($_GET["lyrics"]);

// Refresh lyrics
$lyrics = Database::updateData($lyrics[0]["id"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<!-- Navigation -->
	<a href="/"><button>List Lyrics</button></a>
	<!-- Hide button detail if lyrics not found -->
	<?php if($lyrics !== null) : ?>
		<a href="detail.php?lyrics=<?= $lyrics[0]["id"] ?>"><button>Detail Lyrics</button></a>
	<?php endif; ?>

	<!-- Update data message -->
	<?php if(isset($_POST["message"])) : ?>
		<div class="message"><?= $_POST["message"] ?> (Click to dismiss)</div>
	<?php endif; ?>

	<form method="post">
		<div>
			<label for="title">Title</label>
			<input type="text" id="title" name="title" value="<?= $lyrics[0]["title"] ?? "" ?>">
		</div>
		<div>
			<label for="lyrics">Lyrics</label>
			<textarea rows="28" id="lyrics" name="lyrics"><?= $lyrics[0]["lyrics"] ?? "" ?></textarea>
		</div>
		<div class="btn-submit">
			<button class="btn-update" type="submit">Update Lyrics</button>
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