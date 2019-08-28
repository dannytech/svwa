<?php // VULNERABILITY: Hidden page in robots.txt ?>

<form action="admin.php"> <?php // VULNERABILITY: Hidden administrator page ?>
    <button disabled>Administrator console</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Password Hash</th>
        <th>Salt</th>
    </tr>
    <?php
        // Logs out all user data
        $conn = mysqli_connect("db", "svwa", "svwaissecure!", "svwa");
        $res = mysqli_query($conn, "SELECT * from Users") or die(mysqli_error($conn));
        
        while($row = mysqli_fetch_array($res)) {
            echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . htmlspecialchars($row["username"]) . "</td>
                <td>" . $row["passhash"] . "</td>
                <td>" . $row["salt"] . "</td>
            </tr>";
        }

        mysqli_close($conn);
    ?>
</table>