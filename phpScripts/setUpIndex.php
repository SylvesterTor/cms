<?php
session_start();

// Read the JSON file 
$json = file_get_contents('setUp.json');
  
// Decode the JSON file
$setUpData = json_decode($json,true);

$site_ID=$setUpData["site_ID"];

if(!isset($_GET["page_ID"])){
  $page_ID=$setUpData["frontPage_ID"];  
}else{
  $page_ID=$_GET["page_ID"];
}

#include "secrets/connectLocal.php";
include "../secrets/connect.php";

include "../phpScripts/navbar.php";
include "../basicFunctions.php";
include "../sql_statements.php";

      $get_page->execute();
      $page=$get_page->get_result();
      if($page->num_rows>0){
          $page=$page->fetch_assoc();
          if($site_ID!=$page["site_ID"]){
            header('Location: index.php');
          }
    }else{
      header('Location: index.php');
    }

?>