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
    <form name="homeButton" action="newsHome.php" method="POST">
    <input type="submit" value="Homepage"></form><br>

    <?php
        require 'database.php';
        session_start();
        if(isset($_POST['storyID']))$_SESSION['storyID'] = $_POST['storyID'];
        

        //display stories
        $stmt = $mysqli->prepare("select content,title from stories where storyID=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i',$_SESSION['storyID']);
        $stmt->execute();
        $stmt->bind_result($content,$title);
        $content2 = htmlspecialchars($content);
        $title2 = htmlspecialchars($title);

        while($stmt->fetch()){
            echo '<h4>'.$title.'</h4><br>';
            echo '<h5>'.$content.'</h5>';
            
        }

        if(isset($_SESSION['username'])){
        echo '<form name="commentSubmit" action="newsCommentSubmit.php" method="POST">
        Submit a comment<input type="text" name="content">
        <input type="hidden" name="storyID" value='.$_SESSION['storyID'].'>

        <input type="submit" value="Submit"></form><br>'; 
        };

        //display comments
        $stmt2 = $mysqli->prepare("select commentID,storyID,username,content from comments where storyID=?");
        if(!$stmt2){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt2->bind_param('i',$_SESSION['storyID']);
        $stmt2->execute();
        $stmt2->bind_result($commentID,$storyID,$username,$content);
        // echo 'session '.$_SESSION['storyID'];
        echo '<br><strong>Comments:</strong><br>';
        while($stmt2->fetch()){
            if($_SESSION['storyID'] == $storyID){
                // echo 'story '.$storyID;
                printf("\t%s\n",
                htmlspecialchars($content)
            );
                echo '<br>';
                //delete comments
                if(isset($_SESSION['username']))if($_SESSION['username'] == $username){
                    echo '<form name="commentDelete" action="newsCommentDelete.php" method="POST">
                    <input type="hidden" name="storyID" value='.$_SESSION['storyID'].'>
                   
                    <input type="hidden" name="commentID" value='.$commentID.'>
                    <input type="submit" value="Delete Comment"></form><br>';

                    //edit comments
                    echo '<form name="commentEdit" action="newsCommentEdit.php" method="POST">
                    Edit Comment<input type="text" name="edit">
                    <input type="hidden" name="content" value='.$content.'>
                    <input type="hidden" name="commentID" value='.$commentID.'>

                    <input type="submit" value="Edit"></form><br>';
                    //add tokens?
                                       
                }
            }
        }
        
    ?>


</body>

</html>