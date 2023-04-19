<?php

$logInError=false;
$loggedIn=false;
$error = 0;
session_start();

//check if user is logged in
if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]){
    $loggedIn=true;
}else{
    $loggedIn=false;
}

//include all the stuff
include "secrets/connect.php";

include "sql_statements.php";
include "phpScripts/navbar.php";
include "basicFunctions.php";


if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["signup"])){
    if(isset($_POST["email"]) && isset($_POST["password"])){
        $email=strtolower($_POST["email"]);
        $password=$_POST["password"];

        $taken = false;
        $sql = "SELECT * FROM `admin` WHERE `mail` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows == 0){
            $sql="INSERT INTO `admin` (`mail`, `password`) VALUES ('$email', '$password')";
            
            $query=mysqli_query($conn,$sql);
            $error=3;
        } else {
            $error=2;
        }
    }
}




if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["login"])){
    if(isset($_POST["email"]) && isset($_POST["password"])){
        $email=strtolower($_POST["email"]);
        $password=$_POST["password"];
        $sql="SELECT * FROM `admin` WHERE `mail` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $loggedIn = false;
        $logInError = true;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($password == $row['password']) {
                    session_start();
                    $loggedIn=true;
                    $logInError = false;
                    $_SESSION["loggedIn"]=true;
                    $_SESSION["username"]=$username;
                    $_SESSION["user_ID"]=$row["user_ID"];
                }
            }
        }
        if(!$loggedIn){
            $error=1;
        }
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
            <?php 
            if ($error==1) {
                echo("The email and password dont match.");
            } elseif ($error==2) {
                echo("The email is already in use.");
            } elseif ($error==3) {
                echo("Sucessfull creation. Profile is now active.");
            }
            ?>
            <br>
            <label for="email">Email</label>
            <input class="form-control" type="email" id="username" name="email" id="" required>
            <label for="password" >Password</label>
            <input id="password"  class="form-control" type="password" name="password" id="" required>
            <button type="submit" name="login" class="mt-3 col-4 submit btn btn-outline-grey">Log in</button>
            <button type="submit" name="signup" class="mt-3 col-4 submit btn btn-outline-grey" href="signup.php">Sign up</a>

        </form>
    </div>

</body>

</html>
<?php
}else{
    header('Location: admin.php');
    }?>