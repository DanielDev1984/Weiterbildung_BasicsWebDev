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
		</style>
	</head>
	<body>
	<h1>Booking overview</h1>
		<form method="post" action="bookingPlattform.php" name="testForm">
		<?php
			foreach($_POST as $key => $value)
			{
				echo "$key = $value <br>";
			}
		?>
		<input name="backToMain" type="submit" value="&#9754">
		</form>
	</body>
</html>