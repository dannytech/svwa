<?php
    unset($_SESSION["id"]);
    unset($_SESSION["admin"]);
    header("Location: index.php?page=login");
?>