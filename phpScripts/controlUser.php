<?php
session_start();

if(!isset($_SESSION["user_ID"])){
    header('Location: ../admin.php');
}else{
    $idToCheck=$_SESSION["user_ID"];
    $checkForUser = $conn->prepare("SELECT EXISTS(SELECT * FROM admin WHERE user_ID=?) AS 'exists';");
    $checkForUser->bind_param("i", $idToCheck);
    $checkForUser->execute();
    $user=$checkForUser->get_result();
    if($user->fetch_assoc()["exists"]!=1){
        header('Location: ../admin.php?exists=1');
    }
}
?>