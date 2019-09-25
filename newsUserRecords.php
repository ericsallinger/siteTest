<!DOCTYPE html>
<html>

<!-- TODO 
    web app security    
-->

<head>
    <title>News Article</title>
    <!-- <link rel="stylesheet" type="text/css" href="newsStyle.css"> -->
</head>

<body>
    <link rel="stylesheet" type="text/css" href="newsStyle.css">
    <h5>User Records</h5>
    <form name="homeButton" action="newsHome.php" method="POST">
    <input type="submit" value="Homepage"></form><br>
    
    <?php
        require 'database.php';



        //display users
        $stmt = $mysqli->prepare("SELECT  count(comments.username),users.username as NUM FROM users left join comments on(users.username=comments.username) group by users.username");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->execute();
        $stmt->bind_result($nums, $two);
        // echo "<table>"; // start a table tag in the HTML

        // echo "<table><tr><th>ID</th><th>Name</th></tr>";
        // // output data of each row
        // while($row = mysqli_fetch_array($nums, $two)) {
        //     echo "<tr><td>" . $row[$nums]. "</td><td>" . $row[$two]. "</td></tr>";
        // }
        // echo "</table>";
    
        echo '<table><tr><th>User</th><th># Comments</th></tr>';
         while($stmt->fetch()){
            echo '<tr><td>'.$nums. "</td><td>".$two.'</td></tr>';
            
        }
        $stmt->close();


    ?>


</body>

</html>