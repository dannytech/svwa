<?php
    $flags = array(); // Additional flags for form-based submission
    $score = 0;
?>

<html>
    <head>
        <title>SVWA Score</title>
    </head>
    <body>
        <?php
            if(isset($_POST["flag"])) {
                $flag = $_POST["flag"];

                if(in_array($flag, $flags)) {
                    $flagData = $flags[$flag];

                    $stmt = $conn->prepare("SELECT * FROM Flags WHERE id=:id;");
                    $stmt->execute([ ":id" => $flagData["id"] ]);

                    if($stmt->rowCount() == 0) {
                        $stmt = $conn->prepare("INSERT INTO Flags VALUE (:id, :flag, :points)");
                        $stmt->execute([ ":id" => $flagData["id"], ":flag" => $flagData["flag"], ":points" => $flagData["points"] ]);
                        
                        echo "<div>Correct! You've gained " . $flagData["points"] . " points!</div>";
                    } else {
                        echo "<div>You've already submitted that flag.</div>";
                    }
                } else {
                    echo "<div>Not a valid flag.</div>";
                }
            }
        ?>

        <form action="score.php" method="POST" >
            <input type="password" name="flag" required />
            
            <input type="submit" />
        </form>

        <table>
            <tr>
                <th>Flag</th>
                <th>Points</th>
            </tr>
            <?php
                $conn = new PDO("mysql:host=db;dbname=svwa", "svwa", "svwaissecure!");
                $stmt = $conn->prepare("SELECT * FROM Flags");
                $stmt->execute();

                while($flag = $stmt->fetch()) {
                    echo "<tr><td>" . $flag["flag"] . "</td><td>" . $flag["points"] . "</td></tr>";
                    $score += $flag["points"];
                }
            ?>
        </table>
        <div>Total score: <? $score ?> points</div>
    </body>
</html>