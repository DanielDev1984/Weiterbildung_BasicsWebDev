<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookingOverview</title>
		<style>
			<?php 
                /* just make sure that all needed color definitions are available */
                require_once("ColorDefinitions.php");
            ?>
			body {
				/* todo_TECHDEBT: use global style instead of redefinition */
            	background-image: <?php getBgImageWindow();?>;
            	font-family: Arial, Helvetica, sans-serif;
        	}
			h1 {
				/* todo_TECHDEBT: use global style instead of redefinition */
				color: <?php echo MainTextColor; ?>; 
            	background-image: <?php getBgMainText();?>;
			}
			input.cancel {
				font-size:60px;
				background: none;
				color: grey;
				cursor: pointer;
				border:none;  
				min-width:60px;
				min-height:60px;
				margin-left: 15px;
				margin-top: 15px;
				align-self: center;
			}
			input.cancel:hover {
            	color: <?php echo HighlightColor; ?>; 
			}
			input.confirm {
				font-size:60px;
				background: none;
				color: grey;
				cursor: pointer;
				border: none;
				min-width:60px;
				min-height:60px;
				margin-left: 15px;
				margin-top: 15px;
				align-self: center;
			}
			input.confirm:hover {
            	color: <?php echo HighlightColor; ?>; 
			}
			/* todo_TECHDEBT: these layouting schemes dont have to be defined in every used file... */
			div.row {
				display: flex;
            	flex-direction: row;
				gap: 10px;
			}
			div.column {
				display: flex;
            	flex-direction: column;
			}
			/* visual cues ("circles") indicating the variant of the booked bikes */
			.circleBase {
				border-radius: 50%;
        	}
			/* todo_TECHDEBT: dont redefine the visual appearance of the variant-indicators here again as they look the same on the "booking"-side as well */
        	.circleVariantA {
            	width:  20px;
            	height: 20px;
            	background: <?php echo BaseColorBike;?>; /* == BaseColorBike*/
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
		</style>
	</head>
	<body>
		<!-- return back to bookingPlattform -->
		<!-- todo_TECHDEBT: is there no way to prevent complete reloading of "index"-page? maybe sth with AJAX? -->
		<form method="post" action="bookingPlattform.php">
		<?php
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
			$overviewSubTitle = "rented";
			//todo_TECHDEBT: think about how to prevent reiterating over $_POST lateron again... maybe fill the array with all the booking info here already?
			/* retrieve info about source of the data -> are bikes meant to be returned, or booked? */
			foreach($_POST as $key => $value)
			{
				//todo_TECHDEBT: cant the config be read from somewhere else? does really every entry has to carry this information?
				if(str_contains($key, "Rented"))
				{
					// when the input comes from the "Rented"-bikes overview, the user wishes to return bikes
					//todo_POTENTIALBUG: think of a more intuitive solution for this...
					$overviewSubTitle = "returned";
					break;
				}
			}
			echo "<h1>Booking overview (to be $overviewSubTitle bikes)</h1>";
			echo "<br>";
			$roadArray = array();
			$mtbArray = array();
			$touringArray = array();
			$bikeArray = array(array(array()));
			/* todo_TECHDEBT: atm the key carries almost all (except for numberOfBikes) relevant info regarding the bikes -> make this nicer! */
			/* todo_TECHDEBT: this is a rather cumbersome way of extracting the needed data -> think of sth more intuitive / easier */
			/* structure (i.e. sort according to category, variant, size) the bookingData to make it easier for displaying these lateron */
			foreach($_POST as $key => $value)
			{
				//todo_POTENTIALBUG: this condition is rather brute force / not intelligent... how to make it nicer?
				/* only read the data that actually comes from the bikes(xml) and ignore other potential info in $_POST */
				if($key != "placeOrder" && !(str_contains($key, "radio")) && $value != 0) //prevent printing of "button" info AND dont display entry when nothing is "booked" (i.e. rented or returned)
				{
					$bikeInfo = array();
					/* parse the relevant info into the according key => value pairs */
					parse_str($key, $bikeInfo);
					/* add number of bikes as this is not part of the parsed data */
					$bikeInfo['numberOfBikes'] = $value;
					/* todo_POTENTIALBUG: this only works if the string-format fits the name of the used keys -> can(`t) this be made more flexible? */
					if(array_key_exists("bikeType", $bikeInfo))
					{
						$bikeType = $bikeInfo["bikeType"];
					}
					else
					{
						/* todo_TECHDEBT: add errorhandling (e.g. consoleLog, die(), setDefaultValue(), ...) */
					}

					if(array_key_exists("variant", $bikeInfo))
					{
						$bikeVariant = $bikeInfo["variant"];
					}
					else
					{
						/* todo_TECHDEBT: add errorhandling (e.g. consoleLog, die(), setDefaultValue(), ...) */
					}
					
					if($bikeType == "ROAD")
					{
						$roadArray[] = $bikeInfo;
					}
					elseif($bikeType == "MTB")
					{
						$mtbArray[] = $bikeInfo;
					}
					elseif($bikeType == "TOURING")
					{
						$touringArray[] = $bikeInfo;
					}
					// remove some keys before copying the data into a more structured array
					unset($bikeInfo['bikeType']);
					unset($bikeInfo['variant']);
					unset($bikeInfo['config']);
					
					$bikeArray[$bikeType][$bikeVariant][] = $bikeInfo;
				}
			}
			foreach($bikeArray as $bikeCategory => $valuesOfCategory)
			{
				if($bikeCategory != "0")
				{
					echo "<h1> Bike category: " . $bikeCategory . "</h1>";
					foreach($valuesOfCategory as $variant => $valuesOfVariant)
					{
						echo '<div class="row">';
						$circleVariant = getHueForVariant_circle($variant);
                    	echo <<<OWN
								<div class="circleBase $circleVariant"></div>
								OWN;
						foreach($valuesOfVariant as $variantInfo => $value)
						{
							foreach($value as $tag => $tagValue)
							{
								echo $tag . ": " . $tagValue . " ";
							}
							echo "<br>"	;
						}
						echo "</div>";
						echo "<hr>";
					}
				}
			}
		?>
		<br>
		<!-- todo_COSMETIC: replace "hand"-icon with arrow -->
		<input class="cancel" name="cancelBooking" type="submit" value="&#128913">
		<!-- todo_TECHDEBT: shouldnt lead back to "landing"-page -->
		<input class="confirm"name="confirmBooking" type="submit" value="&#128917">
		</form>
	</body>
</html>