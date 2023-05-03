<?php

// GitHub = Krispachi
require_once "functions.php";

Database::getConnection();
$lyrics = Database::queryData();

// Update variable lyrics on search
if(isset($_GET["lyrics"])) {
	$lyrics = Database::queryDataByLyrics($_GET["lyrics"]);

	// Remove "?lyrics=" on url when $_GET["lyrics"] is empty
	if($_GET["lyrics"] === "") {
		header("Location: " . str_replace("?lyrics=", "", $_SERVER["REQUEST_URI"]));
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lyrics</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<!-- Navigation -->
	<a href="add.php"><button>Add Lyrics</button></a>
	<button class="btn-search">Search Lyrics</button>

	<!-- Search lyrics input -->
	<form class="container disable">
		<input type="text" name="lyrics" placeholder="Search lyrics..." value="<?= $_GET["lyrics"] ?? "" ?>"><button type="sub">Go!</button>
	</form>

	<table>
		<?php if($lyrics !== null) : ?>
			<?php foreach($lyrics as $lyric) : ?>
				<tr>
					<td><a href="detail.php?lyrics=<?= $lyric["id"] ?>"><?= "Detail\n\n" ?></a><?= $lyric["lyrics"] ?></td>
				</tr>
			<?php endforeach; ?>
		<?php else : ?>
			<tr>
				<td>All Lyrics Is Gone</td>
			</tr>
		<?php endif; ?>
	</table>

	<script>
		document.querySelector(".btn-search").addEventListener("click", function() {
			document.querySelector(".container").classList.toggle("disable");
		});
	</script>
</body>
</html>