<?php
$logIn = $conn->prepare(
    "SELECT * FROM admin WHERE username = ?");
$logIn->bind_param("s", $username);


$get_page = $conn->prepare(
    "SELECT * FROM pages WHERE page_ID = ?");
$get_page->bind_param("i", $page_ID);

$get_pages = $conn->prepare(
    "SELECT * FROM pages WHERE site_ID = ?");
$get_pages->bind_param("i", $site_ID);
?>