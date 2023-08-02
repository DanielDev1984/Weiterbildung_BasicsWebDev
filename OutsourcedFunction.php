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
function getHueForVariant($variant)
{
	$hue = "dynamicHueImage0";
    if($variant == "A")
    {
        $hue = "dynamicHueImage120";
    }
    elseif($variant == "B")
    {
        $hue = "dynamicHueImage300";
    }
	return $hue;
}
?>
<?php
function createBikesOverview($config, $user, $bikeTypes) {
			$xml = loadXml($user);
			$buttonText= "noConfig";
            /* todo this should be outsourced to a dedicated function than it could easily be used in the lateron used "Choose Bikes for rental" UI */
            echo '<form method="post" action="BookingOverview.php" name="testForm">';
            foreach($bikeTypes as $bikeType)
            {
                if($config=="Rental")
			{
				$buttonText = "Rent bikes";
				echo "<h4>Select Bikes from Category: $bikeType;</h4>";
			}
			elseif($config=="Rented")
			{
				$buttonText = "Return bikes";
				echo "<h4>Rented bikes $bikeType</h4>";
			}
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
                        
                            //todo: ensure that only the allowed variants are taken into account (and dont default to 0° when variant is not supported)
                            $variant = $node->VARIANT;
                            $hue = getHueForVariant($variant);
                            $numberRentedBikes = $node->RENTED;
                            /* todo: think of a smarter way to achieve conditional disabling of size-option*/
                            $sizeSHidden = "hidden";
                            $sizeMHidden = "hidden";
                            $sizeLHidden = "hidden";
							$numberBikesS = 0;
							$numberBikesM = 0;
							$numberBikesL = 0;
                            $rentedBikesS = 0;
                            $rentedBikesM = 0;
                            $rentedBikesL = 0;
							$totalNumberOfBikesForVariant = 0;
                            foreach($bikeVar as $bike)
                            {
                                if($bike->SIZE == "S")
								{
									$sizeSHidden ="";
									if($config == "Rental")
									{
										$numberBikesS =  $bike->IN_STOCK;
									}
									else 
									{
										$numberBikesS =  $bike->RENTED;
									}
								}
								if($bike->SIZE == "M")
								{
									$sizeMHidden ="";
									if($config == "Rental")
									{
										$numberBikesM =  $bike->IN_STOCK;
									}
									else
									{
										$numberBikesM =  $bike->RENTED;
									}
								}
								if($bike->SIZE == "L")
								{
									$sizeLHidden ="";
									if($config == "Rental")
									{
										$numberBikesL =  $bike->IN_STOCK;
									}
									else
									{
										$numberBikesL =  $bike->RENTED;
									}
								}
                            }
							$totalNumberOfBikesForVariant = $numberBikesS + $numberBikesM + $numberBikesL;
							$description = "to return";
							if($config == "Rental")
							{
								$description = "to rent";
							}
							$tmpName = "config=" . $config . "&" . "bikeType=". $bikeType . "&" . "variant=" . $variant;
                            echo <<<OWN
                                    <div class="bikeToChooseEntry">
                                    <p class="stubImage">Variant $variant ($totalNumberOfBikesForVariant x)
                                        <img class=$hue src=$imgSrc  alt="stub mtb categoryicon" width="100%" heigt="auto">
                                    </p>
                                    <div $sizeSHidden>
                                    <label>Bikesize: S</label>
                                        <label for="numberOfBikesSizeS_$tmpName">number of Bikes $description:</label><br>
                                        <input type="number" id="numberOfBikesSizeS_$tmpName" name="size=S&$tmpName" value="0" min="0" max=$numberBikesS><br>
                                        <!-- <input type="text" id="VariantSizeS_$tmpName" name="currentVariant_S_$tmpName" value=$variant></input><br> -->
                                    </div>
                                    <div $sizeMHidden>
                                    <label>Bikesize: M</label>
                                        <label for="numberOfBikesSizeM_$tmpName">number of Bikes $description:</label><br>
                                        <input type="number" id="numberOfBikesSizeM_$tmpName" name="size=M&$tmpName" value="0" min="0" max=$numberBikesM><br>
                                        <!-- <input type="text" id="VariantSizeM_$tmpName" name="currentVariant_M_$tmpName" value=$variant></input><br> -->
                                    </div>
                                    <div $sizeLHidden>
                                    <label>Bikesize: L</label>
                                        <label for="numberOfBikesSizeL_$tmpName">number of Bikes $description:</label><br>
                                        <input type="number" id="numberOfBikesSizeL_$tmpName" name="size=L&$tmpName"value="0"  min="0" max=$numberBikesL><br>
                                        <!-- <input type="text" id="VariantSizeL_$tmpName" name="currentVariant_L_$tmpName" value=$variant></input><br> -->
                                    </div>
                                    </div>
                                    OWN;
                        
                }
            }
            echo "</div>";
            }
			echo '<section class="todo">make button text dynamic</section>';
			echo '<input name="placeOrder" type="submit">';
			
            echo "</form>";
}
?>