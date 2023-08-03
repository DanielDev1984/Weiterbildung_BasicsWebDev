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
        input[type='checkbox'] {
            display:none;
        }
        .collapsible-content {
            max-height: 10px;
            overflow: hidden;
            transition: max-height 0.8s ease-in-out;
        }

        .toggle {
            color: cadetblue;
            background-image: linear-gradient(to right, rgba(171,214,221,0.8),  rgba(127,255,212,0.5));
            
            display: block; /*needed for the css styled arrow: https://css-tricks.com/snippets/css/css-triangle/*/
            font-weight: bold;
            font-size: 30px;
            transition: all 0.25s ease-out;
        }
        .toggle:hover {
            color: aquamarine;
        }
        /*needed for the css styled arrow: https://css-tricks.com/snippets/css/css-triangle/*/
        .toggle::before {
            content: ' ';
            display: inline-block;

            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-left: 10px solid currentColor;

            vertical-align: middle;
            margin-right: .7rem;
            transform: translateY(-25%);

            transition: transform .2s ease-out;
        }
        .toggle_cb:checked + .toggle::before {
            transform: rotate(90deg) translateX(-3px);
        }
        .toggle_cb:checked + .toggle + .collapsible-content {
            max-height: 100vh;
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
        .flexColumn {
            display: flex;
            flex-direction: column;
        }
        img.usericon {
            margin: 10px;
            align-self: right;
        }
        img.companyLogo {
            margin: 10px;
            align-self: center;
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
        <div class="flexRow">
            <img class="companyLogo" src="./Logo.png" alt="User icon" width="auto" height="100%">
            <div class="flexColumn">
                <img class="usericon" src="./AssetCaseStudy_UserIcon.png" alt="User icon" width="80" height="80">
                <label class="Username">Logged in User</label> <!-- todo: align this under the icon -->
            </div>
        </div>
        <br>
        <!-- collapsible with css only: https://www.digitalocean.com/community/tutorials/css-collapsible -->
        <div class="wrap-collapsible">
            <input id="collapsible" class="toggle_cb" type="checkbox">
            <label for="collapsible" class="toggle">Already rented bikes</label>
            <!-- <div class="flexRow"> -->
            <div class="collapsible-content">
                <?php 
                    include "outsourcedFunction.php";
                    $bikeTypes = ["ROAD","MTB", "TOURING"];
                    //echo '<form method="post" action="" name="testForm">';
                    createBikesOverview("Rented","./User1.xml", $bikeTypes);
                    //echo '<input name="testForm" type="submit">';
                    //echo "</form>";
                ?>
            </div>
        </div>
        
        <section class="todo">Submitbutton missing</section> 
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
if (isset($_POST['numberOfBikesSizeS']))
{
    $tmp_result = $_POST['numberOfBikesSizeS'];
    
    echo "<br> : $tmp_result";
}
?>

        </div>
        <br>
        <h1>Choose Bikes for rental</h1>
        <?php 
            $category = [strtoupper($selectedCategory)];
            createBikesOverview("Rental", "./BikeStock.xml", $category);
        ?>
        <section class="todo">Submitbutton missing</section> 
    </body>
</html> 