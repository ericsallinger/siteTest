<!DOCTYPE html>
<html>
    <head>
    <title>Comment Submit</title>
    </head>

<body>
    <!-- <link rel="stylesheet" type="text/css" href="theme.css"> -->
<?php
    
    session_start();
    require 'database.php';
    $username = $_SESSION["username"];
    $content = htmlspecialchars($_POST['content']);
    // if(!hash_equals($_SESSION['token'], $_POST['token'])){
	// die("Request forgery detected");
    // }
    // echo $_SESSION['storyID'];


    //add new user
    $stmt = $mysqli->prepare("insert into comments(storyID, username, content) values(?,?,?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('iss',$_SESSION['storyID'], $username, $content);
    $stmt->execute();
    $stmt->close();
    header('Location: http://ec2-3-15-199-117.us-east-2.compute.amazonaws.com/newsArticle.php');
    exit;
?>
</body>
</html>