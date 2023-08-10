<?php 
    /* require the herein used color definitions */
    require_once("ColorDefinitions.php");
?>
<style>
        .localFlexRow {
            display: flex;
            flex-direction: row;
        }
		.localFlexRowVariants {
            display: flex;
            flex-direction: row;
			padding-bottom:20px;
        }

         p.stubImage {
            border:solid thick <?php echo HighlightColor; ?>;  
            background-image: <?php getBgImageTiles(); ?>;
            border-radius: 0.75em; 
            border-width:5px; 
            margin:2px; 
            width:150px; 
            height:150px;
            align-self: center;
        }
        div.bikeToChooseEntry {
            display: flex;
            flex-direction: column;
            margin-left: 15px;
        }
        /* todo_TECHDEBT: remove hardcoded resources/classes for each vairant -> this could be outsourced to a function */
        /* dynamically (re-) color the bike frames, relative to their basecolor, by changing the hue-angle (->hsv model:https://www.johnpaulcaponigro.com/blog/wp-content/uploads/2021/02/hue_clock.jpg)*/
        img.dynamicHueImageVarA {
            filter: saturate(80%) hue-rotate(<?php echo HueRotationVarA;?>deg);
        }
        img.dynamicHueImageVarB {
            filter: saturate(80%) hue-rotate(<?php echo HueRotationVarB;?>deg);
        }
        img.dynamicHueImageVarC {
            filter: saturate(80%) hue-rotate(<?php echo HueRotationVarC;?>deg);
        }

        /* todo_TECHDEBT: this is only a helper selector for aligning the rent / return button+text correctly */
        div.marginLeftContainer {
            margin-left: 15px;
        }
        
        input.placeOrderInput {
            border:solid thick grey;  
            background-color: none;
            border-radius: 0.25em; 
            border-width:2px; 
            color: grey;
            font-weight: bold;
            font-size: 18px;
            width: 80px;
            display: flex;
            margin-bottom:2px;
        }
        input.placeOrderInput:hover {
            cursor:pointer;
            border:solid thick <?php echo HighlightColor; ?>; 
            border-width:3px; 
            color: <?php echo HighlightColor; ?>;
        }

        /* variant selection with customized radiobutton BEGIN */        
        .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            user-select: none;
        }
        /* Hide the browser's default radio button */
        .container input {
            position: absolute;
            opacity: 0%;
            cursor: pointer;
        }
		.module_a::before {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #f2af07;
            filter: saturate(80%) hue-rotate(0deg);
            border-radius: 50%;
            border: 4px solid darkgrey;
            content: " ";
        }
        .module_b::before {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #f2af07;
            filter: saturate(80%) hue-rotate(200deg);
            border-radius: 50%;
            border: 4px solid darkgrey;
            content: " ";
        }
        .module_c::before {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #f2af07;
            filter: saturate(80%) hue-rotate(300deg);
            border-radius: 50%;
            border: 4px solid darkgrey;
            content: " ";
        }
        .module-inside {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: none;
            border-radius: 50%;
            border: 4px solid darkgrey;
        }
        /* use pseudoclass with combinators to determine whether a highlight shall be shown on the radiobutton */
        /* todo_TECHDEBT: use a function for this instead of css */
        input:checked + .module_a > .module-inside {
            border: 4px solid aquamarine;
        }
        input:checked + .module_b > .module-inside {
            border: 4px solid aquamarine;
        }
        input:checked + .module_c > .module-inside {
            border: 4px solid aquamarine;
        }
        /* variant selection with customized radiobutton END */
</style>

