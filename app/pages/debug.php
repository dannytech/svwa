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
        $res = $conn->query("SELECT * from Users;");
        
        while($row = $res->fetch()) {
            echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . htmlspecialchars($row["username"]) . "</td>
                <td>" . $row["passhash"] . "</td>
                <td>" . $row["salt"] . "</td>
            </tr>";
        }
    ?>
</table>