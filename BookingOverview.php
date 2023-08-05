<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookingOverview</title>
		<style>
		body {
            background-image: linear-gradient(to right, #9dd5eb, rgba(171,214,221,0.8),  rgba(127,255,212,0.8));
            font-family: Arial, Helvetica, sans-serif;
        }
		h1 {
			color: cadetblue;
			background-image: linear-gradient(to right, rgba(171,214,221,0.9), rgba(127,255,212,0.5));
		}
		input {
			font-size:50px;
			background: aquamarine;
			border-radius: 0.5em;
			margin-left: 15px;
			margin-top: 15px;
		}
		div.row {
			display: flex;
            flex-direction: row;
			gap: 10px;
		}
		div.column {
			display: flex;
            flex-direction: column;
		
		}
		.circleBase {
			border-radius: 50%;
        }
		/*todo: replace all the magic numbers */
        .circleVariantA {
            width:  20px;
            height: 20px;
            background: #f2af07; /* == BaseColorBike*/
            filter: saturate(80%) hue-rotate(0deg);
            
        }
		.circleVariantB {
            width:  20px;
            height: 20px;
            background: #f2af07;
            filter: saturate(80%) hue-rotate(200deg);
            
        }
		.circleVariantC {
            width:  20px;
            height: 20px;
            background: #f2af07;
			filter: saturate(80%) hue-rotate(300deg);
            
        }
		</style>
	</head>
	<body>
		<form method="post" action="bookingPlattform.php" name="testForm">
		<?php
		    function getHueForVariant_circle_local($variant)
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
			//todo: think about how to prevent reiterating over $_POST lateron again... maybe fill the array with all the booking info here already?
			foreach($_POST as $key => $value)
			{
				//todo: cant the config be read from somewhere else? does really every entry have to carry this information?
				if(str_contains($key, "Rented"))
				{
					// when the input comes from the "Rented"-bikes overview, the user wishes to return bikes
					//todo: think of a more intuitive solution for this...
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
			foreach($_POST as $key => $value)
			{
				if($key != "placeOrder" && $value != 0) //prevent printing of "button" info AND dont display entry when nothing is "booked" (i.e. rented or returned)
				{
					$testArray = array();
					
					parse_str($key, $testArray);
					$bikeType = $testArray["bikeType"];
					$bikeVariant = $testArray["variant"];
					$testArray['numberOfBikes'] = $value;
					if($bikeType == "ROAD")
					{
						//add the missing number of bikes value here
						//todo: why is this value not available from the beginning (as all the others?)
						$testArray['numberOfBikes'] = $value;
						$roadArray[] = $testArray;
					}
					elseif($bikeType == "MTB")
					{
						$testArray['numberOfBikes'] = $value;
						$mtbArray[] = $testArray;
					}
					elseif($bikeType == "TOURING")
					{
						$testArray['numberOfBikes'] = $value;
						$touringArray[] = $testArray;
					}
					// remove the biketype as we have a key for this...
					unset($testArray['bikeType']);
					unset($testArray['variant']);
					unset($testArray['config']);
					$bikeArray[$bikeType][$bikeVariant][] = $testArray;
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
						$circleVariant = getHueForVariant_circle_local($variant);
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
		<input name="backToMain" type="submit" value="&#9754">
		</form>
	</body>
</html>