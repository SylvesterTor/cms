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
#include "secrets/connectLocal.php";
//include all the stuff
include "secrets/connect.php";

include "sql_statements.php";
include "phpScripts/navbar.php";
include "basicFunctions.php";


if(isset($_POST["username"])){
    $logInError=true;
    $username=$_POST["username"];
    $logIn->execute();
    $result=$logIn->get_result();
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        if($row["password"]==$_POST["password"]){
            session_start();
            $siteId=$row["site_ID"];
            $loggedIn=true;
            $_SESSION["loggedIn"]=true;
            $_SESSION["username"]=$username;
            $_SESSION["user_ID"]=$row["user_ID"];
    }
}else {
    $loggedIn=false;
    $logInError=true;
}
}

    

    if(!$loggedIn){

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>

<body>

    <div class="container-fluid pt-5">
        <form action=""
            class="m-auto col-4 p-3 shadow border border-<?php echo ($logInError)?"danger":"green";?> border-1 rounded"
            method="POST">
            <h1>login to edit your page</h1>
            <?php echo ($logInError)?"<p>please try again, username or password dont match up</p>":"";?>
            <label for="username">Username</label>
            <input class="form-control" type="text" name="username" id="">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" id="">
            <button type="submit" class="mt-3 col-4 submit btn btn-outline-grey">Log in</button>
        </form>
    </div>

</body>

</html>
<?php
}else{
    header('Location: admin.php');
    }?>