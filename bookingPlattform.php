<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookingPlattformTouristikBike</title>
 <link rel="icon" type="image/x-icon" href="favicon.ico">
        <style>
            /*todo: dont redefine the colors, but instead use variables /styles in the like of"mainColor" ...*/
        body {
            /*background-color: #9dd5eb;*/
            background-image: linear-gradient(to right, #9dd5eb, rgba(171,214,221,0.8),  rgba(127,255,212,0.8));
            font-family: Arial, Helvetica, sans-serif;
        }
        h1 {
            color: cadetblue;
            background-image: linear-gradient(to right, rgba(171,214,221,0.8),  rgba(127,255,212,0.5));
            /*background-color: #abd6dd;*/
        }
        select{
            background-color: #63bcdf;
            color: #d2ecf6;
            font-weight: bold;
        }
        input {
            background-color: #63bcdf;
            color: #d2ecf6;
            font-weight: bold;
        }
        hr {
            color: darkgray;
        }
        
        div.bikeToChooseEntry {
            display: flex;
            flex-direction: column;
            margin-left: 15px;
        }
        p.stubImage {
            border:solid thick aquamarine;  
            /*background: #a7dae0; */
            background-image: linear-gradient(to right, rgba(171,214,221,0.9), rgba(127,255,212,0.5));
            border-radius: 0.75em; 
            border-width:5px; 
            margin:2px; 
            width:150px; 
            height:150px;
            align-self: center;
        }

        .flexRow {
            display: flex;
            flex-direction: row;
        }
        img.usericon {
            
        }
        /* todo pass an according parameter (reflecting the variant color from the xml?)), or change the selector class depending on some condition */
        img.dynamicHueImage0 {
            filter: saturate(80%) hue-rotate(0deg);
        }
        img.dynamicHueImage120 {
            filter: saturate(80%) hue-rotate(120deg);
        }
        img.dynamicHueImage300 {
            filter: saturate(80%) hue-rotate(300deg);
        }
        select option[disabled] { color: lightgrey; font-weight: normal; }
        

        /* helper style for visually identifying ToDos*/
        .todo {
            color: red;
        }
        </style>
    </head>
    <body>
        <!-- todo: where to reference the used font? -->
        <!-- font from here: https://www.fontspace.com/new/fonts - "Unbound Gamer" by Iconian Fonts -->
        <img src="./Logo.png" alt="User icon" width="auto" height="auto">
        <br>
        <img class="usericon" src="./AssetCaseStudy_UserIcon.png" alt="User icon" width="50" height="auto">
        <label class="Username">Logged in User</label> <!-- todo: align this under the icon -->
        <h1>Already rented bikes</h1>
        <!-- <div class="flexRow"> -->
        <?php 
            include "outsourcedFunction.php";
            $bikeTypes = ["ROAD","MTB", "TOURING"];
            createRentedBikesOverview("./User1.xml", $bikeTypes);
        ?>
        <div>
            <h1>Choose Date and Category</h1>
            <h4>Select Bookingdate </h4>
            <form>
                <div class="flexRow">
                    <label for="dateFrom">from: 
                        <input type="datetime-local" id="dateFrom" name="dateFrom">
                    </label>
                    <label for="dateTo">to: 
                        <input type="datetime-local" id="dateTo" name="dateTo">
                    </label>
                </div>
            </form>
            <section class="todo">Selected Date: now - then</section> <!-- todo: use the actually set date here-->
            <h4>Select Bike-Category </h4>
            
            

<form method="post" action="" name="form">  
    <!-- todo: visually highlight the selected entry in the list! -->
<select name="bikeCategories" size="3"> <!-- todo: make sure no additional values can be added / submitted lateron via HTML-->
                <option>Road</option>
                <option>Touring</option>
                <option>MTB</option>
            </select>
 <input name="submit" type="submit">
</form>
<?php

if (isset($_POST['bikeCategories']))
{
    $tmp_result = $_POST['bikeCategories'];
    $selectedCategory = strtoupper($tmp_result);
    echo "<br> selected category: $tmp_result";
}
?>

        </div>
        <br>
        <h1>Choose Bikes for rental</h1>
        
        <h4>Select Bikes from Category: <?php echo $selectedCategory; ?> </h4>
        <div class="flexRow">
        <?php 
            createBikesForRentalOverview($selectedCategory);
        ?>
        </div>
        <h1 class="todo"> Submit button missing <h1>
    </body>
</html>