<!DOCTYPE html>
<html>
    <head>
    <title>Comment Edit</title>
    </head>

<body>
    <!-- <link rel="stylesheet" type="text/css" href="theme.css"> -->
<?php
    
    session_start();
    
    require 'database.php';
    $edit = htmlspecialchars($_POST['edit']);
    $content = $_POST['content'];
    $storyID = $_POST['storyID'];
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
    }

    
    //add new user
    $stmt = $mysqli->prepare("update stories set content=?  where storyID=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ss',$edit, $storyID);
    $stmt->execute();
    $stmt->close();
    header('Location: http://ec2-3-15-199-117.us-east-2.compute.amazonaws.com/newsHome.php');
    exit;
?>
</body>
</html>