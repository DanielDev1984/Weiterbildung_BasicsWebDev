<?php 
		/*todo outsource these definitions to ColorDefinitions-file*/
		define ('BaseColorBike', '#f2af07'); //rgb(242,175,7)
		define ('HueRotationVarA', '0');
		define ('HueRotationVarB', '200');
		define ('HueRotationVarC', '300');
?>
<!-- todo: outsource this to ColorDefinitions -> problems with multiple declarations / includes -->
<style>
        img.dynamicHueImageVarA {
            filter: saturate(80%) hue-rotate(<?php echo HueRotationVarA;?>deg);
        }
        img.dynamicHueImageVarB {
            filter: saturate(80%) hue-rotate(<?php echo HueRotationVarB;?>deg);
        }
        img.dynamicHueImageVarC {
            filter: saturate(80%) hue-rotate(<?php echo HueRotationVarC;?>deg);
        }
        .circleBase {
			border-radius: 50%;
        }
        .circleVariantA {
            width:  20px;
            height: 20px;
            background: <?php echo BaseColorBike;?>;
            filter: saturate(80%) hue-rotate(<?php echo HueRotationVarA;?>deg);
            
        }
		.circleVariantB {
            width:  20px;
            height: 20px;
            background: <?php echo BaseColorBike;?>;
            filter: saturate(80%) hue-rotate(<?php echo HueRotationVarB;?>deg);
            
        }
		.circleVariantC {
            width:  20px;
            height: 20px;
            background: <?php echo BaseColorBike;?>;
			filter: saturate(80%) hue-rotate(<?php echo HueRotationVarC;?>deg);
            
        }
		.sourrindinCircle {
			width:  24px;
            height: 24px;
            background: none;
			display: flex;
  justify-content: center;
  align-items: center;
            border: 4px solid aquamarine;
		}
		.sourrindinCircle_Off {
			width:  24px;
            height: 24px;
            background: none;
			display: flex;
  justify-content: center;
  align-items: center;
            border: 4px solid rgba(0,0,0,0%);
		}
		.localFlexRow {
            display: flex;
            flex-direction: row;
        }
</style>

<?php 
function loadXml($xmlName) 
{
  return simplexml_load_file($xmlName);
}
function getVariantsForType($xml, $bikeType, &$variantA_Bikes, &$variantB_Bikes, &$variantC_Bikes)
{
	foreach($xml as $node) {
	$category = $node->CATEGORY;
	if($category == $bikeType){
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
function getSizesForVariant($variantSpecificBikes, &$sizesForVariant)
{
	foreach($variantSpecificBikes as $bike)
    {
        $sizesForVariant[] = $bike->SIZE;
    }
}
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
function getHueForVariant_circle($variant)
{
	$hue = "circleVariantA";
    if($variant == "B")
    {
        $hue = "circleVariantB";
    }
    elseif($variant == "C")
    {
        $hue = "circleVariantC";
    }
	return $hue;
}
function getSelectionHighlight($currentVariant, $variant)
{
	$selectionHighlight = "sourrindinCircle_Off";
	if($currentVariant == $variant)
	{
		$selectionHighlight = "sourrindinCircle";
	}
	return $selectionHighlight;
}

?>
<?php /*todo: implement this with factory pattern (or sth more suitable for the task...)*/
function createBikesOverview($config, $user, $bikeTypes) {
			$xml = loadXml($user);
			$buttonText= "noConfig";
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
							//todo: remove hardvoded variants -> iterate over all available variants dynamically
                            $hue_circle_A = getHueForVariant_circle("A");
							$hue_circle_B = getHueForVariant_circle("B");
							$hue_circle_C = getHueForVariant_circle("C");
							$selectionHightlight_A = getSelectionHighlight("A", $variant);
							$selectionHightlight_B = getSelectionHighlight("B", $variant);
							$selectionHightlight_C = getSelectionHighlight("C", $variant);
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
                                    <p class="stubImage">($totalNumberOfBikesForVariant x)
                                        <img class=$hue src=$imgSrc  alt="stub mtb categoryicon" width="100%" heigt="auto">
                                    </p>
                                    <div class="localFlexRow">
                                         <div class="circleBase $selectionHightlight_A">
                                             <div class="circleBase $hue_circle_A"></div>
                                         </div>
                                         <div class="circleBase $selectionHightlight_B">
                                             <div class="circleBase $hue_circle_B"></div>
                                         </div>
                                         <div class="circleBase $selectionHightlight_C">
                                             <div class="circleBase $hue_circle_C"></div>
                                         </div>
                                    </div>
                                    <div $sizeSHidden>
                                    <label>Bikesize: S</label>
                                        <label for="numberOfBikesSizeS_$tmpName">number of Bikes $description:</label><br>
                                        <input type="number" id="numberOfBikesSizeS_$tmpName" name="size=S&$tmpName" value="0" min="0" max=$numberBikesS><br>
                                    </div>
                                    <div $sizeMHidden>
                                    <label>Bikesize: M</label>
                                        <label for="numberOfBikesSizeM_$tmpName">number of Bikes $description:</label><br>
                                        <input type="number" id="numberOfBikesSizeM_$tmpName" name="size=M&$tmpName" value="0" min="0" max=$numberBikesM><br>
                                    </div>
                                    <div $sizeLHidden>
                                    <label>Bikesize: L</label>
                                        <label for="numberOfBikesSizeL_$tmpName">number of Bikes $description:</label><br>
                                        <input type="number" id="numberOfBikesSizeL_$tmpName" name="size=L&$tmpName"value="0"  min="0" max=$numberBikesL><br>
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