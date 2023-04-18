<?php
include "pageHandler.php";
include "../secrets/connect.php";

session_start();
$siteName=$_POST["siteName"];
$user_ID=$_SESSION["user_ID"];

$checkForSites = $conn->prepare("
    SELECT EXISTS(SELECT * FROM site WHERE webaddress=?) AS 'exists';");
$checkForSites->bind_param("s", $siteName);
$checkForSites->execute();
$otherSites=$checkForSites->get_result();

if($otherSites->fetch_assoc()["exists"]==1){
    header('Location: ../admin.php?exists=1');
}else{
$siteName=$_POST["siteName"];
$createSite = $conn->prepare("INSERT INTO `site` (`webaddress`,`data_published`) VALUES (?,NOW())");
$createSite->bind_param("s", $siteName);
$createSite->execute();

$site_ID=$conn->insert_id;


$data;
$data["pageName"]=$siteName;
$data["mainSite"]=$site_ID;

$createNavbar=
"INSERT INTO `navbar`(`site_ID`, `title`, `search`, `alignment`) VALUES (".$site_ID.",'".$siteName."',0,0)";
$conn->query($createNavbar);

$addAdminPair = $conn->prepare(
"INSERT INTO `adminpairing`(`user_ID`, `site_ID`) VALUES (?,?)");
$addAdminPair->bind_param("ii", $user_ID, $site_ID);
$addAdminPair->execute();
$frontPage_ID=addPage($data,1);


mkdir("../".$siteName."", 0700);
$fp=fopen("../".$siteName.'/index.php','w');
fwrite($fp,'
<?php
include "../phpScripts/setUpIndex.php";   
include "../index.php";      
?>');
fclose($fp);

$fp=fopen("../".$siteName.'/setUp.json','w');
fwrite($fp,'{"site_ID":'.$site_ID.', "frontPage_ID":'.$frontPage_ID.'}');
fclose($fp);
header('Location: ../admin.php');

}
?>