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
            
            if ($page == null) header("Location: index.php?page=login");

            $conn = new PDO("mysql:host=db;dbname=svwa", "svwa", "svwaissecure!");

            header("X-XSS-Protection: 0");
            include "pages/$page.php"; // VULNERABILITY: Local File Inclusion

            $conn = null;
        ?>
    </body>
</html>