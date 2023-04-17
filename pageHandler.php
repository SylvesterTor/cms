<?php


function addPage(){
    global $conn;
    $pageName=$_POST["pageName"];
    $mainSite=$_POST["mainSite"];
    $adress="index.php?pageID=".$_POST["pageName"];
    
    $sql=
    "INSERT INTO `pages`(`pageName`, `site_ID`, `webaddress`) VALUES ('".$pageName."','".$mainSite."','".$adress."')";
    $conn->query($sql);
    $page_ID=$conn->insert_id;
    $adress="index.php?pageID=".$page_ID;
    
    $sql="UPDATE pages SET webaddress='".$adress."' WHERE page_ID = ".$page_ID."";
    $conn->query($sql);
    $sql=
    "INSERT INTO `module_zone`(`zoneName`, `page_ID`, `placement`) VALUES ('header',".$page_ID.",0)";
    $conn->query($sql);
    $sql=
    "INSERT INTO `module_zone`(`zoneName`, `page_ID`, `placement`) VALUES ('main',".$page_ID.",1)";
    $conn->query($sql);
    $sql=
    "INSERT INTO `module_zone`(`zoneName`, `page_ID`, `placement`) VALUES ('footer',".$page_ID.",2)";
    $conn->query($sql);
}

function removePage($data){
    global $conn;
    $sql=
    "DELETE FROM pages WHERE page_ID = ".$data["pageID"].";";
    $conn->query($sql);
}
?>