<?php

class Database {
    private static ?PDO $connection = null;

    // Get connection to database
    public static function getConnection(): PDO {
        if(self::$connection === null) {
            self::$connection = new PDO("mysql:host=localhost:3306;dbname=anime_lyrics", "root", "");
        }
        return self::$connection;
    }

    public static function queryData(): array|null {
        try {
            $statement = self::$connection->prepare("SELECT * FROM anime_lyrics");
            $statement->execute();

            if($lyrics = $statement->fetchAll(PDO::FETCH_ASSOC)) {
                // Hello programmer ^_^
            } else {
                $lyrics = null;
            }
        } finally {
            $statement->closeCursor();
        }
        return $lyrics;
    }

    public static function queryDataById(int $id): array|null {
        try {
            $statement = self::$connection->prepare("SELECT * FROM anime_lyrics WHERE id = ?");
            $statement->execute([$id]);

            if($lyrics = $statement->fetchAll(PDO::FETCH_ASSOC)) {
                // Hey there O_O
            } else {
                $lyrics = null;
            }
        } finally {
            $statement->closeCursor();
        }
        return $lyrics;
    }

    public static function queryDataBylyrics(string $lyrics): array|null {
        try {
            $statement = self::$connection->prepare("SELECT * FROM anime_lyrics WHERE lyrics LIKE :keyword");
            $statement->bindValue(":keyword", "%" . $lyrics . "%");
            $statement->execute();

            if($lyrics = $statement->fetchAll(PDO::FETCH_ASSOC)) {
                // Hey there O_O
            } else {
                $lyrics = null;
            }
        } finally {
            $statement->closeCursor();
        }
        return $lyrics;
    }

    public static function insertData() {
        if(isset($_POST["title"]) && isset($_POST["lyrics"])) {
            // Validate input
            if(trim($_POST["title"]) === "" || trim($_POST["title"]) === "") {
                $_POST["message"] = "Input can not blank";
                return;
            }

            // Check if already exist
            $statement = self::$connection->prepare("SELECT * FROM anime_lyrics WHERE title = ? AND lyrics = ?");
            $statement->execute([$_POST["title"], $_POST["lyrics"]]);

            // Insert data if not exist
            if($statement->rowCount() <= 0) {
                $statement = self::$connection->prepare("INSERT INTO anime_lyrics VALUES (null, ?, ?)");
                $statement->execute([$_POST["title"], $_POST["lyrics"]]);

                $_POST["message"] = "Lyrics success added";
            } else {
                $_POST["message"] = "Lyrics already exist";
            }
        }
    }

    public static function updateData(int $id): array|null {
        if(isset($_POST["title"]) && isset($_POST["lyrics"])) {
            // Validate input
            if(trim($_POST["title"]) === "" || trim($_POST["title"]) === "") {
                $_POST["message"] = "Input can not blank";
                return self::queryDataById($id);
            }

            // Check if already exist
            $statement = self::$connection->prepare("SELECT * FROM anime_lyrics WHERE title = ? AND lyrics = ?");
            $statement->execute([$_POST["title"], $_POST["lyrics"]]);

            // Insert data if not exist
            if($statement->rowCount() <= 0) {
                $statement = self::$connection->prepare("UPDATE anime_lyrics SET title = ?, lyrics = ? WHERE id = ?");
                $statement->execute([$_POST["title"], $_POST["lyrics"], $id]);
                
                $_POST["message"] = "Lyrics success updated";
            } else {
                $_POST["message"] = "Lyrics already exist";
            }

        }

        // Refresh lyrics
        return self::queryDataById($id);
    }

    public static function deleteData(int $id) {
        if(isset($_POST["delete"])) {
            if($_POST["delete"]) {
                $statement = self::$connection->prepare("DELETE FROM anime_lyrics WHERE id = ?");
                $statement->execute([$id]);
                
                // go to main page after deleting
                header("Location: /");
            }
        }
    }
}

?>