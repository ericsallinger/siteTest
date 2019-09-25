<!DOCTYPE html>
<html>
    <head>
    <title>News Login</title>
    </head>

<body>
    <!-- <link rel="stylesheet" type="text/css" href="theme.css"> -->
<?php
    
    session_start();



    //get password from users
    require 'database.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $pass2 = null;
    

    $stmt = $mysqli->prepare("select password from users where username like '$username'");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->execute();
    $stmt->bind_result($pass);
    // echo $pass;
    while($stmt->fetch()){
        $pass2 = htmlspecialchars($pass);
    }
    if(password_verify($password, $pass2)){
        $_SESSION["username"] = $username;
        header('Location: http://ec2-3-15-199-117.us-east-2.compute.amazonaws.com/newsHome.php');
    }
    // else{
    //     // echo $pass2;
    //     // echo $password;
    //     // echo'loser';
    // }
    $stmt->close();
    

?>
</body>
</html>