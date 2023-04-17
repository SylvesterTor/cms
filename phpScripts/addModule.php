<?php
include "..\secrets\connectLocal.php";

$zone = $_POST["zone_ID"];
$position=$_POST["position"];
$columns=$_POST["col"];
$insertBlock=
"INSERT INTO `module`
(`module_module`, `zone_ID`, `created_at`, `moduleType`, `position`) 
VALUES ('no idea','".$zone."',now(),".$columns.",".$position.")";


$updateTable=
'UPDATE module SET position = position + 1 WHERE zone_ID = '.$zone.' AND position>= '.$position.'';


//
$conn->query($updateTable);
$conn->query($insertBlock);
var_dump($updateTable);
?>