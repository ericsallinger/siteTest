<!DOCTYPE html>
<html>

<!-- TODO 
    web app security    
-->

<head>
    <title>News Site Home</title>
    <link rel="stylesheet" type="text/css" href="newsStyle.css">
    
</head>

<body>
    
    <link rel="stylesheet" type="text/css" href="newsStyle.css">
        <h1><form name="login" action="newsLogin.php" method="POST">
        Username<input type="text" name="username">
        Password<input type="text" name="password">
        <input type="submit" value="Login"></form></h1>

        <h1>New User? Register here<br>
        <form name="register" action="newsRegister.php" method="POST">
        Username<input type="text" name="username">
        Password<input type="text" name="password">
        <input type="submit" value="Register"></form></h1>

      
    <?php
    
        session_start();
        if(!isset($_SESSION['token'])){
             $_SESSION['token']= bin2hex(random_bytes(32));
        }
        require 'database.php';
        if(isset($_SESSION['username'])){
            echo '<h1>Logged in as: '.$_SESSION['username'].'</h1>';

        }
        else{
            echo '<h1>logged out</h1>';
        }
    ?>  
  

        <h1><form name="logout" action="newsLogout.php" method="POST">
        <input type="submit" value="Logout"></form></h1>

        <h1><form name="userRecords" action="newsUserRecords.php" method="POST">
        <input type="submit" value="User Comment Records"></form></h1>

        <h4>Today's Headlines</h4>
    <?php
        if(isset($_SESSION['username'])){
        echo'<h2>Submit a Story<br>
        <form name="storySubmit" action="newsStorySubmit.php" method="POST">
        Title<input type="text" name="title"><br>
        Content <input type="text" name="content"><br>
        Link<input type="text" name="link">
        <input type="hidden" name="token" value='.$_SESSION['token'].' />
        <input type="submit" value="Submit"></form></h2>';
        }
        else{
            echo'<h2>Submit a Story<br>To submit a story please login</h2>';
        };
    ?>
    

    <?php
        require 'database.php';
        //display stories
        $stmt = $mysqli->prepare("select storyID,username,content,title from stories");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->execute();
        $stmt->bind_result($storyID,$username,$content,$title);
        while($stmt->fetch()){
            // echo $title;
            
            echo'<form name="storyLink" action="newsArticle.php" method="POST">
            <input type="hidden" name=storyID value='.$storyID.'>
            <input type="submit" class="f" value='.$title.'></form>';
            
            //delete stories
                if(isset($_SESSION['username']))if($_SESSION['username'] == $username){
                    echo '<h3><form name="storyDelete" action="newsStoryDelete.php" method="POST">
                    <input type="hidden" name="storyID" value='.$storyID.'>
                    
                    <input type="submit" value="Delete Story"></form></h3>';


                    //edit stories
                    echo '<h3><form name="storyEdit" action="newsStoryEdit.php" method="POST">
                    Edit Story<input type="text" name="edit">
                    <input type="hidden" name="content" value='.$content.'>
                    <input type="hidden" name="storyID" value='.$storyID.'>
                    <input type="submit" value="edit"></form></h3><br>';
                    //add token?
                }
        }
        $stmt->close();
    ?>
       

</body>

</html>