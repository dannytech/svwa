<?php
    if(isset($_SESSION["id"])) {
        $id = $_SESSION["id"];

        $conn = mysqli_connect("db", "svwa", "svwaissecure!", "svwa");

        $res = mysqli_query($conn, "SELECT * FROM Users WHERE id='$id'");
        if($res->num_rows > 0) {
            $row = mysqli_fetch_object($res);

            echo "Welcome, $row->username";
        }
    } else {
        header("Location: index.php?page=login");
    }
?>