<?php 
/*
parameter overview:
- $pathToXml: the path to the xml-file to be loaded
*/
function loadXml($pathToXml) 
{
  return simplexml_load_file($pathToXml);
}
/*
parameter overview:
- $xmlTree: the already loaded xml tree to be parsed
- $bikeType: the bikeType to be checked for available variants
- &variant*_Bikes: the variant-specific arrays of all bikes for the given category (pass by reference!)
*/
/* from a given xml, retrieve all available variants of a requested bike category*/
function getVariantsForType($xmlTree, $bikeType, &$variantA_Bikes, &$variantB_Bikes, &$variantC_Bikes)
{
    /* travel through the xml tree */
	foreach($xmlTree as $node) {
	$category = $node->CATEGORY;
    /* only take bikes of requested category into account */
	if($category == $bikeType){
        /* and add the available variants to their corresponding array */
		if($node->VARIANT == "A")
		{
			$variantA_Bikes[] = $node;
		}
		elseif($node->VARIANT == "B")
		{
			$variantB_Bikes[] = $node;
		}
		elseif($node->VARIANT == "C")
		{
			$variantC_Bikes[] = $node;
		}
	}
	}
}
/*
parameter overview:
- $variant: the variant for which the hue is being returned
*/
/* todo_POTENTIALBUG: this is a rather fragile construct as it relies heavily on the class names -> think of a more robust solution */
/*retrieve the hue-class name for a given variant */
function getHueForVariant($variant)
{
	$hue = "dynamicHueImageVarA";
    if($variant == "B")
    {
        $hue = "dynamicHueImageVarB";
    }
    elseif($variant == "C")
    {
        $hue = "dynamicHueImageVarC";
    }
	return $hue;
}

