<!DOCTYPE html>
<html>
    <head>
        <title>SVWA Bank</title>
    </head>
    <body>
        <?php
            session_start();
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // VULNERABILITY: Excessive logging

            $page = $_GET["page"];

            if ($page == null) header("Location: index.php?page=login");

            include "pages/$page.php"; // VULNERABILITY: Local File Inclusion
        ?>
    </body>
</html>