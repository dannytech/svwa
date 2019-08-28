<?php
    if(isset($_SESSION["id"])) {
        header("Location: index.php?page=dashboard");
    }

    // Check the credentials
    if(isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $conn = mysqli_connect("db", "svwa", "svwaissecure!", "svwa");

        $res = mysqli_query($conn, "SELECT id, passhash, salt FROM Users WHERE username='$username' UNION SELECT id, passhash, salt FROM Users"); // VULNERABILITY: SQLi without Login Bypass

        if($res->num_rows > 0) {
            $row = mysqli_fetch_object($res);

            $hash = md5($password . $row->salt); // VULNERABILITY: MD5 hashing

            if($hash == $row->passhash) {
                $_SESSION["id"] = $row->id;
                if(isset($_POST["admin"])) {
                    $_SESSION["admin"] = $_POST["admin"];
                } else {
                    $_SESSION["admin"] = false;
                }

                header("Location: index.php?page=dashboard");
            } else {
                echo "<div>Your password is incorrect!</div>";
            }
        } else {
            echo "<div>That user doesn't exist!</div>"; // VULNERABILITY: User enumeration
        }
    }
?>

<form action="index.php?page=login" method="POST">
    <div>
        <input type="text" placeholder="Username" name="username" required /> <?php // VULNERABILITY: Client-side validation only ?>
    </div>

    <div>
        <input type="password" placeholder="Password" name="password" required />
    </div>

    <input type="checkbox" style="display: none;" name="admin" /> <?php // VULNERABILITY: Hidden form field ?>

    <input type="submit" />
</form>
<a href="index.php?page=register">Register</a>