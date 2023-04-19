<?php

include "../secrets/connect.php";
include "controlUser.php";
$type=$_POST["typeOfElement"];
$id=$_POST["idOfElement"];

switch ($type) {
    case 1:
        # code...
		$table = "blocks";
		$idPrefix="block_ID";
        break;
	case 2:
		# code...
		$table = "module";
		$idPrefix="module_ID";
		break;    
    default:
        # code...
        break;
}
    $sql=
    "DELETE FROM {$table} WHERE {$idPrefix} = ".$id.";";
    //echo $sql;
	$conn->query($sql);
?>