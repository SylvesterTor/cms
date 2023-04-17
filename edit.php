<?php
$siteId;
$page_ID=1;
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
if(isset($_GET["pageID"])){
    $page_ID=$_GET["pageID"];
}
if(isset($_SESSION["user"])){
	$user= $_SESSION["user"];
}

include "secrets/connectLocal.php";
include "sql_statements.php";
include "phpScripts/navbar.php";
include "basicFunctions.php";

$get_page->execute();
$result=$get_page->get_result();
$page=$result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Edit page</title>
</head>
<body>
    <?php
    if(!$loggedIn){
			header('Location: login.php');
		
    }else{
		
		navbarEdit(1);
		?>

    <!-- main page-->
    <div class="container-fluid">

<?php
$get_zones=
'SELECT * FROM module_zone WHERE page_ID = '.$page_ID.' ORDER BY placement ASC';
$zones = $conn->query($get_zones);

//get zones
while ($zone=$zones->fetch_assoc()) {
  $get_modules=
  'SELECT * FROM module WHERE zone_ID = '.$zone["zone_ID"].'';
  $modules= $conn->query($get_modules);

  if($modules->num_rows>0){
	//get modules
  while ($module=$modules->fetch_assoc()) {
    $get_blocks=
    'SELECT * FROM blocks where module_ID="'.$module["module_ID"].'" ORDER BY position ASC';
    
	$columns=0;
	$columns=getModuleType($module);


	echo '<div class="row module" id="module-'.$module["module_ID"].'" data-position="'.$module["position"].'" data-parent="'.$module["zone_ID"].'">';
    $blocks= $conn->query($get_blocks);

	if($blocks->num_rows>0){
    //get blocks
    while ($block=$blocks->fetch_assoc()) {
		//standard blocks
        echo "<div data-position='".$block["position"]."' data-parent='".$block["module_ID"]."' id='bigBlock-".$block["block_ID"]."' class='block position-relative ".$columns."' style='background-color:".$block["background"].";	 '>";
        echo "<div class='editor' id='block-".$block["block_ID"]."'>";
        //block content
		echo $block["content"];
        echo "</div>";
		?>
		<div class="btn-group dropup position-absolute bottom-0 end-0 ">
  		<button type="button" onClick="edit(this);" data-target="<?php echo $block["block_ID"]?>" id="buttonBlock-<?php echo $block["block_ID"]?>" class="position-absolute bottom-0 end-0 btn btn-outline-dark" data-bs-toggle="dropdown" aria-expanded="false">
    	Edit
  		</button>
  <ul class="dropdown-menu position-sticky bottom-10 end-10">
	<form action="">
    <!-- Dropdown menu links -->
	<li class="dropdown-item">
        <input name="shadow" onclick="addShadow(this)" data-target="<?php echo $block["block_ID"]; ?>" class="form-check-input" type="checkbox" 
          data-target="">
        <label class="" for="shadow">Shadow</label>	
	</li>
	<li class="dropdown-item">
		<label class="btn" >Color
		<input type="color" name="bg-color" id="" value="<?php echo $block["background"]; ?>"data-target="<?php echo $block["block_ID"]; ?>" onchange="blockColor(this);">
	</label>
	</li>
	</form>
	<li class="dropdown-item">
	<?php echo '<button class="btn" onClick="editText(this);" data-target="'.$block["block_ID"].'" id="buttonBlock-'.$block["block_ID"].'">text</button>';?>
	</li>
  </ul>
</div>
		<?php
        echo "</div>";
  }
}else{
	echo "<div data-position='1' data-parent='".$module["module_ID"]."' class='block position-relative'>";
	echo "Empty module here with no block. Either delete the module or add a block";
  echo "</div>";
}
  echo '</div>';
  }}else{
	echo "<div data-position='0' data-parent='".$zone["zone_ID"]."' class='module position-relative'>";
	echo "No modules in this zone. Start adding";
  	echo "</div>";
  }
  }

?>

<div class="btn-group dropup position-fixed bottom-10 end-10">
  <button type="button" class="form-control col-12 btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
    Edit page
  </button>
  <ul class="dropdown-menu">
    <!-- Dropdown menu links -->
	<li class="dropdown-item">
		<button class="btn" onClick="highlightModule()">Add module</button>
	</li>
	<li class="dropdown-item">
		<button class="btn" onClick="highlightBlocks()">Add block</button>
	</li>
	<li class="dropdown-item">
		<a class="btn" href="admin.php">Go to admin</a>
	</li>
	<li class="dropdown-item">
		<button class="btn">Add page</button>
	</li>
  </ul>
  
</div>

</div>


<!-- add inline editor-->
<script src="ckeditor/build/ckeditor.js"></script>

<!-- add bootstrap and jquery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>

		//variables controlling current block being edited
		let editorIsset=false;
		let editor="";
		let editorButton="";
  		let buttonstuff=false;

		//variable to select highlighted part
  		let highlightedClass="block";

  		function editBlock(params) {
			console.log(params);
			console.log(buttonstuff);
			if(buttonstuff){
				buttonstuff=false;
				params.innerHTML="Save";
			}else{
				params.innterHTML="Edit";
				buttonstuff=true;
			}
		}

		//function to editblock
        function edit(params) {
			//remove all highlights
			deHighlight(highlightedClass);
			//get button
			var button = document.getElementById(params.id);

			if(editorIsset && editorButton != button){
				editor.destroy();
				editor="";
				editorButton.innerHTML="text";
				editorButton="";
				editorIsset=false;
			}
			if(editorButton==button){
				save(params);
			}else{

				button.innerHTML="save";
				editorButton=button;
				editorIsset=true;
			}
        }

		function editText(params){
			//select block element
			var targetID="#block-";
        		targetID+=params.dataset.target;
        		var element = document.querySelector(targetID);
				//add editor to element
        		ClassicEditor
        		    .create( element,{updateSourceElementOnDestroy: true})
					.then(newEditor=>{
						editor=newEditor;
					})
        		    .catch( error => {
        		    console.error( error );
        		} );
		}

        function save(params){
			//get and edit button
            var button = document.getElementById(params.id);
            button.innerHTML="edit";
			//get target block
            var targetID="#block-";
            targetID+=params.dataset.target;
			var blockID=params.dataset.target;
            var element = document.querySelector(targetID);
			
			//save in server
			let editorData=editor.getData();
			$.ajax({
            	url:"phpScripts/saveBlock.php",    //php scritpet
            	type: "post",    //request type,
            	data: {data: editorData, block: blockID},
            	success:function(result){
            	    console.log(result);
            	}
        	});

			//remove editor from block
			editor.destroy();
			editor="";
			editorButton.innerHTML="edit";
			editorButton="";
			editorIsset=false;
			saveAlert("block saved");
        }


		function highlightBlockNModule(type){
			highlightClass(type);
			let allModules = getElements(type);
			let func;
			let parent;
			if(type=="module"){
				func="addModule(";
			}else if(type=="block"){
				func="addBlock(";
			}
			allModules.forEach(element => {
				element.addEventListener(
			  		"mouseover",
			  		(event) => {
						position_before=parseInt(element.dataset.position)-1;
						position_after=parseInt(element.dataset.position)+1;
						parent=element.dataset.parent;
						if(!element.classList.contains("addMode") && element.classList.contains(highlightedClass)){
						removeButtons();
						element.insertAdjacentHTML(
			  						  "beforeend",
			  						  "<button onClick='"+func+position_after+", "+parent+")'  class='position-absolute end-0   addButton col-1 btn text-green btn-outline-grey'>+</button>"
			  						);
									  element.insertAdjacentHTML(
			  						  "afterbegin",
			  						  "<button onClick='"+func+position_before+", "+parent+")' class='position-absolute start-0 addButton col-1 btn text-green btn-outline-grey'>+</button>"
			  						);
						element.classList.add("addMode");
						}
					},
					false
				);
				element.addEventListener(
			  		"mouseleave",
			  		(event) => {
						if(element.classList.contains("addMode")){
							element.classList.remove("addMode");
						}
					},
					false
				);
			});
		}

		function highlightModule() {
			highlightBlockNModule("module");
		}

		function highlightBlocks() {
			highlightBlockNModule("block");
		}
		
		function addBlock(pos, module) {
			console.log("hej");
			$.ajax({
            	url:"phpScripts/addBlock.php",    //php scritpet
            	type: "post",    //request type,
            	data: {position: pos, module_ID: module},
            	success:function(result){
            	    console.log(result);
            	}
        	});
			setTimeout(function() {
			  location.reload();
			}, 500);
		}

		function addModule(pos, zone) {
			let type = parseInt(prompt("How many columns should it have? Min: 1, Max: 4"));
			if(type>=1 && type<=4){
			$.ajax({
            	url:"phpScripts/addModule.php",    //php scritpet
            	type: "post",    //request type,
            	data: {position: pos, zone_ID: zone, col: type},
            	success:function(result){
            	    console.log(result);
            	}
        	});
			setTimeout(function() {
			  location.reload();
			}, 500);
			}
		}

		function deHighlight(params) {
			//remove all buttons and remove the border from previous highligted divs
			removeButtons();
			const modules = document.querySelectorAll('.'+params);
			modules.forEach(element => {
				element.classList.remove("border","border-dark", "addMode");
			});
		}

		function removeButtons(){
			const addButtons = document.querySelectorAll(".addButton");
			addButtons.forEach(element => {
				element.remove();
			});
		}

		function highlightClass(classToHightligt) {
			deHighlight(highlightedClass);
			const modules = document.querySelectorAll("."+classToHightligt);
			modules.forEach(element => {
				element.classList.add("border","border-dark");
			});
			highlightedClass=classToHightligt;
		}

		function getElements(elementClass) {
			return document.querySelectorAll("."+elementClass);
		}

		function remove(param){
            id = param.id;
            target=param.dataset.target;
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
            if(value){
                element.classList.add("me-auto");
                element.classList.remove("ms-auto")
            }else{   
                element.classList.add("ms-auto");
                element.classList.remove("me-auto")
            }
    }

	function saveNavbar(event,params) {
		var formData = new FormData(params); // get form data

		$.ajax({
            	url:"phpScripts/saveNav.php",    //php scritpet
            	type: "post",    //request type,
            	data: {title: formData.get("navbartitle"),
					search: formData.get("searchBar"),
					alignment: formData.get("alignment"),
					id: formData.get("navbarID")},
            	success:function(result){
            	    console.log(result);
            	}
        	});
			saveAlert("Navbar Saved");
	}

	function saveAlert(string){
		alert(string);
	}

	function blockColor(params){
		let targetID="bigBlock-"+params.dataset.target;
		let element=document.getElementById(targetID);
		element.style.backgroundColor=params.value;
	}

	function addShadow(params){
		let targetID="bigBlock-"+params.dataset.target;
		let element=document.getElementById(targetID);
		console.log(params.value);
		if(params.checked){
			element.classList.add("shadow");
		}else {
			element.classList.remove("shadow");
		}
	}
    </script>

<?php
}
    ?>
</body>
</html>