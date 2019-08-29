<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SVWA Bank</title>
    </head>
    <body>
        <?php
            $page = $_GET["page"];
            $flags = [];
            
            if ($page == null) header("Location: index.php?page=login");

            $conn = new PDO("mysql:host=db;dbname=svwa", "svwa", "svwaissecure!");

            header("X-XSS-Protection: 0");
            include "pages/$page.php"; // VULNERABILITY: Local File Inclusion

            // Scores all the newly set flags
            foreach($flags as $flag) {
                $stmt = $conn->prepare("SELECT * FROM Flags WHERE id=:id;");
                $stmt->execute([ ":id" => $flag["id"] ]);

                if($stmt->rowCount() == 0) {
                    $stmt = $conn->prepare("INSERT INTO Flags VALUE (:id, :flag, :points);");
                    $stmt->execute([ ":id" => $flag["id"], ":flag" => $flag["flag"], ":points" => $flag["points"] ]);

                    $score = 0;

                    $stmt = $conn->prepare("SELECT * FROM Flags");
                    $stmt->execute();
                    while($currentFlag = $stmt->fetch()) {
                        $score += $currentFlag["points"];
                    }

                    echo "<script>alert('" . $flag["flag"] . ": " . $flag["points"] . " points.')</script>";
                }
            }

            $conn = null;
        ?>
    </body>
</html>