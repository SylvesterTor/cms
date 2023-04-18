<?php
include "secrets/connect.php";

include "phpScripts/navbar.php";
include "basicFunctions.php";
include "sql_statements.php";

$currentSite =$_POST["site_ID"];
$searchString = $_POST["searchString"];
$getSites = 
        'SELECT * FROM `site` 
        WHERE site_ID = '.$currentSite;
        $sites=$conn->query($getSites);
        $site=$sites->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title><?php echo $site["webaddress"]; ?> search</title>
</head>
<body>
<?php
navbar($currentSite,$site["webaddress"]."/");
?>
<div class="m-5 container-fluid row">
    <h1 class="">Search results</h1>
    <div class="col-9 m-auto border p-4">
        <h2>String to search for: <?php echo $searchString; ?></h2>
        <?php
        $getSearchResult = $conn->prepare(
            "SELECT *
			FROM `blocks`
			INNER JOIN module ON module.module_ID = blocks.module_ID
			INNER JOIN module_zone ON module_zone.zone_ID = module.zone_ID
			INNER JOIN pages ON pages.page_ID=module_zone.page_ID
			WHERE `content` LIKE ? AND pages.site_ID = ?
			");
		$searchString = "%{$searchString}%"; // add % wildcards to search string
		$currentSite=intval($currentSite);
        $getSearchResult->bind_param("si", $searchString,$currentSite);
		$getSearchResult->execute();
    	$result=$getSearchResult->get_result();
		if($result->num_rows>0){
			while($row=$result->fetch_assoc()){
				?>
				<div class="row col-11 position-relative searchBox my-2 p-3 m-auto rounded border-1 border border-grey">
					<div class="col-10 m-auto">
						<?php echo $row["content"];?>
						</div>
						<?php
				$link=$site["webaddress"]."/index.php?page_ID=".$row["page_ID"]."#block-".$row["block_ID"];
				
				echo '<a class="text-decoration-none text-black stretched-link" href="'.$link.'">go to page</a>';
				?>
				</div>

				<?php
			}
		}else{
			echo '<p>Nothing to match on site</p>';
		}
        ?>
    </div>
</div>
</body>
</html>