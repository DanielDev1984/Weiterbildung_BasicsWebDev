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
            background-color: #E8E9EA;
            font-family: Arial, Helvetica, sans-serif;
        }
        h1 {
            color: aquamarine;
            background-color: darkgrey;
        }
        select{
            background-color: darkgray;
            color: beige;
            font-weight: bold;
        }
        input {
            background-color: darkgray;
            color: beige;
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
            border:solid thick darkgray;  
            background: aquamarine; 
            border-radius: 0.5em; 
            border-width:2px; 
            margin:2px; 
            width:150px; 
            height:150px;
            align-self: center;
        }

        .flexRow {
            display: flex;
            flex-direction: row;
        }
        /* todo pass an according parameter (reflecting the variant color from the xml?)), or change the selector class depending on some condition */
        img.dynamicHueImage0 {
            filter: hue-rotate(0deg);
        }
        img.dynamicHueImage270 {
            filter: hue-rotate(270deg);
        }
        img.dynamicHueImage300 {
            filter: hue-rotate(300deg);
        }

        /* helper style for visually identifying ToDos*/
        .todo {
            color: red;
        }
        </style>
    </head>
    <body >
        <img src="./AssetCaseStudy_UserIcon.png" alt="User icon" width="50" height="auto">
        <label class="Username">Logged in User</label> <!-- todo: align this under the icon -->
        <div>
            <h1>Choose Date and Category</h1>
            <section class="todo">Selected Date: now - then</section> <!-- todo: use the actually set date here-->
            <section class="todo">Selected Category:</section> <!-- todo: use the actually set category here-->
            <hr>
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
            <h4>Select Bike-Category </h4>
            <select name="bikeCategories" size="3"> <!-- todo: make sure no additional values can be added / submitted lateron via HTML-->
                <option>Road</option>
                <option>Touring</option>
                <option>MTB</option>
            </select>
        </div>
        <br>
        <hr></hr>
        <h1>Choose Bikes for rental</h1>
        <h4 class="todo">Select Bikes from Category: CATEGORY MISSING </h4>
        <div class="flexRow">
        <?php 
            $xml=simplexml_load_file("./BikeStock.xml") or die("Error: Cannot create object");
            foreach($xml as $node)
            {
                $category = $node->CATEGORY;
                $size = $node->SIZE;
                $inStock = $node->IN_STOCK;
                echo "$category <br> $size <br> $inStock";
                $variant = $node->VARIANT;
                $hue = "dynamicHueImage0";
                if($variant == "A")
                {
                    $hue = "dynamicHueImage270";
                }
                elseif($variant == "B")
                {
                    $hue = "dynamicHueImage300";
                }
                
                echo <<<OWN
                        <div class="bikeToChooseEntry">
                        <p class="stubImage">Variant $variant
                            <img class=$hue src="./stub_mtb_category.png"  alt="stub mtb categoryicon" width="100%" heigt="auto">
                        </p>
                        <label >Bikesize:
                        </label>
                        <select name="bikeSize" size="3"> <!-- todo: make sure no additional values can be added / submitted lateron via HTML-->
                            <option>S</option>
                            <option>M</option>
                            <option>L</option>
                        </select>
                        <form>
                            <label for="numberOfBikes">number of Bikes:</label><br>
                            <input type="number" id="numberOfBikes" name="numberOfBikes"><br>
                        </form>
                        </div>
                        OWN;
            }
        ?>
        </div>
    </body>
</html>