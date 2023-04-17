<?php
$site_ID=1;
$page_ID=1;
$logInError=false;
$loggedIn=false;
session_start();

if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]){
    $loggedIn=true;
}else{
    $loggedIn=false;
}

if(isset($_SESSION["siteId"])){
    $site_Id=$_SESSION["siteId"];
}

include "secrets/connectLocal.php";
include "sql_statements.php";
include "phpScripts/navbar.php";
include "basicFunctions.php";

$get_pages->execute();
$result=$get_pages->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>
<body>
    <?php
    if(!$loggedIn){
        session_destroy();
        header('Location: login.php');
    }else{
        ?>
        <h1>This is your admin page</h1>
        <h2>first site</h2>
    <?php
    while($page=$result->fetch_assoc()){
        echo "<p>".$page["pageName"]."</p>";
        echo "<a href='edit.php?pageID=".$page["page_ID"]."'>".$page["pageName"]."</a>";
    }}
    ?>
</body>
</html>