<?php
$logIn = $conn->prepare(
    "SELECT * FROM admin WHERE username = ?");
$logIn->bind_param("s", $username);

$addPage = $conn->prepare(
    "INSERT INTO pages (pageName, site_ID) VALUES (?, ?)");
$addPage->bind_param("si", $pageName, $siteId);
    
$get_page = $conn->prepare(
    "SELECT * FROM pages WHERE page_ID = ?");
$get_page->bind_param("i", $page_ID);
    
?>