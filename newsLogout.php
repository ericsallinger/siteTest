<!DOCTYPE html>
<html>
    <head>
    <title>News Logout</title>
    </head>

<body>
    <!-- <link rel="stylesheet" type="text/css" href="theme.css"> -->
<?php
    
    require 'database.php';
    session_start();
    unset($_SESSION["username"]);
    // echo($_SESSION["username"]);
    header('Location: http://ec2-3-15-199-117.us-east-2.compute.amazonaws.com/newsHome.php');
    exit;