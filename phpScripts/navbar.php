<?php
function navbar($siteID,$pre="")
{
  global $conn;
  $sql="SELECT * FROM navbar WHERE site_ID = ".$siteID."";
  $navbarResult=$conn->query($sql);
  $navbar=$navbarResult->fetch_assoc();
  $sql="SELECT * FROM navbaritems INNER JOIN pages ON pages.page_ID=navbaritems.page_ID WHERE navbaritems.navbar_ID = ".$navbar["id"]."";
  $navbarItems=$conn->query($sql);
  ?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light <?php echo ($navbar["alignment"]==1) ? 'sticky-top':""; ?>">
    <div class="container-fluid ">
      <a class="navbar-brand" href="#" id="navbarTitle-<?php echo $navbar["id"]; ?>"><?php echo $navbar["title"]?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav <?php echo ($navbar["alignment"]==1) ? 'me-auto':"ms-auto"; ?> mb-2 mb-lg-0">
          <?php
          if ($navbarItems->num_rows > 0) {
            // output data of each row
            while($row = $navbarItems->fetch_assoc()) {
              echo "<li class='nav-item'><a href='".$pre."index.php?page_ID=".$row["page_ID"]."' class='nav-link'>".$row['pageName']."</a></li>";
            }
          }
          ?>
        </ul>
        <?php 
        if($navbar["search"]==1){
        ?>
        <form class="d-flex" action="../search.php" method="POST">
          <input type="hidden" name="site_ID" value="<?php echo $navbar["site_ID"];?>">
          <input class="form-control me-2" type="search" name="searchString" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <?php
        }
        ?>
      </div>
    </div>
  </nav>
  <?php
}

function navbarEdit($siteID)
{
	global $conn;
  if(isset($_POST["newLink"]) && $_SERVER["REQUEST_METHOD"]=="POST" && $_POST["newLink"]==1){
    var_dump($_POST);
		$sql=
		"INSERT INTO `navbaritems`(`navbar_ID`, `page_ID`) VALUES (".$_POST["id"].",".$_POST["page"].")";
		$conn->query($sql);
    unset($_POST["newLink"]);
	}else{
		if(isset($_POST["removeLink"])&& $_SERVER["REQUEST_METHOD"]=="POST" && $_POST["removeLink"]==1){
			$sql=
			"DELETE FROM navbaritems WHERE id = ".$_POST["linkToRemove"].";";
			$conn->query($sql);
      unset($_POST["removeLink"]);
		}
	}

$sql="SELECT * FROM navbar WHERE site_ID = ".$siteID."";
$result=$conn->query($sql);
$navbar=$result->fetch_assoc();
$sql="SELECT * FROM navbaritems INNER JOIN pages ON pages.page_ID=navbaritems.page_ID WHERE navbaritems.navbar_ID = ".$navbar["id"]."";
$navbarItems=$conn->query($sql);

  ?>

<nav class=" bg-light position-relative container-fluid">
  <form class="navbar navbar-expand-lg navbar-light" onsubmit="saveNavbar(event, this);" >
    <div class="container-fluid m-0 p-0">

      <input type="text" name="navbartitle" class="navbar-brand" id="" value="<?php echo $navbar["title"]?>">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul id="nav-id" class="navbar-nav <?php echo ($navbar["alignment"]==1) ? 'me-auto':"ms-auto"; ?> mb-2 mb-lg-0">

          <?php
        if ($navbarItems->num_rows > 0) {
          // output data of each row
          while($row = $navbarItems->fetch_assoc()) {
			echo "<li class='nav-item'><a href='edit.php?page_ID=".$row["page_ID"]."' class='nav-link'>".$row['pageName']."</a></li>";
		}
        }
          ?>

		<li class="nav-item"> 
            <button class="btn btn-outline-grey circle rounded nav-link" type="button" data-bs-toggle="collapse" 
			data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
		
              +
            </button>
          </li>
          <li class="nav-item">
            <button class="btn btn-outline-danger circle rounded nav-link" type="button" data-bs-toggle="collapse" 
			data-bs-target="#removenav" aria-expanded="false" aria-controls="removenav">
              -
            </button>
          </li>
        </ul>

        <div class="d-flex <?php echo $navbar["search"]==1 ? "" : "d-none"?>" id="searchbar">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="" disabled>Search</button>
        </div>

      </div>
      <div class="form-check form-switch position-absolute end-0 top-100 bg-light rounded">
        <input onclick="remove(this);" name="searchBar" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
          data-target="searchbar" <?php echo $navbar["search"]==1 ? "checked" : ""  ?>>
        <label class="form-check-label" for="flexSwitchCheckDefault">Enable search</label>
      </div>
    </div>
    
    <div class="position-absolute savebutton translate-middle start-50 top-50">
      <button type="submit">gem</button>
      <div class="form-check form-check-inline">
        <input onclick="movenav(this);" id="navbar-left" data-target="nav-id" class="form-check-input" type="radio"
        name="alignment" value="left" <?php echo ($navbar["alignment"]==1) ? 'checked':""; ?>>
        <label class="form-check-label" for="alignment">1</label>
      </div>
      <div class="form-check form-check-inline">
        <input onclick="movenav(this);" id="navbar-right" data-target="nav-id" class="form-check-input" type="radio"
        name="alignment" value="right" <?php echo ($navbar["alignment"]==0) ? 'checked':""; ?>>
        <label class="form-check-label" for="alignment">2</label>
      </div>
    </div>
    <input type="hidden" name="navbarID" value="<?php echo $navbar["id"]; ?>">
  </form>
  <form class="collapse row" id="collapseExample" method="POST">
    <div class="col-2">
      <select name="page" class="form-select" id="floatingSelect" aria-label="Floating label select example">
      
      <?php
$sql = "SELECT * FROM pages WHERE site_ID = ".$siteID."";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
  echo '<option value="'.$row["page_ID"].'">'.$row["pageName"].'</option>';
  }
  }
      ?>
      </select>
    </div>
    <input type="hidden" name="id" value="<?php echo $navbar["id"];?>">
    <button type="submit" name="newLink" class="col-1 btn btn-outline-success">Tilføj</button>
  </form>

  <form class="collapse row" id="removenav"  method="POST">
  	<input type="hidden" name="removeLink" value="1">

  	<div class="col-2">
      <select class="form-select" id="removenavselect" name="linkToRemove" aria-label="Floating label select example">
            <?php
		$sql = "SELECT navbaritems.id as id, pages.pageName as pageName FROM navbaritems INNER JOIN pages ON pages.page_ID=navbaritems.page_ID INNER JOIN navbar ON pages.site_ID=navbar.site_ID WHERE navbar.site_ID = ".$siteID."";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		  // output data of each row
		  while($row = $result->fetch_assoc()) {
		  echo '<option value="'.$row["id"].'">'.$row["pageName"].'</option>';
		  }
		  }
      ?>
      </select>
    </div>
    <input type="hidden" name="id" value="<?php echo $navbar["id"];?>">
    <button type="submit" class="col-1 btn btn-outline-danger">Fjern</button>
  </form>
</nav>

<?php
}
  

?>