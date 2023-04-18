<?php
#include "..\secrets\connectLocal.php";
include "../secrets/connect.php";

$title=$_POST["title"];

switch ($_POST["alignment"]) {
    case 'right':
        $alignment=0;
        break;
    case 'left':
        $alignment=1;
        break;
    default:
        $alignment=0;
        break;
}

if(isset($_POST["search"])&&$_POST["search"]=="on"){
	$search=1;
}else{
	$search=0;
}

$sql=
"UPDATE `navbar` 
SET `title`='".$title."',
`search`=".$search.",
`alignment`=".$alignment." 
WHERE ".$_POST["id"]."=id";

$conn->query($sql);
?>