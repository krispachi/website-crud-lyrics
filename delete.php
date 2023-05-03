<?php

// Message when lyrics not found
if(!isset($_GET["lyrics"])) {
	echo "<p style='margin: 4em 2em 0 4em; display: inline-block'>Which lyrics sir?</p><a href='/' style='display: inline-block; text-decoration: none; color: steelblue'>List Lyrics</a>";
	exit();
}

require_once "functions.php";

Database::getConnection();
$lyrics = Database::queryDataById($_GET["lyrics"]);
Database::deleteData($_GET["lyrics"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<!-- Navigation -->
	<a href="/"><button>List Lyrics</button></a>
    <!-- Hide button detail if lyrics not found -->
	<?php if($lyrics !== null) : ?>
	    <a href="detail.php?lyrics=<?= $lyrics[0]["id"] ?>"><button>Detail Lyrics</button></a>
    <?php endif; ?>

	<h3>Confirmation Detele</h3>
    <div class="confirmation-container">
        <form method="post">
            <input type="hidden" name="delete" value="yes">
            <button type="submit">Yes</button>
        </form>
        <a href="detail.php?lyrics=<?= $lyrics[0]["id"] ?>"><button>No</button></a>
    </div>
</body>
</html>