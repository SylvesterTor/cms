<?php
include "..\secrets\connectLocal.php";

$modules = $_POST["module_ID"];
$position=$_POST["position"]+1;

$insertBlockSql=
'INSERT INTO blocks (content, module_ID, position) VALUES ("<p class=\'bg-green\'>new block here</p>",'.$modules.', '.$position.' )';

$updateTableSql=
'UPDATE blocks SET position = position + 1 WHERE module_ID = '.$modules.' AND position>= '.$position.'';



$conn->query($updateTableSql);
$conn->query($insertBlockSql);
?>