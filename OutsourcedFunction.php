<?php 
function loadXml($xmlName) 
{
  return simplexml_load_file($xmlName);
}
function getVariantsForType($xml, $bikeType, &$variantA_Bikes, &$variantB_Bikes, &$variantC_Bikes)
{
	//$bikeTypes = ["ROAD","MTB", "TOURING"];
	foreach($xml as $node) {
	$category = $node->CATEGORY;
	//echo "$category <br>"; 
	//echo "$bikeType <br>";
	if($category == $bikeType){
		if($node->VARIANT == "A")
		{
			//echo "varA";
			$variantA_Bikes[] = $node;
		}
		elseif($node->VARIANT == "B")
		{
			//echo "varB";
			$variantB_Bikes[] = $node;
		}
		elseif($node->VARIANT == "C")
		{
			//echo "varC";
			$variantC_Bikes[] = $node;
		}
	}
	}
}
function getSizesForVariant($variantSpecificBikes, &$sizesForVariant)
{
	foreach($variantSpecificBikes as $bike)
    {
        $sizesForVariant[] = $bike->SIZE;
    }
}
?>
<?php
function createBikesForRentalOverview($selectedCategory) {
	$xml = loadXml("./BikeStock.xml");

           $variantA_Bikes = array();
           $variantB_Bikes = array();
           $variantC_Bikes = array();
           getVariantsForType($xml, $selectedCategory, $variantA_Bikes, $variantB_Bikes, $variantC_Bikes);
           
           $sizesVarA_Bikes = array();
		   getSizesForVariant($variantA_Bikes, $sizesVarA_Bikes);
           $sizesVarB_Bikes = array();
		getSizesForVariant($variantB_Bikes, $sizesVarB_Bikes);
           $sizesVarC_Bikes = array();
		getSizesForVariant($variantC_Bikes, $sizesVarC_Bikes);

           $bikeVariants = [$variantA_Bikes, $variantB_Bikes, $variantC_Bikes];
	foreach($bikeVariants as $bikeVar)
            {
                if($bikeVar) {
                    $node = $bikeVar[0][0];
                    // default to roadbike-icon
                //todo: ensure that only the allowed categories are taken into account (and dont default to roadbike-icon when category is not supported)
                
                $category = $node->CATEGORY;
                $bikeIcons = [
					"ROAD" => "./stub_road_category.png",
					"MTB" => "./stub_mtb_category.png",
					"TOURING" => "./stub_touring_category.png"
				];
				$imgSrc = $bikeIcons[$selectedCategory];
                $size = $node->SIZE;
                $inStock = $node->IN_STOCK;
                //echo "cat: $category <br> size: $size <br> in stock: $inStock";
                // default to red / 0° (hsv-model)
                //todo: ensure that only the allowed variants are taken into account (and dont default to 0° when variant is not supported)
                $variant = $node->VARIANT;
                $hue = "dynamicHueImage0";
                if($variant == "A")
                {
                    $hue = "dynamicHueImage120";
                }
                elseif($variant == "B")
                {
                    $hue = "dynamicHueImage300";
                }
                /* todo: think of a smarter way to achieve conditional disabling of size-option*/
                $sizeSDisabled = "disabled";
                $sizeMDisabled = "disabled";
                $sizeLDisabled = "disabled";
                $sizeSHidden = "hidden";
                $sizeMHidden = "hidden";
                $sizeLHidden = "hidden";
                $availableBikesS = 0;
                $availableBikesM = 0;
                $availableBikesL = 0;
                foreach($bikeVar as $bike)
                {
                    if($bike->SIZE == "S")
                    {
                        $availableBikesS = $bike->IN_STOCK;
                        $sizeSDisabled = "";
                        $sizeSHidden ="";
                    }
                    if($bike->SIZE == "M")
                    {
                        $availableBikesM = $bike->IN_STOCK;
                        $sizeMDisabled = "";
                        $sizeMHidden ="";
                    }
                    if($bike->SIZE == "L")
                    {
                        $availableBikesL = $bike->IN_STOCK;
                        $sizeLDisabled = "";                     
                        $sizeLHidden ="";
                    }
                }
                
                
				
                /* todo: dont use select-tag for bike sizes... atm they only hold one option */
                echo <<<OWN
                        <div class="bikeToChooseEntry">
                        <p class="stubImage">Variant $variant
                            <img class=$hue src=$imgSrc  alt="stub mtb categoryicon" width="100%" heigt="auto">
                        </p>
                        <div $sizeSHidden>
                        <label>Bikesize: S</label>
                        <form>
                            <label for="numberOfBikesSizeS">number of Bikes:</label><br>
                            <input type="number" id="numberOfBikesSizeS" name="numberOfBikesSizeS" min="0" max=$availableBikesS><br>
                        </form>
                        </div>
                        <div $sizeMHidden>
                        <label>Bikesize: M</label>
                        <form>
                            <label for="numberOfBikesSizeM">number of Bikes:</label><br>
                            <input type="number" id="numberOfBikesSizeM" name="numberOfBikesSizeM" min="0" max=$availableBikesM><br>
                        </form>
                        </div>
                        <div $sizeLHidden>
                        <label>Bikesize: L</label>
                        <form>
                            <label for="numberOfBikesSizeL">number of Bikes:</label><br>
                            <input type="number" id="numberOfBikesSizeL" name="numberOfBikesSizeL" min="0" max=$availableBikesL><br>
                        </form>
                        </div>
                        </div>
                        OWN;
			}
            }
}
?>
<?php
function createRentedBikesOverview($user, $bikeTypes) {
			$xml = loadXml($user);
            /* todo this should be outsourced to a dedicated function than it could easily be used in the lateron used "Choose Bikes for rental" UI */
            //$bikeTypes = ["ROAD","MTB", "TOURING"];
            foreach($bikeTypes as $bikeType)
            {
                echo "<h4>$bikeType</h4>";
                echo '<div class="flexRow">';
                $variantA_Bikes = array();
                $variantB_Bikes = array();
                $variantC_Bikes = array();
                
				getVariantsForType($xml, $bikeType, $variantA_Bikes, $variantB_Bikes, $variantC_Bikes);
				
                $sizesVarA_Bikes = array();
				getSizesForVariant($variantA_Bikes, $sizesVarA_Bikes);
                $sizesVarB_Bikes = array();
				getSizesForVariant($variantB_Bikes, $sizesVarB_Bikes);
                $sizesVarC_Bikes = array();
				getSizesForVariant($variantC_Bikes, $sizesVarC_Bikes);
				
                $bikeVariants = [$variantA_Bikes, $variantB_Bikes, $variantC_Bikes];

				$bikeIcons = [
					"ROAD" => "./stub_road_category.png",
					"MTB" => "./stub_mtb_category.png",
					"TOURING" => "./stub_touring_category.png"
				];
				$imgSrc = $bikeIcons[$bikeType];
                
                foreach($bikeVariants as $bikeVar)
                {
                    if($bikeVar) {
                        $node = $bikeVar[0][0];
                    
                        $category = $node->CATEGORY;
                        {
                            $size = $node->SIZE;
                            $inStock = $node->IN_STOCK;
                            //todo: ensure that only the allowed variants are taken into account (and dont default to 0° when variant is not supported)
                            $variant = $node->VARIANT;
                            $hue = "dynamicHueImage0";
                            if($variant == "A")
                            {
                                $hue = "dynamicHueImage120";
                            }
                            elseif($variant == "B")
                            {
                                $hue = "dynamicHueImage300";
                            }
                            $numberRentedBikes = $node->RENTED;
                            /* todo: think of a smarter way to achieve conditional disabling of size-option*/
                            $sizeSDisabled = "disabled";
                            $sizeMDisabled = "disabled";
                            $sizeLDisabled = "disabled";
                            $sizeSHidden = "hidden";
                            $sizeMHidden = "hidden";
                            $sizeLHidden = "hidden";
                            $availableBikesS = 0;
                            $availableBikesM = 0;
                            $availableBikesL = 0;
                            $rentedBikesS = 0;
                            $rentedBikesM = 0;
                            $rentedBikesL = 0;
                            foreach($bikeVar as $bike)
                            {
                                if($bike->SIZE == "S")
                                {
                                    $availableBikesS = $bike->IN_STOCK;
                                    $sizeSDisabled = "";
                                    $sizeSHidden ="";
                                    $rentedBikesS = $bike->RENTED;
                                }
                                if($bike->SIZE == "M")
                                {
                                    $availableBikesM = $bike->IN_STOCK;
                                    $sizeMDisabled = "";
                                    $sizeMHidden ="";
                                    $rentedBikesM = $bike->RENTED;
                                }
                                if($bike->SIZE == "L")
                                {
                                    $availableBikesL = $bike->IN_STOCK;
                                    $sizeLDisabled = "";                     
                                    $sizeLHidden ="";
                                    $rentedBikesL = $bike->RENTED;
                                }
                            }
                            echo <<<OWN
                                    <div class="bikeToChooseEntry">
                                    <p class="stubImage">Variant $variant
                                        <img class=$hue src=$imgSrc  alt="stub mtb categoryicon" width="100%" heigt="auto">
                                    </p>
                                    <div $sizeSHidden>
                                    <label>Bikesize: S</label>
                                    <form>
                                        <label for="numberOfBikesSizeS_toReturn">number of Bikes to retrun:</label><br>
                                        <input type="number" id="numberOfBikesSizeS_toReturn" name="numberOfBikesSizeS_toReturn" min="0" max=$rentedBikesS><br>
                                    </form>
                                    </div>
                                    <div $sizeMHidden>
                                    <label>Bikesize: M</label>
                                    <form>
                                        <label for="numberOfBikesSizeM_toReturn">number of Bikes to retrun:</label><br>
                                        <input type="number" id="numberOfBikesSizeM_toReturn" name="numberOfBikesSizeM_toReturn" min="0" max=$rentedBikesM><br>
                                    </form>
                                    </div>
                                    <div $sizeLHidden>
                                    <label>Bikesize: L</label>
                                    <form>
                                        <label for="numberOfBikesSizeL_toReturn">number of Bikes to return:</label><br>
                                        <input type="number" id="numberOfBikesSizeL_toReturn" name="numberOfBikesSizeL_toReturn" min="0" max=$rentedBikesL><br>
                                    </form>
                                    </div>
                                    </div>
                                    OWN;
                        }
                }
            }
            echo "</div>";
            }
}	
        ?>