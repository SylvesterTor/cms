<?php
function navbar($siteID)
{
  global $get_nav, $site, $get_list_items, $list;
  $site=$siteID;
  $get_nav->execute();
  $result=$get_nav->get_result();
  $navbar = $result->fetch_assoc();
  $list=$navbar["listId"];
  $get_list_items->execute();
  $listItems=$get_list_items->get_result();
  $get_list_items->close();
  echo $row["content"];
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
        if ($listItems->num_rows > 0) {
          // output data of each row
          while($row = $listItems->fetch_assoc()) {
            echo "<li class='nav-item'><a href='#' class='nav-link'>".$row['text']."</a></li>";
          }
        }
      ?>
      </ul>
      <?php 
      if($navbar["search"]==1){
      ?>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
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
  global $get_nav, $site, $get_list_items, $list, $conn;
  $site=$siteID;
  $get_nav->execute();
  $result=$get_nav->get_result();
  $navbar = $result->fetch_assoc();

  $list=$navbar["listId"];
  $get_list_items->execute();
  $listItems=$get_list_items->get_result();
  ?>
<nav class=" bg-light position-relative container-fluid">
  <form method="POST" class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid m-0 p-0">

      <input type="text" name="navbartitle" class="navbar-brand" id="" value="<?php echo $navbar["title"]?>">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul id="nav-id" class="navbar-nav <?php echo ($navbar["alignment"]==1) ? 'me-auto':"ms-auto"; ?> mb-2 mb-lg-0">

          <?php
          if ($listItems->num_rows > 0) {
          // output data of each row
          while($row = $listItems->fetch_assoc()) {
            //echo "<li class='nav-item'><a href='#' class='nav-link'>".$row['text']."</a></li>";
            echo "<li class='nav-item'> <input type='text' class='nav-link' name='listItem-".$row['id']."' id='listItem-".$row['id']."' value='".$row["text"]."'></li>";

          }
        }
        ?>
          <li class="nav-item">
            <button class="btn btn-outline-grey circle rounded nav-link" type="button" data-toggle="collapse"
              data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              +
            </button>
          </li>
          <li class="nav-item">
            <button class="btn btn-outline-danger circle rounded nav-link" type="button" data-toggle="collapse"
              data-target="#removenav" aria-expanded="false" aria-controls="removenav">
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
        <input onclick="remove(this);" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
          data-target="searchbar" <?php echo $navbar["search"]==1 ? "checked" : ""  ?>>
        <label class="form-check-label" for="flexSwitchCheckDefault">Enable search</label>
      </div>
    </div>
  </form>

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
  <form class="collapse row" id="collapseExample" action="phpscripts\addNavLink.inc.php" method="POST">
    <div class="col-2">
      <select name="page" class="form-select" id="floatingSelect" aria-label="Floating label select example">
      
      <?php
$sql = "SELECT * FROM pages WHERE site_ID = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
  echo '<option value="'.$row["webaddress"].'">'.$row["pageName"].'</option>';
  }
  }
      ?>
      </select>
    </div>
    <input type="hidden" name="id" value="<?php echo $navbar["id"];?>">
    <button type="submit" class="col-1 btn btn-outline-success">Tilføj</button>
  </form>

  <form class="collapse row" id="removenav" action="phpscripts\removeNavLink.inc.php" method="POST">
    <div class="col-2">
      <select class="form-select" id="removenavselect" aria-label="Floating label select example">
      
      <?php
      $sql = 'SELECT * FROM listitems WHERE listID = '.$list.'';
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo '<option val="'.$row["altText"].'">'.$row["text"].'</option>';
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