<?php

// Message when lyrics not found
if(!isset($_GET["lyrics"])) {
	echo "<p style='margin: 4em 2em 0 4em; display: inline-block'>Which lyrics sir?</p><a href='/' style='display: inline-block; text-decoration: none; color: steelblue'>List Lyrics</a>";
	exit();
}

require_once "functions.php";

Database::getConnection();
$lyrics = Database::queryDataById($_GET["lyrics"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
	<a href="/"><button>List Lyrics</button></a>
    <!-- Hide button edit and delete if lyrics not found -->
    <?php if($lyrics !== null) : ?>
        <a href="edit.php?lyrics=<?= $lyrics[0]["id"] ?>"><button>Edit Lyrics</button></a>
        <a href="delete.php?lyrics=<?= $lyrics[0]["id"] ?>"><button>Delete Lyrics</button></a>
    <?php endif; ?>

    <!-- Detail lyrics -->
    <?php if($lyrics !== null) : ?>
        <?php foreach($lyrics as $lyric) : ?>
            <h3><?= $lyric["title"] ?></h3>
            <p class="lyrics"><?= $lyric["lyrics"] ?></p>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Lyrics Not Found</p>
    <?php endif; ?>
</body>
</html>