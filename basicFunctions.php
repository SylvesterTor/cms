<?php

function getModuleType($module){
	switch ($module["moduleType"]) {
		case 1:
		  	# code...
		  	$columns="col-12";
		  	break;
		case 2:
		  	$columns="col-6";
		  	# code...
		  	break;
	  	case 3:
			$columns="col-4";
		  	# code...
		  	break;
		case 4:
			$columns="col-3";
			# code...
			break;
	  default:
		  # code...
		  $columns="col-6";
		  break;
	  }
	  return $columns;
}

?>