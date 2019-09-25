<!DOCTYPE html>
<html>
    <head>
    <title>Story Delete</title>
    </head>

<body>
    <!-- <link rel="stylesheet" type="text/css" href="theme.css"> -->
<?php
    
    session_start();
    
    require 'database.php';
    $username = $_SESSION["username"];
    $storyID = $_POST['storyID'];
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
    }

    //delete comments first
    $stmt = $mysqli->prepare("delete from comments where storyID=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $storyID);
    $stmt->execute();
    $stmt->close();

    //then delete stories
    $stmt = $mysqli->prepare("delete from stories where storyID=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $storyID);
    $stmt->execute();
    // echo $storyID;
    $stmt->close();
    header('Location: http://ec2-3-15-199-117.us-east-2.compute.amazonaws.com/newsHome.php');
    exit;
?>
</body>
</html>