?>
<?php 
/*
parameter overview:
- $config: the configuration for which a bike overview shall be generated (i.e.: are bikes going to be rented, or returned)
- $pathToXmlDB: the path to the xml-"database" that holds the information about a "bikestock"
- $bikeTypes: for which biketypes shall the bike overview be generated
*/
/* create the overview of all bikes in the database (i.e. xml-file) of interest and an according (i.e. "rent" or "return") submit form */
function createBikesOverview($config, $pathToXmlDB, $bikeTypes) {
			$xml = loadXml($pathToXmlDB);
            /* todo_COSMETIC: this variable should be used for setting the (submit-)buttontext */
			$buttonText= "noConfig";
            if($config=="Rental")
			{
			    $buttonText = "Rent";
			}
			elseif($config=="Rented")
			{
			    $buttonText = "Return";
			}
            /* todo_TECHDEBT: make this a constant */
            $bikeIcons = [
                "ROAD" => "./stub_road_category.png",
                "MTB" => "./stub_mtb_category.png",
                "TOURING" => "./stub_touring_category.png"
            ];
            /* the form that submits all booking-data to the bookingoverview*/
            echo '<form method="post" action="BookingOverview.php" name="bookingForm">';
            echo '<div class="flexRow">';
            foreach($bikeTypes as $bikeType)
            {
                $variantA_Bikes = array();
                $variantB_Bikes = array();
                $variantC_Bikes = array();
                
				getVariantsForType($xml, $bikeType, $variantA_Bikes, $variantB_Bikes, $variantC_Bikes);
				$bikeVariants = [$variantA_Bikes, $variantB_Bikes, $variantC_Bikes];
				
				$imgSrc = $bikeIcons[$bikeType];
                
                foreach($bikeVariants as $bikeVar)
                {
                    if($bikeVar) {
                        $node = $bikeVar[0][0];
                    
                        $category = $node->CATEGORY;
                        
                            //todo_SECURITY: ensure that only the allowed variants are taken into account (and dont default to 0° when variant is not supported)
                            $variant = $node->VARIANT;
                            $hue = getHueForVariant($variant);
                            
                            /* todo_TECHDEBT: think of a smarter way to achieve conditional disabling of size-option -> maybe use a local JS-logic */
                            /* todo_TECHDEBT: these could also be put into an array to make potential extension easier lateron */
                            $sizeSHidden = "hidden";
                            $sizeMHidden = "hidden";
                            $sizeLHidden = "hidden";
							$numberBikesS = 0;
							$numberBikesM = 0;
							$numberBikesL = 0;
                            /* is used lateron to show how many bikes for the currently selected variant are available / rented */
							$totalNumberOfBikesForVariant = 0;
                            foreach($bikeVar as $bike)
                            {
                                if($bike->SIZE == "S")
								{
									$sizeSHidden ="";
									$numberBikesS =  $bike->NUMBER_BIKES;
								}
								if($bike->SIZE == "M")
								{
									$sizeMHidden ="";
									$numberBikesM =  $bike->NUMBER_BIKES;
								}
								if($bike->SIZE == "L")
								{
									$sizeLHidden ="";
									$numberBikesL =  $bike->NUMBER_BIKES;
								}
                            }
							$totalNumberOfBikesForVariant = $numberBikesS + $numberBikesM + $numberBikesL;
                            /* todo_TECHDEBT: is there any way to enforce uint values already on xml / dtd side ? */
                            /* ensure that negative numberOfBikes can not happen */
                            if($totalNumberOfBikesForVariant < 0)
                            {
                                $totalNumberOfBikesForVariant = 0;
                            }
							$description = "to return";
							if($config == "Rental")
							{
								$description = "to rent";
							}
                            /* format the string to make parsing easier in the booking overview */
							$parsableBikeDescription = "config=" . $config . "&" . "bikeType=". $bikeType . "&" . "variant=" . $variant;
                            /* (control)variables used for toggling the visibility of the entry of the selected variant (-> JS) */
                            /////////////////////////////////
                            $tile = "var_" . $bikeType . "_" . $variant . "_" . $config;
                            $staticKeyA = "var_" . $bikeType . "_A". "_" . $config;
                            $staticKeyB = "var_" . $bikeType . "_B". "_" . $config;
                            $staticKeyC = "var_" . $bikeType . "_C". "_" . $config;
                            /////////////////////////////////
                            echo <<<OWN
                                    <script>
                                    function toggleVisibilityOfElements(elementToShow, elementToHide_1, elementToHide_2) {
                                        elementToShow.style.display = "block";
                                        elementToHide_1.style.display = "none";
                                        elementToHide_2.style.display = "none";
                                    }
                                    </script>
                                    <div id="$tile" class="bikeToChooseEntry">
                                    <p class="stubImage">($totalNumberOfBikesForVariant x)
                                        <img  class=$hue src=$imgSrc  alt="stub mtb categoryicon" width="100%" heigt="auto">
                                    </p>
                                    <!-- todo_TECHDEBT: only show the variants that are actually available -->
                                    <div class="localFlexRowVariants">
                                        <label class="container">
                                             <input type="radio" name="radio_$bikeType" value="VarA" onclick='toggleVisibilityOfElements(document.getElementById("$staticKeyA"), document.getElementById("$staticKeyB"), document.getElementById("$staticKeyC"))'>
                                             <span class="module_a">
                                                 <span class="module-inside"></span>
                                             </span>
                                        </label>
                                        <label class="container">
                                        <input type="radio" name="radio_$bikeType" value="VarB" onclick='toggleVisibilityOfElements(document.getElementById("$staticKeyB"), document.getElementById("$staticKeyA"), document.getElementById("$staticKeyC"))'>
                                             <span class="module_b">
                                                 <span class="module-inside"></span>
                                             </span>
                                        </label>
                                        <label class="container">
                                        <input type="radio" name="radio_$bikeType" value="VarC" onclick='toggleVisibilityOfElements(document.getElementById("$staticKeyC"), document.getElementById("$staticKeyA"), document.getElementById("$staticKeyB"))'>
                                             <span class="module_c">
                                                  <span class="module-inside"></span>
                                             </span>
                                        </label>
                                    </div>
                                    <!-- hide the input components when there is no bike for the selected variant -->
                                    <!-- todo_COSMETIC: make these inputs appearance match the rest of the application -->
                                    <div $sizeSHidden>
                                    <label>Bikesize: S</label>
                                        <label for="numberOfBikesSizeS_$parsableBikeDescription">number of Bikes $description:</label><br>
                                        <input type="number" id="numberOfBikesSizeS_$parsableBikeDescription" name="size=S&$parsableBikeDescription" value="0" min="0" max=$numberBikesS><br>
                                    </div>
                                    <div $sizeMHidden>
                                    <label>Bikesize: M</label>
                                        <label for="numberOfBikesSizeM_$parsableBikeDescription">number of Bikes $description:</label><br>
                                        <input type="number" id="numberOfBikesSizeM_$parsableBikeDescription" name="size=M&$parsableBikeDescription" value="0" min="0" max=$numberBikesM><br>
                                    </div>
                                    <div $sizeLHidden>
                                    <label>Bikesize: L</label>
                                        <label for="numberOfBikesSizeL_$parsableBikeDescription">number of Bikes $description:</label><br>
                                        <input type="number" id="numberOfBikesSizeL_$parsableBikeDescription" name="size=L&$parsableBikeDescription"value="0"  min="0" max=$numberBikesL><br>
                                    </div>
                                    
                                    </div>
                                    OWN;    
                        
                }
            }
            }
            echo "</div>";
            echo "<br>";
			echo <<<OWN
                    <div class="marginLeftContainer">
                        <input class="placeOrderInput" name="placeOrder" type="submit" value=$buttonText> 
                        <label>selected bikes</label>
                    </div>
                    OWN;
            echo "</form>";
}
?>