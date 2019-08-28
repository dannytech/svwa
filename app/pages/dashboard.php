<?php
    if(isset($_SESSION["id"])) {
        $id = $_SESSION["id"];

        $stmt = $conn->prepare("SELECT * FROM Users WHERE id=:id");
        $stmt->execute([ ":id" => $id ]);

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch();

            echo "Welcome, " . htmlspecialentities($row["username"]);
        }
    } else {
        header("Location: index.php?page=login");
    }
?>