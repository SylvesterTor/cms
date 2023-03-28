<?php
$siteId;
$pageId;
$logInError=false;
$loggedIn=false;
session_start();
if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]){
    $loggedIn=true;
}else{
    $loggedIn=false;
}
if(isset($_SESSION["siteId"])){
    $siteId=$_SESSION["siteId"];
}




include "secrets/connectLocal.php";

include "sql_statements.php";
include "blocks.php";
include "navbar.php";

if(isset($_GET["username"])){
$username=$_GET["username"];
$logIn->execute();
$result=$logIn->get_result();
if($result->num_rows>0){
    $row=$result->fetch_assoc();
    if($row["password"]==$_GET["password"]){
        $siteId=$row["site_ID"];
        $loggedIn=true;
        $_SESSION["loggedIn"]=true;
        $_SESSION["username"]=$username;
        $_SESSION["siteId"]=$siteId;
    }
}else {
    $loggedIn=false;
    $logInError=true;
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/color1/color1.css">
    <title>Edit page</title>
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
<body>
    <?php
    if(!$loggedIn){
        echo "<h1>login to edit your page</h1>";
        if($logInError){
            echo "please try again, username or password dont match up";
        }
        ?>
        <form action="" method="GET">
            <input type="text" name="username" id="">
            <input type="password" name="password" id="">
            <button type="submit">Log in</button>
        </form>
    <?php
    }else{
        
        navbarEdit(1);
        ?>
<button onClick="editPage();" class="btn position-fixed bottom-10 end-10 translate-middle text-center bg-danger col-1">
    Edit page
</button>
<div id="edit_page" class="col-2 d-none bg-light">
    <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Go to page
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="#">Action</a></li>
    <li><a class="dropdown-item" href="#">Another action</a></li>
    <li><a class="dropdown-item" href="#">Something else here</a></li>
  </ul>
</div>
<button class="btn btn-outline-grey circle rounded" type="button" data-toggle="collapse" data-target="#addPage" aria-expanded="false" aria-controls="addPage">
add page
  </button>
<form class="collapse row" id="addPage" method="POST">
  <label requried for="newText" class=""><input class="form-control" type="text" name="newText" id="" placeholder="navn"></label>
  <button type="submit" class="m-1 btn btn-outline-dark">tilføj</button>
</form>

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Select color theme
</button>
  <ul class="dropdown-menu">
  </ul>
</div>

<button class="btn btn-outline-red">Add module</button>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </script>
    <script>
        function resizeInput() {
    $(this).attr('size', $(this).val().length);
}

$('input[type="text"]')
    // event handler
    .keyup(resizeInput)
    // resize on page load
    .each(resizeInput);


    function remove(param){
            id = param.id;
            target=param.dataset.target;
            console.log(target);
            // Selecting the input element and get its value 
           var inputVal = document.getElementById(id).value;
           var element =  document.getElementById(param.dataset.target);
            var value = param.checked ? true : false;
            if(!value){
                element.classList.add("d-none");
            }else{
                element.classList.remove("d-none");
            }
    }

    function movenav(param){
            var element=document.getElementById(param.dataset.target);
            if(param.value=="left"){
                var value = true;
            }else{
                var value= false;
            }
            console.log(value);
            if(value){
                element.classList.add("me-auto");
                element.classList.remove("ms-auto")
            }else{   
                element.classList.add("ms-auto");
                element.classList.remove("me-auto")
            }
    }

    function editPage(params) {
        var element = document.getElementById("edit_page");
        if(element.classList.contains("d-none")){
            element.classList.remove("d-none");
        }else{
            element.classList.add("d-none");
        }
    }
    </script>

<?php
}
    ?>
</body>
</html>