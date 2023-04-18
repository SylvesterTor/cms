<?php
/*
This document is where we store basic custom php functions, that we might want to use again
*/
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


function rgbaToHex($rgba) {
	// Remove the "rgba(" and ")" parts from the input string
	$rgba = str_replace(array('rgba(', ')'), '', $rgba);
	
	// Split the color values into an array
	$colors = explode(',', $rgba);
	
	// Convert the red, green, and blue values to hex values
	$redHex = str_pad(dechex($colors[0]), 2, '0', STR_PAD_LEFT);
	$greenHex = str_pad(dechex($colors[1]), 2, '0', STR_PAD_LEFT);
	$blueHex = str_pad(dechex($colors[2]), 2, '0', STR_PAD_LEFT);
	
	// Combine the hex values into a single string
	$hex = '#' . $redHex . $greenHex . $blueHex;
	
	// Return the hex color value
	return $hex;
  }
  
  function getAlpha($rgba) {
	// Remove "rgba(" and ")" parts from input string
	$rgba = str_replace(array('rgba(', ')'), '', $rgba);
	
	// Split color values into an array
	$colors = explode(',', $rgba);
	
	// Get alpha value and convert to float
	$alpha = trim($colors[3]);
	return (float)$alpha;
  }

  
?>