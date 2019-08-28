<?php
    if(isset($_SESSION["id"])) {
        header("Location: index.php?page=dashboard");
    }

    // Check the credentials
    if(isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $conn = mysqli_connect("db", "svwa", "svwaissecure!", "svwa");
        
        $res = mysqli_query($conn, "SELECT * FROM Users WHERE username='$username'");
        if($res->num_rows > 0) {
            echo "<div>User '$username' already exists</div>"; // VULNERABILITY: User enumeration, XSS
        } else {
            $salt = substr(md5(rand()), 0, 4);
            $hash = md5($password . $salt);
            $res = mysqli_query($conn, "INSERT INTO Users (username, passhash, salt) VALUES ('$username', '$hash', '$salt');"); // VULNERABILITY: SQLi

            header("Location: index.php?page=login");
        }
    }
?>

<form action="index.php?page=register" method="POST">
    <div>
        <input type="text" placeholder="Username" name="username" required />
    </div>

    <div>
        <input type="password" placeholder="Password" name="password" required />
    </div>

    <input type="submit" />
</form>
<a href="index.php?page=login">Log in</a>