<?php
$_GET["site_ID"]=1;
$_GET["page_ID"]=1;
$site_ID=$_GET["site_ID"];
$page_ID=$_GET["page_ID"]; 
include "secrets/connectLocal.php";
include "sql_statements.php";
$get_page->execute();
$page=$get_page->get_result();
$pageInfo=$page->fetch_assoc();
include "navbar.php";
include "blocks.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/color1/color1.css">
    <title><?php echo $pageInfo["pageName"]; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
    integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
  </script>
</head>
<body class="container-fluid p-0 ">
<?php
$get_zones=
'SELECT * FROM module_zone WHERE page_ID = '.$page_ID.' ORDER BY placement ASC';
$zones = $conn->query($get_zones);
while ($zone=$zones->fetch_assoc()) {
  $get_modules=
  'SELECT * FROM module WHERE zone_ID = '.$zone["zone_ID"].'';
  $modules= $conn->query($get_modules);
  while ($module=$modules->fetch_assoc()) {
    $get_blocks=
    'SELECT * FROM module 
    RIGHT JOIN imagestext ON imagestext.module_ID=module.module_ID
    RIGHT JOIN textarea ON textarea.module_ID=module.module_ID
    WHERE module.zone_ID = '.$zone["zone_ID"].'';
    //print_r($get_blocks);
    $blocks= $conn->query($get_blocks);
    while ($block=$blocks->fetch_assoc()) {
      # code...
    //print_r($module);
    //print_r($get_blocks);
    //switch ($module["type"]) {
    //  case 1:
    //    # code...
    //    navbar($site_ID);
    //    break;
    //  case 2:
    //    # code...
    //    textarea($module);
    //    break;
    //  case 3:
    //     # code...
    //     imgText($module);
    //     break;  
    //  case 4:
    //    # code...
    //    break;
    //  default:
    //    # code...
    //    break;
    //}
  }
  }
  }

navbar(1);

?>


<footer>
  footer
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </script>
</body>

<style>
    
</style>

</html>