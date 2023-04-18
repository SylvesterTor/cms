<?php
/*
$servername = "mysql75.unoeuro.com";
$username = "tvs2_dk";
$password = "DeGkmgxdyFEHcpfBntza";
$dbname = "tvs2_dk_db_cms";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
*/

  $servername = "localhost";
  $username = "root";
  $password = "Torweb.dk";
  $dbname = "cms";
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
?>