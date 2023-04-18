
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="../style/style.css">

    <title><?php echo $page["pageName"];?></title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
  </script>

</head>

<body>
  <?php
      navbar($page["site_ID"]);
  ?>

  <div class="container-fluid px-5">
<?php
//get zones then modules and then blocks
$get_zones=
'SELECT * FROM module_zone WHERE page_ID = '.$page_ID.' ORDER BY placement ASC';
$zones = $conn->query($get_zones);
while ($zone=$zones->fetch_assoc()) {

  $get_modules=
  'SELECT * FROM module WHERE zone_ID = '.$zone["zone_ID"].'';
  
  $modules= $conn->query($get_modules);
  
  while ($module=$modules->fetch_assoc()) {
	  $columns=0;
	  $columns=getModuleType($module);

    $get_blocks=
    'SELECT * FROM blocks where module_ID="'.$module["module_ID"].'" ORDER BY position ASC';
    $blocks= $conn->query($get_blocks);
    
    if($blocks->num_rows>0){
      $shadow=""; 
      if($module["shadow"]){
        $shadow="shadow";
      }else{
        $shadow="";
      }
	  //create module div
      echo '<div class="row m-5 '.$shadow.'" id="module-'.$module["module_ID"].'" style="background-color:'.$module["background"].'">';
    	while ($block=$blocks->fetch_assoc()) {
			$shadow=""; 
			if($block["shadow"]){
			  $shadow="shadow";
			}else{
			  $shadow="";
			}
			//create blocks and display its content
			echo '<div class="block '.$columns. ' '.$shadow.'" id="block-'.$block["block_ID"].'" style="background-color:'.$block["background"].'";>';
			echo '<div class="content" id="'.$block["block_ID"].'">';
			echo $block["content"];
			echo '</div>';
			echo '</div>';
  		}
  		echo '</div>';
	}
  }

}
?>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>

    </script>
</body>
</html>