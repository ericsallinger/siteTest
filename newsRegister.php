<!DOCTYPE html>
<html>
    <head>
    <title>News Register</title>
    </head>

<body>
    <!-- <link rel="stylesheet" type="text/css" href="theme.css"> -->
<?php
    
    session_start();
    
    require 'database.php';
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $user2 = null;

    //check if user already exists
    $stmt = $mysqli->prepare("select username from users where username like '$username'");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->execute();
    $stmt->bind_result($user);
    echo($user);
    
    while($stmt->fetch()){
        $user2 = htmlspecialchars($user);
    }
    //user already exists
    if($user2 != null){
        // $_SESSION["user"] = $user2;
        header('Location: http://ec2-3-15-199-117.us-east-2.compute.amazonaws.com/newsHome.php');
        exit;
    }
    $stmt->close();
    
    //add new user
    $stmt = $mysqli->prepare("insert into users(username, password) values(?,?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    // echo($pass);
    // while($stmt->fetch()){
    //     $pass2 = htmlspecialchars($pass);
    // }
    // if($pass2 == $password){
    //     echo'winner';
    // }
    // else{
    //     echo'loser';
    // }
    // echo 'user added';
    $stmt->close();
    header('Location: http://ec2-3-15-199-117.us-east-2.compute.amazonaws.com/newsHome.php');
    exit;
?>
</body>
</html>