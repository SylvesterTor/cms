<?php
$logInError=false;
$loggedIn=false;
session_start();
#include "secrets/connectLocal.php";
include "secrets/connect.php";

include "phpScripts/pageHandler.php";

if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]){
    $loggedIn=true;
    if(isset($_POST["addPage"])&& $_POST["addPage"]==1){
        addPage($_POST,0);
    }else if(isset($_POST["removePage"])){
        removePage($_POST);
    }
}else{
    $loggedIn=false;
}


include "sql_statements.php";
include "phpScripts/navbar.php";
include "basicFunctions.php";

?>
<?php
    if(!$loggedIn){
        session_destroy();
        header('Location: login.php');
    } else{
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>

<body>
    
    <main class="row">
        <a href="logout.php" class="text-end">log out</a>
        <h1 class="col-12 text-center">This is your admin page</h1>
    </main>

    <div class="container-fluid">
        <div class="row">
        <?php
        $getSites = 
        'SELECT * FROM adminpairing 
        INNER JOIN `admin` ON `admin`.user_ID=adminpairing.user_ID
        INNER JOIN `site` ON `site`.site_ID=adminpairing.site_ID
        WHERE `admin`.user_ID = '.$_SESSION["user_ID"];
        $sites=$conn->query($getSites);
        $_SESSION["sites"]=(array) null;

        if($sites->num_rows>0){
            while($row=$sites->fetch_assoc()){
                $site_ID=$row["site_ID"];
                $_SESSION["sites"][]=$site_ID;
                $get_pages->execute();
                $pages=$get_pages->get_result();
                
                ?>
                <div class="row col-4 p-4 m-auto shadow border ms-2">
                    <h2 class="text-center"><?php echo $row["webaddress"];?></h2>
                    <?php	
            if($pages->num_rows>0){
                while($page=$pages->fetch_assoc()){
                    echo '<div class="col-5 m-2">';
                    echo "<p class='m-0' >".$page["pageName"]."</p>";
                    echo "<a class='m-0' href='edit.php?page_ID=".$page["page_ID"]."'>Go to ".$page["pageName"]."</a>";
                    ECHO '</div>';
                }

            }else{
                echo "no pages";
            }
            ?>
            <div class="mt-4 row col-12 m-0 p-0">
                <!-- Button trigger modal -->
                <button type="button" class="m-auto col-6 btn btn-green" data-bs-toggle="modal" data-bs-target="#addPageToSite<?php echo $site_ID;?>">
                    Add page
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addPageToSite<?php echo $site_ID;?>" tabindex="-1" aria-labelledby="addPageLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" class="modal-body">
                                <input type="hidden" name="addPage" value="1">
                                <input type="text" name="pageName" id="">
                                <input type="hidden" name="mainSite" value="<?php echo $site_ID;?>">
                                <button type="submit">submit</button>
                            </form>
                        </div>
                    </div>
                </div>
        <!-- Button trigger modal -->
        <button type="button" class="m-auto col-6 btn btn-red" data-bs-toggle="modal"
                    data-bs-target="#removePage<?php echo $site_ID;?>">
                    remove Page
                </button>

        <div class="modal fade" id="removePage<?php echo $site_ID;?>" tabindex="-1" aria-labelledby="removePageLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" class="modal-body">
                                <input type="hidden" name="removePage" value="1">
                                <select name="pageID" class="form-select" id="floatingSelect"
                                    aria-label="Floating label select example">
                                    <?php
                                    $sql = "SELECT * FROM pages WHERE site_ID = ".$site_ID.' AND secure=0';
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                      // output data of each row
                                      while($row = $result->fetch_assoc()) {
                                        echo '<option value="'.$row["page_ID"].'">'.$row["pageName"].'</option>';
                                      }
                                    }
                                    ?>
                                </select>
                                <button type="submit">submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
                </div>

        <?php
        }
    }else{
        echo '<h4>You currently have no sites to your name</h4>';
    }
        ?>
        </div>
        <h3>create new site</h3>
        <?php
        if(isset($_GET["exists"])){
            if($_GET["exists"]==1){
                echo '<p class="text-danger">Pagename is already taken</p>';
            }
        }
        ?>
        <form action="phpScripts/createSite.php" method="POST">
        <label for="siteName">Name your site
            <input type="text" name="siteName" id="siteName" require>
        </label>
        <button type="submit">Create new page</button>
        <p>This will only work when selecting name, that doesnt exist</p>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>

    </script>
</body>

</html>
<?php }?>