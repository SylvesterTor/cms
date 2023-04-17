<?php

$logInError=false;
$loggedIn=false;

session_start();

//check if user is logged in
if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]){
    $loggedIn=true;
}else{
    $loggedIn=false;
}

include "secrets/connectLocal.php";
include "sql_statements.php";
include "phpScripts/navbar.php";
include "basicFunctions.php";

if(isset($_GET["username"])){
    $username=$_GET["username"];
    $logIn->execute();
    $result=$logIn->get_result();
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        if($row["password"]==$_GET["password"]){
            session_start();
            $siteId=$row["site_ID"];
            $loggedIn=true;
            $_SESSION["loggedIn"]=true;
            $_SESSION["username"]=$username;
            $_SESSION["siteId"]=$siteId;
    }
}else {
    $loggedIn=false;
    $logInError=true;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
    if(!$loggedIn){
        echo "<h1>login to edit your page</h1>";
        if($logInError){
            echo "please try again, username or password dont match up";
        }
        ?>
        <form action="" method="GET">
            <input type="text" name="username" id="">
            <input type="password" name="password" id="">
            <button type="submit">Log in</button>
        </form>
    <?php
    }else{
    header('Location: admin.php');
    }?>
</body>
</html>