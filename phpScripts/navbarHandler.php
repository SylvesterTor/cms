<?php
include "../secrets/connect.php";

  if(isset($_POST["newLink"]) && $_SERVER["REQUEST_METHOD"]=="POST" && $_POST["newLink"]==1){
    $sql=
    "INSERT INTO `navbaritems`(`navbar_ID`, `page_ID`) VALUES (".$_POST["id"].",".$_POST["page"].")";
    $conn->query($sql);
    header("Location: ".$_POST["back"]."");
}else{
    if(isset($_POST["removeLink"])&& $_SERVER["REQUEST_METHOD"]=="POST" && $_POST["removeLink"]==1){
        $sql=
        "DELETE FROM navbaritems WHERE id = ".$_POST["linkToRemove"].";";
        $conn->query($sql);
        header("Location: ".$_POST["back"]."");
    }
}


?>