<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookingPlattformTouristikBike</title>
 <link rel="icon" type="image/x-icon" href="favicon.ico">
        <style> /*todo_TECHDEBT: outsource to dedicated styles.css*/
            <?php 
                /* just make sure that all needed color definitions are available */
                require_once("ColorDefinitions.php");
            ?>
        body {
            background-image: <?php getBgImageWindow();?>;
            font-family: Arial, Helvetica, sans-serif;
        }
        h1 {
            color: <?php echo MainTextColor; ?>; 
            background-image: <?php getBgMainText();?>;
        }
        .flexRow {
            display: flex;
            flex-direction: row;
        }
        .flexColumn {
            display: flex;
            flex-direction: column;
        }

        div.containerLeftPadding {
            padding-left: 15px;
        }
        
        input {
            background-color: #63bcdf;
            color: #d2ecf6;
            font-weight: bold;
        }

        input.bookingDate {
            border:solid thick grey;  
            background-color: none;
            border-radius: 0.25em; 
            border-width:2px; 
            color: grey;
            font-weight: bold;
            font-size: 18px;
            display: flex;
            margin-bottom:2px;
        }
        select.bikeCategories {
            border:solid thick aquamarine;  
            border-radius: 0.5em; 
            border-width:3px; 
            background-image: <?php getBgImageTiles(); ?>;
            font-size: 22px;
            select: 1;
            color: grey;
            /* hide vertical scrollbar -> https://stackoverflow.com/questions/4531269/hide-vertical-scrollbar-in-select-element */
            overflow-y: auto;
            margin-bottom: 2px;
        }
        
        input.selectBikeCategory {
            border:solid thick grey;  
            background-color: none;
            border-radius: 0.25em; 
            border-width:2px; 
            color: grey;
            font-weight: bold;
            font-size: 18px;
            display: flex;
            margin-bottom:2px;
        }
        input.selectBikeCategory:hover {
            cursor:pointer;
            border:solid thick <?php echo HighlightColor; ?>; 
            border-width:3px; 
            color: <?php echo HighlightColor; ?>;
        }

        /* todo_TECHDEBT: cant this be outsourced properly? */
        /* css-only collapsible of the "rented-bikes" overview */
        /*https://www.digitalocean.com/community/tutorials/css-collapsible*/
        /* collapsible implementation BEGIN */
        /*//////////////////////*/
        /* hide the original checkbox-item to allow for proper displaying of the "collapse"-icon ("arrow")
           however, the checked-event needs to be processed  */
        input.colapse_cb{
            display:none;
        }
        .collapsible-content {
            max-height: 0px;
            overflow: hidden;
            /* animate the transition collapsed <-> not collapsed */
            transition: max-height 0.8s ease-in-out;
        }

        /* the actual toggle for triggering the colapse / expansion of the collapsible-content */
        .colapseToggle {
            /* the text is meant to look similar to the other h1-texts used in the html */
            color: <?php echo MainTextColor; ?>; 
            background-image: <?php getBgMainText();?>;
            
            display: block; 
            font-weight: bold;
            font-size: 30px;
            transition: all 0.25s ease-out;
        }
        /* for creating the "triangle" icon this trick has been applied: : https://css-tricks.com/snippets/css/css-triangle */
        .colapseToggle::before {
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
        .colapseToggle:hover {
            color: <?php echo HighlightColor; ?>;
        }
        
        .colapse_cb:checked + .colapseToggle::before {
            /* rotate the toggle-arrow "in place" */
            transform: rotate(90deg) translateX(-3px);
        }
        .colapse_cb:checked + .colapseToggle + .collapsible-content {
            /* expand the collapsed content on :checked using combinators (https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/Selectors/Combinators) */
            max-height: 100vh;
        }
        /*//////////////////////*/
        /* collapsible implementation END */

        img.usericon {
            margin: 10px;
            align-self: right;
        }
        img.companyLogo {
            margin: 10px;
            align-self: center;
        }
        
        /* helper style for visually identifying ToDos*/
        .todo {
            color: red;
        }
        </style>
    </head>
    <body>

        <!-- font from here: https://www.fontspace.com/new/fonts - "Unbound Gamer" by Iconian Fonts -->
        <div class="flexRow">
            <!-- todo_COSMETIC: apply gradient dynamically to logo instead of changing the sourcegraphic in e.g. krita -->
            <img class="companyLogo" src="./Logo.png" alt="Company Logo icon" width="auto" height="100%">
            <div class="flexColumn">
                <img class="usericon" src="./AssetCaseStudy_UserIcon.png" alt="User icon" width="80" height="80">
                <!-- todo_TECHDEBT: display the name of the used xml / use the name of the user to define the to be loaded xml -->
                <label>Logged in User</label>
            </div>
        </div>
        <br>
        
        <!-- collapsible (already) rented bikes overview-->
        <div class="wrap-collapsible">
            <input id="collapsible" class="colapse_cb" type="checkbox">
            <label for="collapsible" class="colapseToggle">Already rented bikes</label>            
            <div class="collapsible-content">
                <?php 
                    /* include functionality for creating the bike overview */
                    require_once("outsourcedFunction.php");
                    /* todo_TECHDEBT: isnt there a better way to pass ALL available categories? maybe directly read from xml? */
                    $bikeTypes = ["ROAD","MTB", "TOURING"];
                    /* todo_TECHDEBT: the xml of the logged in user should be passed, not a hardcoded filename */
                    createBikesOverview("Rented","./User1.xml", $bikeTypes);
                ?>
            </div>
        </div>

        <div class="containerLeftPadding">
            <h1>Choose rental date and bike category</h1>
            <h4>Select Bookingdate </h4>
            <form>
                <div class="flexRow">
                    <label for="dateFrom">from: 
                        <input disabled class="bookingDate" type="datetime-local" id="dateFrom" name="dateFrom">
                    </label>
                    <label for="dateTo">to: 
                        <input disabled class="bookingDate" type="datetime-local" id="dateTo" name="dateTo">
                    </label>
                </div>
                <section>(not suppoerted in this version)</section>
            </form>
            <h4>Select Bike-Category </h4>
            
            

<form method="post" action="" name="form">  
    <!-- todo_COSMETIC: visually highlight the selected entry in the list! -->
<select class="bikeCategories" name="bikeCategories" size="3"> <!-- todo_TECHDEBT: make sure no additional values can be added / submitted lateron via HTML-->
                <option selected>Road</option>
                <option>Touring</option>
                <option>MTB</option>
            </select>
 <input class="selectBikeCategory" name="submit" type="submit" value="select Bike category">
</form>
<?php

if (isset($_POST['bikeCategories']))
{
    $tmp_result = $_POST['bikeCategories'];
    $selectedCategory = strtoupper($tmp_result);
}
?>

        </div>
        <br>
        <h1>Choose Bikes for rental (<?php echo $selectedCategory;?>)</h1>
        <?php 
            require_once("outsourcedFunction.php");
            $category = [strtoupper($selectedCategory)];
            createBikesOverview("Rental", "./BikeStock.xml", $category);
        ?>
    </body>
</html> 