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
		}
		div.column {
			display: flex;
            flex-direction: column;
		}
		</style>
	</head>
	<body>
		<form method="post" action="bookingPlattform.php" name="testForm">
		<?php
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
			foreach($_POST as $key => $value)
			{
				if($key != "placeOrder" && $value != 0) //prevent printing of "button" info AND dont display entry when nothing is "booked" (i.e. rented or returned)
				{
					//todo: make horizontal lines / separators shorter
					echo "<hr>";
					$testArray = array();
					parse_str($key, $testArray);
					//print_r($testArray);
					echo '<div class="row">';
					echo '<div class="column">';
					foreach($testArray as $arrayKey => $arrayVal)
					{
						echo $arrayKey . ":" . $arrayVal . "<br>";
					}
					echo "</div>";
					echo "Number of bikes:" . $value;
					//echo "configuration: $testArray['config']";
					echo "<br>";
					//echo "$key : $value";	
					echo "</div>";
				}
			}
		?>
		<br>
		<input name="backToMain" type="submit" value="&#9754">
		</form>
	</body>
</html>