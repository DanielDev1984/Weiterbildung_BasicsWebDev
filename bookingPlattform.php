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
            $xml=simplexml_load_file("./User1.xml") or die("Error: Cannot create object");
            /* todo: remove duplicates */
            echo "<h4>Road</h4>";
            echo '<div class="flexRow">';
            $variantA_RoadBikes = array();
            $variantB_RoadBikes = array();
            $variantC_RoadBikes = array();
            foreach($xml as $node) {
                $category = $node->CATEGORY;
                if($category == "ROAD"){
                    if($node->VARIANT == "A" )
                        {
                            $variantA_RoadBikes[]= $node;
                        }
                    if($node->VARIANT == "B" )
                        {
                            $variantB_RoadBikes[]= $node;
                        }
                    if($node->VARIANT == "C" )
                        {
                            $variantC_RoadBikes[]= $node;
                        }
                    }
            }
            $sizesVarA_Road = array();
            foreach($variantA_RoadBikes as $bikeA)
            {
                $sizesVarA_Road[] = $bikeA->SIZE;
            }
            $sizesVarB_Road = array();
            foreach($variantB_RoadBikes as $bikeB)
            {
                $sizesVarB_Road[] = $bikeB->SIZE;
            }
            $sizesVarC_Road = array();
            foreach($variantC_RoadBikes as $bikeC)
            {
                $sizesVarC_Road[] = $bikeC->SIZE;
                
            }
            $bikeVariants = [$variantA_RoadBikes, $variantB_RoadBikes, $variantC_RoadBikes];
            foreach($bikeVariants as $bikeVar)
            {
                if($bikeVar) {
                    $node = $bikeVar[0][0];
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
                $rentedBikesS = 0;
                $rentedBikesM = 0;
                $rentedBikesL = 0;
                foreach($bikeVar as $bike)
                {
                    if($bike->SIZE == "S")
                    {
                        $availableBikesS = $bike->IN_STOCK;
                        $sizeSDisabled = "";
                        $sizeSHidden ="";
                        $rentedBikesS = $bike->RENTED;
                    }
                    if($bike->SIZE == "M")
                    {
                        $availableBikesM = $bike->IN_STOCK;
                        $sizeMDisabled = "";
                        $sizeMHidden ="";
                        $rentedBikesM = $bike->RENTED;
                    }
                    if($bike->SIZE == "L")
                    {
                        $availableBikesL = $bike->IN_STOCK;
                        $sizeLDisabled = "";                     
                        $sizeLHidden ="";
                        $rentedBikesL = $bike->RENTED;
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
                            <label for="numberOfBikesSizeS_toReturn">number of Bikes to retrun:</label><br>
                            <input type="number" id="numberOfBikesSizeS_toReturn" name="numberOfBikesSizeS_toReturn" min="0" max=$rentedBikesS><br>
                        </form>
                        </div>
                        <div $sizeMHidden>
                        <label>Bikesize: M</label>
                        <form>
                            <label for="numberOfBikesSizeM_toReturn">number of Bikes to retrun:</label><br>
                            <input type="number" id="numberOfBikesSizeM_toReturn" name="numberOfBikesSizeM_toReturn" min="0" max=$rentedBikesM><br>
                        </form>
                        </div>
                        <div $sizeLHidden>
                        <label>Bikesize: L</label>
                        <form>
                            <label for="numberOfBikesSizeL_toReturn">number of Bikes to return:</label><br>
                            <input type="number" id="numberOfBikesSizeL_toReturn" name="numberOfBikesSizeL_toReturn" min="0" max=$rentedBikesL><br>
                        </form>
                        </div>
                        </div>
                        OWN;
                }
            }
            }
            echo "</div>";
            echo "<br>";
            echo "<h4>Touring</h4>";
            echo '<div class="flexRow">';
            $variantA_TouringBikes = array();
            $variantB_TouringBikes = array();
            $variantC_TouringBikes = array();
            foreach($xml as $node) {
                $category = $node->CATEGORY;
                if($category == "TOURING"){
                    if($node->VARIANT == "A" )
                        {
                            $variantA_TouringBikes[]= $node;
                        }
                    if($node->VARIANT == "B" )
                        {
                            $variantB_TouringBikes[]= $node;
                        }
                    if($node->VARIANT == "C" )
                        {
                            $variantC_TouringBikes[]= $node;
                        }
                    }
            }
            $sizesVarA_Touring = array();
            foreach($variantA_TouringBikes as $bikeA)
            {
                $sizesVarA_Touring[] = $bikeA->SIZE;
            }
            $sizesVarB_Touring = array();
            foreach($variantB_TouringBikes as $bikeB)
            {
                $sizesVarB_Touring[] = $bikeB->SIZE;
            }
            $sizesVarC_Touring = array();
            foreach($variantC_TouringBikes as $bikeC)
            {
                $sizesVarC_Touring[] = $bikeC->SIZE;
                
            }
            $bikeVariants = [$variantA_TouringBikes, $variantB_TouringBikes, $variantC_TouringBikes];
            foreach($bikeVariants as $bikeVar)
            {
                if($bikeVar) {
                    $node = $bikeVar[0][0];
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
                $rentedBikesS = 0;
                $rentedBikesM = 0;
                $rentedBikesL = 0;
                foreach($bikeVar as $bike)
                {
                    if($bike->SIZE == "S")
                    {
                        $availableBikesS = $bike->IN_STOCK;
                        $sizeSDisabled = "";
                        $sizeSHidden ="";
                        $rentedBikesS = $bike->RENTED;
                    }
                    if($bike->SIZE == "M")
                    {
                        $availableBikesM = $bike->IN_STOCK;
                        $sizeMDisabled = "";
                        $sizeMHidden ="";
                        $rentedBikesM = $bike->RENTED;
                    }
                    if($bike->SIZE == "L")
                    {
                        $availableBikesL = $bike->IN_STOCK;
                        $sizeLDisabled = "";                     
                        $sizeLHidden ="";
                        $rentedBikesL = $bike->RENTED;
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
                            <label for="numberOfBikesSizeS_toReturn">number of Bikes to retrun:</label><br>
                            <input type="number" id="numberOfBikesSizeS_toReturn" name="numberOfBikesSizeS_toReturn" min="0" max=$rentedBikesS><br>
                        </form>
                        </div>
                        <div $sizeMHidden>
                        <label>Bikesize: M</label>
                        <form>
                            <label for="numberOfBikesSizeM_toReturn">number of Bikes to retrun:</label><br>
                            <input type="number" id="numberOfBikesSizeM_toReturn" name="numberOfBikesSizeM_toReturn" min="0" max=$rentedBikesM><br>
                        </form>
                        </div>
                        <div $sizeLHidden>
                        <label>Bikesize: L</label>
                        <form>
                            <label for="numberOfBikesSizeL_toReturn">number of Bikes to return:</label><br>
                            <input type="number" id="numberOfBikesSizeL_toReturn" name="numberOfBikesSizeL_toReturn" min="0" max=$rentedBikesL><br>
                        </form>
                        </div>
                        </div>
                        OWN;
                }
            }
            }
            echo "</div>";
            echo "<br>";
            echo "<h4>MTB</h4>";
            echo '<div class="flexRow">';
            $variantA_MTBBikes = array();
            $variantB_MTBBikes = array();
            $variantC_MTBBikes = array();
            foreach($xml as $node) {
                $category = $node->CATEGORY;
                if($category == "MTB"){
                    if($node->VARIANT == "A" )
                        {
                            $variantA_MTBBikes[]= $node;
                        }
                    if($node->VARIANT == "B" )
                        {
                            $variantB_MTBBikes[]= $node;
                        }
                    if($node->VARIANT == "C" )
                        {
                            $variantC_MTBBikes[]= $node;
                        }
                    }
            }
            $sizesVarA_MTB = array();
            foreach($variantA_MTBBikes as $bikeA)
            {
                $sizesVarA_MTB[] = $bikeA->SIZE;
            }
            $sizesVarB_MTB = array();
            foreach($variantB_MTBBikes as $bikeB)
            {
                $sizesVarB_MTB[] = $bikeB->SIZE;
            }
            $sizesVarC_MTB = array();
            foreach($variantC_MTBBikes as $bikeC)
            {
                $sizesVarC_MTB[] = $bikeC->SIZE;
                
            }
            $bikeVariants = [$variantA_MTBBikes, $variantB_MTBBikes, $variantC_MTBBikes];
            foreach($bikeVariants as $bikeVar)
            {
                if($bikeVar) {
                    $node = $bikeVar[0][0];
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
                $rentedBikesS = 0;
                $rentedBikesM = 0;
                $rentedBikesL = 0;
                foreach($bikeVar as $bike)
                {
                    if($bike->SIZE == "S")
                    {
                        $availableBikesS = $bike->IN_STOCK;
                        $sizeSDisabled = "";
                        $sizeSHidden ="";
                        $rentedBikesS = $bike->RENTED;
                    }
                    if($bike->SIZE == "M")
                    {
                        $availableBikesM = $bike->IN_STOCK;
                        $sizeMDisabled = "";
                        $sizeMHidden ="";
                        $rentedBikesM = $bike->RENTED;
                    }
                    if($bike->SIZE == "L")
                    {
                        $availableBikesL = $bike->IN_STOCK;
                        $sizeLDisabled = "";                     
                        $sizeLHidden ="";
                        $rentedBikesL = $bike->RENTED;
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
                            <label for="numberOfBikesSizeS_toReturn">number of Bikes to retrun:</label><br>
                            <input type="number" id="numberOfBikesSizeS_toReturn" name="numberOfBikesSizeS_toReturn" min="0" max=$rentedBikesS><br>
                        </form>
                        </div>
                        <div $sizeMHidden>
                        <label>Bikesize: M</label>
                        <form>
                            <label for="numberOfBikesSizeM_toReturn">number of Bikes to retrun:</label><br>
                            <input type="number" id="numberOfBikesSizeM_toReturn" name="numberOfBikesSizeM_toReturn" min="0" max=$rentedBikesM><br>
                        </form>
                        </div>
                        <div $sizeLHidden>
                        <label>Bikesize: L</label>
                        <form>
                            <label for="numberOfBikesSizeL_toReturn">number of Bikes to return:</label><br>
                            <input type="number" id="numberOfBikesSizeL_toReturn" name="numberOfBikesSizeL_toReturn" min="0" max=$rentedBikesL><br>
                        </form>
                        </div>
                        </div>
                        OWN;
                }
            }
            }
        ?>
        </div>
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