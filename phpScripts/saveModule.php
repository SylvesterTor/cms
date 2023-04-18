<?php
#include "..\secrets\connectLocal.php";
include "../secrets/connect.php";
include "controlUser.php";
$bgColor=$_POST["bgcolor"];
$shadowState=$_POST["shadowState"];

$sql="UPDATE module
SET background='".$bgColor."',
shadow= ".$shadowState." 
WHERE module_ID=".$_POST["module"].";";

$conn->query($sql);
echo $sql;
?>