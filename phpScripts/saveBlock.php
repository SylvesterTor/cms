<?php
#include "..\secrets\connectLocal.php";
include "../secrets/connect.php";

$dataText=$_POST["data"];
$bgColor=$_POST["bgcolor"];
$shadowState=$_POST["shadowState"];
$isReady=$_POST["setText"];


//if text is given
//Makes it so you dont accidently delete everything.
if($isReady=="true"){
$sql=
"UPDATE blocks
SET content='".$dataText."', 
background='".$bgColor."',
shadow= ".$shadowState." 
WHERE block_ID=".$_POST["block"].";";
}else{
$sql="UPDATE blocks
SET background='".$bgColor."',
shadow= ".$shadowState." 
WHERE block_ID=".$_POST["block"].";";
}



$conn->query($sql);
echo $sql;
?>