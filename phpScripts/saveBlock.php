<?php
include "..\secrets\connectLocal.php";
$dataText=$_POST["data"];

$sql=
"UPDATE blocks
SET content='".$dataText."' 
WHERE block_ID=".$_POST["block"].";";

$conn->query($sql);
echo $dataText;
?>