<!DOCTYPE html>
<html>
    <head>
    <title>Story Submit</title>
    </head>

<body>
    <!-- <link rel="stylesheet" type="text/css" href="theme.css"> -->
<?php
    
    session_start();
    
    require 'database.php';
    $username = $_SESSION["username"];
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $link = htmlspecialchars($_POST['link']);
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
    }
    
    
    //add new user
    $stmt = $mysqli->prepare("insert into stories(username, content, title, link) values(?,?,?,?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ssss', $username, $content, $title, $link);
    $stmt->execute();
    $stmt->close();
    header('Location: http://ec2-3-15-199-117.us-east-2.compute.amazonaws.com/newsHome.php');
    exit;
?>
</body>
</html>