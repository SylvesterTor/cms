<?php
$logInError=false;
$loggedIn=false;
$site_ID;
session_start();
#include "secrets/connectLocal.php";
include "secrets/connect.php";

include "sql_statements.php";

if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]){
    $loggedIn=true;
	if(isset($_GET["page_ID"])){
		$page_ID=$_GET["page_ID"];
	}
	if(isset($_SESSION["user_ID"])){
		$user= $_SESSION["user_ID"];
	}
	$get_page->execute();
	$page=$get_page->get_result();
	$page=$page->fetch_assoc();
	
	if(isset($_SESSION["sites"])){
		if(in_array($page["site_ID"],$_SESSION["sites"])){
			$site_ID=$page["site_ID"];
		}
		else{
			$loggedIn=false;
		}
	}

}else{
			$loggedIn=false;
}

include "phpScripts/navbar.php";
include "basicFunctions.php";

    if(!$loggedIn){
			header('Location: login.php');
		
    }else{
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
		navbarEdit($page["site_ID"]);
		?>

    <!-- main page-->
    <div class="container-fluid px-5">

<?php
$get_zones=
'SELECT * FROM module_zone WHERE page_ID = '.$page_ID.' ORDER BY placement ASC';
$zones = $conn->query($get_zones);

//get zones
while ($zone=$zones->fetch_assoc()) {
  $get_modules=
  'SELECT * FROM module WHERE zone_ID = '.$zone["zone_ID"].' ORDER BY position ASC';
  $modules= $conn->query($get_modules);

  if($modules->num_rows>0){
	//get modules
  while ($module=$modules->fetch_assoc()) {
    $get_blocks=
    'SELECT * FROM blocks where module_ID="'.$module["module_ID"].'" ORDER BY position ASC';
    
	$columns=0;
	$columns=getModuleType($module);

	$shadow=""; 
	if($module["shadow"]){
		$shadow="shadow";
	}else{
		$shadow="";
	}
	echo '<div class="row m-5 module '.$shadow.'" id="module-'.$module["module_ID"].'" data-position="'.$module["position"].'" data-parent="'.$module["zone_ID"].'" style="background-color:'.$module["background"].'">';
    $blocks= $conn->query($get_blocks);

	if($blocks->num_rows>0){
    //get blocks
    while ($block=$blocks->fetch_assoc()) {
		$shadow=""; 
		if($block["shadow"]){
			$shadow="shadow";
		}else{
			$shadow="";
		}
		//standard blocks
        echo "<div data-position='".$block["position"]."' data-parent='".$block["module_ID"]."' id='bigBlock-".$block["block_ID"]."' class='block position-relative ".$columns." ".$shadow."' style='background-color:".$block["background"].";	 '>";
        echo "<div class='editor ' id='block-".$block["block_ID"]."' >";
        //block content
		echo $block["content"];
        echo "</div>";
		?>
		<div class="btn-group dropup position-absolute bottom-0 end-0 ">
  		<button type="button" onClick="edit(this,1);" data-target="<?php echo $block["block_ID"]?>" id="buttonBlock-<?php echo $block["block_ID"]?>" class="position-absolute bottom-0 end-0 btn btn-outline-dark">
    	Edit
  		</button>
  <ul class="sectionEditor shadow bg-light position-fixed bottom-10 end-10 d-none" id="editBlock-<?php echo $block["block_ID"]?>"style="z-index:10;">
	<form action="" id="editForm-<?php echo $block["block_ID"]?>" name="editForm-<?php echo $block["block_ID"]?>">
    <!-- Dropdown menu links -->
	
	<li class="dropdown-item">
        <label class="" for="shadow">Shadow</label>	
        <input name="shadow" onclick="addShadow(this,1)" data-target="<?php echo $block["block_ID"]; ?>" class="form-check-input" type="checkbox" 
          data-target="" <?php echo ($block["shadow"])? "checked":""; ?>>
	</li>
	<li class="dropdown-item">
		<label class="btn" >Color
		<input type="color" name="bgColor" id="" value="<?php echo rgbaToHex($module["background"]); ?>"data-target="<?php echo $block["block_ID"]; ?>" onchange="changeColor(this,1);">
		<input type="range" name="bgOpacity" id="" value="<?php echo getAlpha($module["background"]); ?>" data-target="<?php echo $block["block_ID"]; ?>" onchange="changeOpacity(this,1);">
		</label>
	</li>
	</form>
	<li class="dropdown-item">
	<?php echo '<button class="btn" onClick="editText(this);" data-target="'.$block["block_ID"].'" id="buttonBlock-'.$block["block_ID"].'">text</button>';?>
	<?php remove(1, $block["block_ID"]); ?>	
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
?>
<div class="dropdown">
  <button class="btn btn-secondary" type="button" onClick="edit(this,2);" data-target="<?php echo $module["module_ID"]?>" id="buttonModule-<?php echo $module["module_ID"]?>">
	module
</button>
<ul class="sectionEditor  shadow bg-light position-fixed bottom-10 end-10 d-none" id="editModule-<?php echo $module["module_ID"]?>"style="z-index:10;">
	<form action="" id="editModuleForm-<?php echo $module["module_ID"]?>" name="editModuleForm-<?php echo $module["module_ID"]?>">
	<li class="dropdown-item">
	<label class="btn" >Color
		<input type="color" name="bgColor" id="" value="<?php echo rgbaToHex($module["background"]); ?>"data-target="<?php echo $module["module_ID"]; ?>" onchange="changeColor(this,2);">
		<input type="range" name="bgOpacity" id="" value="<?php echo getAlpha($module["background"])*100; ?>"data-target="<?php echo $module["module_ID"]; ?>" onchange="changeOpacity(this,2);">
	</label>
</li>
<li class="dropdown-item">
        <label class="" for="shadow">Shadow</label>	
        <input name="shadow" onclick="addShadow(this,2)" data-target="<?php echo $module["module_ID"]; ?>" class="form-check-input" type="checkbox" 
          data-target="" <?php echo ($module["shadow"])? "checked":""; ?>>
	</li>
	</form>
	<?php remove(2, $module["module_ID"]); ?>	
	</ul>
</div>
<?php
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
		let currentEditorData="";
		let editorReady=false;
  		let previousForm="";
		//variable to select highlighted part
  		let highlightedClass="block";

		//function to editblock
        function edit(params,type) {
			//show form
			let formElement;
			let standardText;
			if(type==1){
			formElement=document.getElementById("editBlock-"+params.dataset.target);
			standardText="Module";
			}else{
				formElement=document.getElementById("editModule-"+params.dataset.target);
				standardText="Block";
			}
			formElement.classList.remove("d-none");

			//remove all highlights
			deHighlight(highlightedClass);

			//get button
			var button = document.getElementById(params.id);

			if(editorButton==button){
				formElement.classList.add("d-none");
				save(params,type);
				editorReady=false;
			}else{
				resetForm(standardText);
				previousForm=formElement;
				button.innerHTML="Save";
				editorButton=button;
			}
        }

		function resetForm(text){
			if(previousForm!=""){
			previousForm.classList.add("d-none");
			editorButton.innerHTML=text;
		}
		}

		function editText(params){
			if(editorIsset){
				closeEditor();
			}else{
				editorReady=true;
				//select block element
				var targetID="#block-";
				params.innerHTML="Text";
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
				editorIsset=true;
			}
		}

		function closeEditor(){
			if(editorIsset){
			currentEditorData=editor.getData();
			editor.destroy();
			editor="";
			editorIsset=false;
			}
		}

        function save(params,type){
			//get and edit button
            var button = document.getElementById(params.id);
            button.innerHTML="edit";

			//get form
			var formElement;
			if(type==1){
				formElement = document.forms["editForm-"+params.dataset.target];
			}else{
				formElement = document.forms["editModuleForm-"+params.dataset.target];
			}
			let shadow = formElement.shadow.checked;
			let color=getRGBA(formElement.bgColor.value, formElement.bgOpacity.value)

			//get target block
			var targetID
			var id;
			if(type==1){
				targetID="#block-";
				id=params.dataset.target;
			}else{
				targetID="#module-";
				id=params.dataset.target;
			}
            targetID+=params.dataset.target;
            var element = document.querySelector(targetID);

			closeEditor();
			//save in server
			let editorData=currentEditorData;
			if(type==1){
			$.ajax({
            	url:"phpScripts/saveBlock.php",    //php scritpet
            	type: "post",    //request type,
            	data: {data: editorData,setText:editorReady, block: id, shadowState: shadow, bgcolor: color},
            	success:function(result){
            	    console.log(result);
            	}
        	});
			}else{
				$.ajax({
            	url:"phpScripts/saveModule.php",    //php scritpet
            	type: "post",    //request type,
            	data: {module: id, shadowState: shadow, bgcolor: color},
            	success:function(result){
            	    console.log(result);
            	}
        	});
			}

			//remove editor from block
			editorButton.innerHTML="edit";
			editorButton="";
			previousForm="";
			saveAlert("block saved");
        }

	function baseColor(params,type){
		closeEditor();
		let targetID;
		if(type==1){
		targetID="bigBlock-"+params.dataset.target;
		}else{
		targetID="module-"+params.dataset.target;
		}
		return element=document.getElementById(targetID);
	}

	function changeColor(params,type){
		let element=baseColor(params,type);
		let brother = params.nextElementSibling;
		let colorValue=params.value;
		let rgbValue = getRGBA(colorValue, brother.value);
		element.style.backgroundColor = `${rgbValue}`;
	}

	function getRGBA(rgb, opacity){
		const redValue = parseInt(rgb.substring(1, 3), 16);
  		const greenValue = parseInt(rgb.substring(3, 5), 16);
  		const blueValue = parseInt(rgb.substring(5, 7), 16);
		const alphaValue = parseInt(opacity)/100;
  		const rgbValue = `rgba(${redValue}, ${greenValue}, ${blueValue},${alphaValue})`;
		return rgbValue;
	}
	function changeOpacity(params,type){
		let element=baseColor(params,type);
		const currentColor = getComputedStyle(element).backgroundColor;

		// Extract the RGBA values from the color
		const rgbaValues = currentColor.match(/\d+/g);


		// Set the new alpha value
		const newAlpha = params.value/100; // Set this to your desired opacity value

		// Set the background color with the updated alpha value
		element.style.backgroundColor = `rgba(${rgbaValues[0]}, ${rgbaValues[1]}, ${rgbaValues[2]}, ${newAlpha})`;
	}


	function addShadow(params,type){
		closeEditor();
		let targetID;
		if(type==1){
		targetID="bigBlock-"+params.dataset.target;
		}else{
		targetID="module-"+params.dataset.target;
		}

		let element=document.getElementById(targetID);
		console.log(targetID);
		if(params.checked){
			element.classList.add("shadow");
		}else {
			element.classList.remove("shadow");
		}
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
						position_before=parseInt(element.dataset.position);
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

		function removeBlockNModule(type, element){
			let targetID;
			if(type==1){
				targetID="bigBlock-"+element;
			}else{
				targetID="module-"+element;
			}
			let _element=document.getElementById(targetID);
			$.ajax({
            	url:"phpScripts/removeBlockNModule.php",    //php scritpet
            	type: "post",    //request type,
            	data: {typeOfElement: type, idOfElement: element},
            	success:function(result){
            	    console.log(result);
            	}
        	});
			setTimeout(function() {
			  location.reload();
			}, 500);
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
				console.log(element);
			});
			highlightedClass=classToHightligt;
		}

		function getElements(elementClass) {
			return document.querySelectorAll("."+elementClass);
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
		event.preventDefault();
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
    </script>

<?php
}
    ?>
</body>
</html>