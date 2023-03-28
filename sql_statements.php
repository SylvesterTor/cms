<?php

$get_nav = $conn->prepare(
"SELECT navbar.title, navbar.alignment, navbar.search, site.webaddress, navbar.listId, navbar.id FROM navbar
INNER JOIN site ON site.site_ID = navbar.site_ID
WHERE site.site_ID=?
");

$get_nav->bind_param("i", $site);


$get_list_items = $conn->prepare(
    "SELECT * FROM listitems
    WHERE listID=?
    ");
    
$get_list_items->bind_param("i", $list);
    
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