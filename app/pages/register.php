<?php
    if(isset($_SESSION["id"])) {
        header("Location: index.php?page=dashboard");
    }

    // Check the credentials
    if(isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $stmt = $conn->prepare("SELECT * FROM Users WHERE username=:username;");
        $stmt->execute([ ":username" => $username ]);
        if($stmt->rowCount() > 0) {
            echo "<div>User '$username' already exists</div>"; // VULNERABILITY: User enumeration, XSS
        } else {
            $salt = substr(md5(rand()), 0, 4);
            $hash = md5($password . $salt); // VULNERABILITY: MD5 hashing
            $stmt = $conn->prepare("INSERT INTO Users (username, passhash, salt) VALUE (:username, :passhash, :salt);");
            $stmt->execute([ ":username" => $username, ":passhash" => $hash, ":salt" => $salt ]);

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