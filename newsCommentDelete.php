<!DOCTYPE html>
<html>
    <head>
    <title>Comment Delete</title>
    </head>

<body>
    <!-- <link rel="stylesheet" type="text/css" href="theme.css"> -->
<?php
    
    session_start();
    
    require 'database.php';
    $username = $_SESSION["username"];
    $storyID = $_POST['storyID'];
    $commentID = $_POST['commentID'];
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
    }
    
    //add new user
    $stmt = $mysqli->prepare("delete from comments where commentID=? AND storyID=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ss', $commentID, $storyID);
    $stmt->execute();
    $stmt->close();
    header('Location: http://ec2-3-15-199-117.us-east-2.compute.amazonaws.com/newsArticle.php');
    exit;
?>
</body>
</html>