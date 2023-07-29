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
            background-color: #9dd5eb;
            font-family: Arial, Helvetica, sans-serif;
        }
        h1 {
            color: cadetblue;
            background-color: #abd6dd;
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
            background: #a7dae0; 
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
    <body >
        <img src="./AssetCaseStudy_UserIcon.png" alt="User icon" width="50" height="auto">
        <label class="Username">Logged in User</label> <!-- todo: align this under the icon -->
        <h1>Already rented bikes</h1>
        <!-- <div class="flexRow"> -->
        <?php 
            $xml=simplexml_load_file("./User1.xml") or die("Error: Cannot create object");
            /* todo: remove duplicates */
            echo "<section>Road</section>";
            echo '<div class="flexRow">';
            foreach($xml as $node)
            {
                $imgSrc = "./stub_road_category.png";
                $category = $node->CATEGORY;
                if($category == "ROAD")
                {
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
                $numberRentedBikes = $node->RENTED;
            echo <<<OWN
                        <div class="bikeToChooseEntry">
                        <p class="stubImage">Variant $variant Size $size
                            <img class=$hue src=$imgSrc  alt="stub mtb categoryicon" width="100%" heigt="auto">
                        </p>
                        <label>currently rented ($size): $numberRentedBikes</label>
                        <form>
                            <label for="returnBikes">number of Bikes to return:</label><br>
                            <input type="number" id="returnBikes" name="returnBikes" min="0" max=$numberRentedBikes><br>
                        </form>
                        </div>
                    OWN;
                }
            }
            echo "</div>";
            echo "<br>";
            echo "<section>Touring</section>";
            echo '<div class="flexRow">';
            foreach($xml as $node)
            {
                $imgSrc = "./stub_touring_category.png";
                $category = $node->CATEGORY;
                if($category == "TOURING")
                {
                    
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
                $numberRentedBikes = $node->RENTED;
            echo <<<OWN
                        <div class="bikeToChooseEntry">
                        <p class="stubImage">Variant $variant Size $size
                            <img class=$hue src=$imgSrc  alt="stub mtb categoryicon" width="100%" heigt="auto">
                        </p>
                        <label>currently rented ($size): $numberRentedBikes</label>
                        <form>
                            <label for="returnBikes">number of Bikes to return:</label><br>
                            <input type="number" id="returnBikes" name="returnBikes" min="0" max=$numberRentedBikes><br>
                        </form>
                        </div>
                    OWN;
                }
            }
            echo "</div>";
            echo "<br>";
            echo "<section>MTB</section>";
            echo '<div class="flexRow">';
            foreach($xml as $node)
            {
                $imgSrc = "./stub_mtb_category.png";
                $category = $node->CATEGORY;

                if($category == "MTB")
                {
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
                $numberRentedBikes = $node->RENTED;
            echo <<<OWN
                        <div class="bikeToChooseEntry">
                        <p class="stubImage">Variant $variant Size $size
                            <img class=$hue src=$imgSrc  alt="stub mtb categoryicon" width="100%" heigt="auto">
                        </p>
                        <label>currently rented ($size): $numberRentedBikes</label>
                        <form>
                            <label for="returnBikes">number of Bikes to return:</label><br>
                            <input type="number" id="returnBikes" name="returnBikes" min="0" max=$numberRentedBikes><br>
                        </form>
                        </div>
                    OWN;
                }
            }
            echo "</div>";
        ?>
        </div>
        <div>
            <h1>Choose Date and Category</h1>
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
        <hr></hr>
        <h1>Choose Bikes for rental</h1>
        
        <h4>Select Bikes from Category: <?php echo $selectedCategory; ?> </h4>
        <!-- todo: outsource this to extra function -->
        <?php 
            $xml=simplexml_load_file("./BikeStock.xml") or die("Error: Cannot create object");
            

            $variantA_Bikes = array();
            $variantB_Bikes = array();
            $variantC_Bikes = array();
            foreach($xml as $node)
            {
                if($node->VARIANT == "A" && ($node->CATEGORY == $selectedCategory))
                {
                    $variantA_Bikes[]= $node;
                }
                if($node->VARIANT == "B" && ($node->CATEGORY == $selectedCategory))
                {
                    $variantB_Bikes[]= $node;
                }
                if($node->VARIANT == "C" && ($node->CATEGORY == $selectedCategory))
                {
                    $variantC_Bikes[]= $node;
                }
            }

            $sizesVarA = array();
            foreach($variantA_Bikes as $bikeA)
            {
                $sizesVarA[] = $bikeA->SIZE;
            }
            $sizesVarB = array();
            foreach($variantB_Bikes as $bikeB)
            {
                $sizesVarB[] = $bikeB->SIZE;
            }
            $sizesVarC = array();
            foreach($variantC_Bikes as $bikeC)
            {
                $sizesVarC[] = $bikeC->SIZE;
            }
            $bikeVariants = [$variantA_Bikes, $variantB_Bikes, $variantC_Bikes];
            
        ?>
        <div class="flexRow">
        <?php 
            //$xml=simplexml_load_file("./BikeStock.xml") or die("Error: Cannot create object");
            //foreach($xml as $node)
            foreach($bikeVariants as $bikeVar)
            {
                if($bikeVar) {
                    $node = $bikeVar[0][0];
                    // default to roadbike-icon
                //todo: ensure that only the allowed categories are taken into account (and dont default to roadbike-icon when category is not supported)
                $imgSrc = "./stub_road_category.png";
                $category = $node->CATEGORY;
                if($selectedCategory == $category)
                {

                
                if($category == "MTB")
                {
                    $imgSrc = "./stub_mtb_category.png";
                }
                elseif($category == "TOURING")
                {
                    $imgSrc = "./stub_touring_category.png";
                }
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
        </div>
        <h1 class="todo"> Submit button missing <h1>
    </body>
</html>