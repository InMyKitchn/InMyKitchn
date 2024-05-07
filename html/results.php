<?php
  // Login and Signup Cookies Code
  // Access the database
  $database = json_decode(file_get_contents("../database/databaseFile.json"), true);

  // Variable to store errors in
  $throwErrors = "";
  $validUsername = false;

  // Cookies
  // Login Modal
  if (isset($_POST["uname"])) {
    $cookieLoginValue = $_POST["uname"];

    if (isset($_POST["psw"])) {
      $cookiePassValue = $_POST["psw"];

      // For the purposes of demonstration, assume already logged in
      $validUsername = true;
      
      // Checks if the username and password entered matches any result in the database
      for ($i = 0; $i < count($database['users']); $i++) {
        if ($database['users'][$i]["username"] == $cookieLoginValue) {
          if ($database['users'][$i]["password"] == $cookiePassValue) {
            setcookie("loggedIn", $cookieLoginValue, time() + (86400 * 30), "/"); // 86400 = 1 day
          } else {
            // Tell user there was an error in logging in
            $throwErrors = $throwErrors . "The entered password is incorrect! ";
          }
          $validUsername = true;
          break;
        }
      }

      if (!$validUsername) {
        $throwErrors = $throwErrors . "The entered username is incorrect! ";
      }
    }
  }
  

  // Sign Up Modal 
  if (isset($_POST["unameSignUp"])) {
    $newLoginValue = str_replace(" ", "_", $_POST["unameSignUp"]);

    if (isset($_POST["pswSignUp"])) {
      $newPassValue = $_POST["pswSignUp"];

      if (isset($_POST["creditSignUp"])) {
        $newCreditValue = $_POST["creditSignUp"];

        if (true) { // if valid credit card
          array_push($database['users'], array("username"=>$newLoginValue, "password"=>$newPassValue));
          file_put_contents("../database/databaseFile.json", json_encode($database));
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    
    <title>in my kitchen</title>

    <!-- Favicon -->
    <link rel="icon" type="png" href="/images/icons/logo.png"/>


    <!-- Links for Styling -->
    <!--League spartan font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Spartan"/>
    <!-- Misc icons from "https://fontawesome.com/v4.7/icons/" -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- CSS -->
    <link rel="stylesheet" href="/css/style.css" type="text/css"/> 
    <link rel="stylesheet" href="/css/modal.css" type="text/css"/>
    <link rel="stylesheet" href="/css/navigation.css" type="text/css"/>
    <link rel="stylesheet" href="/css/login.css" type="text/css"/>
    <link rel="stylesheet" href="/css/footer.css" type="text/css"/>
    
    <link rel="stylesheet" href="/css/results.css" type="text/css"/>


    <!-- Scripts -->
    <script src="/js/cookies.js"></script>
  </head>
  <body>
    <!-- Navigation Bar -->
    <script id="replaceWithNavigation" src="/js/includes/navigation.js"></script>

    <!-- Home Page Content -->
    <div class="pageContent">
    
      <!-- Getting user Input and Calling API -->
      <?php
        $appID = "15a2e28e";
        $appKey = "09cb4e269ea57fefa6fa373550d3096c";        

        /*
         * Get text input from main page
         *
         * Replace spaces and special characters with %20 to indicate next ingredient
         */
        $userInput = preg_replace('/[^A-Za-z]/', '%20', $_POST["textInput"]);

        /*
         * Get selected filters from main page
         */
        $userSelectedLabels = "";
        // As output of $_POST['xyzLabels'] is an array we have to use foreach loop to display individual value
        if ($_POST['dietLabels'] !== null) {
          foreach ($_POST['dietLabels'] as $select) {
            $userSelectedLabels = $userSelectedLabels . "&diet=" . $select; 
          }
        }
        if ($_POST['healthLabels'] !== null) {
          foreach ($_POST['healthLabels'] as $select) {
            $userSelectedLabels = $userSelectedLabels . "&health=" . $select; 
          }
        }

        /*
        * Setup API call
        */

        //Load the file
        $currPageFile = file_get_contents("../database/currPageNum.json");
        $currPageLinkFile = file_get_contents("../database/pageLinks.json");

        //Decode the JSON data into a PHP array.
        $currPageData = json_decode($currPageFile, true);
        // get the current page number from currPageNum.json 
        $currPageNum = $currPageData['currPage'];

        // Create curl resource
        $ch = curl_init();

        // Set url
        // Get new link if applicable 
        $currPageLinkData = json_decode($currPageLinkFile, true);
        $nextHREF = $currPageLinkData[$currPageNum];
        if (!empty($nextHREF)){
          curl_setopt($ch, CURLOPT_URL, $nextHREF);
        } else {
          curl_setopt($ch, CURLOPT_URL, "https://api.edamam.com/api/recipes/v2?type=public&q=$userInput&app_id=$appID&app_key=$appKey$userSelectedLabels");
        }
        
        // Return the API's response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $outputJSON contains the output string to json
        $outputJSON = json_decode(curl_exec($ch));
        // Close curl resource to free up system resources
        curl_close($ch);   

        /*
        * End of API call
        */

        // If the API actually returned something
        if ($outputJSON->count !== 0) {
      ?>
          <!-- Display the top 5 ingredients from the page -->
          <table class="table table-borderless table-striped table-earning">
            <tbody>
              <!-- Display the first x recipes returned from API -->
              <?php 
                // $recipesToDisplay MUST be between 1 - 20 inclusive
                $recipesToDisplay = 5;
                for ($recipeNum = 0; $recipeNum < $recipesToDisplay; $recipeNum++) {
                  if (!empty($outputJSON->hits[$recipeNum])) {
              ?>
                    <tr>
                      <th rowspan="3" style="width: 300px"><img src=<?php echo $outputJSON->hits[$recipeNum]->recipe->image ?>></img></th>
                      <td colspan = "2"><a href="#details" onclick="document.getElementById('<?php echo ('detailedRecipe' . $recipeNum); ?>').style.display='block'; return false;"><?php echo ($outputJSON->hits[$recipeNum]->recipe->label);?></a></td>
                    </tr>
                    <tr>
                      <td><?php echo ("Ingredients: " . count($outputJSON->hits[$recipeNum]->recipe->ingredientLines));?></td>
                      <td><?php echo ("Meal Type: " . preg_replace('/[^A-Za-z0-9\-\/,]/', '', json_encode($outputJSON->hits[$recipeNum]->recipe->mealType)));?></td>
                    </tr>
                    <tr>
                      <td><b><?php echo ("Calories: " . round(($outputJSON->hits[$recipeNum]->recipe->calories)/($outputJSON->hits[$recipeNum]->recipe->yield)));?></b></td>
                      <td><?php echo ("Diet Type: " . preg_replace('/[^A-Za-z0-9\-\/,]/', '', json_encode($outputJSON->hits[$recipeNum]->recipe->dietLabels)));?></td>
                    </tr>
              <?php
                  } else {
              ?>
                    <tr>
                      <td colspan = "3"><p>No more recipes with this ingredient and filter set!</p></td>
                    </tr>
              <?php
                  }
                }
              ?>
            </tbody>
          </table>
      <!-- Part of displaying API information -->
      <?php 
        // If the API did NOT return something
        } else {
      ?>
          <h1 class="center">Uh oh! We ran into an error. Please make sure everything is spelled correctly!</h1>
          <img src="/images/icons/kitchenError.svg" class="center" style="width: 15%"></img>
      <?php
        }
      ?>
      <!-- End API Call -->



      <!-- 

        Detailed Recipe Popups 
          The id of each modal is "detailedRecipe[#]" where [#] is to be replaced with the recipe number from the API call
        
      -->
      <?php 
        for ($recipeNum = 0; $recipeNum < $recipesToDisplay; $recipeNum++) {
          // The number of servings the recipe creates 
          $numServings = $outputJSON->hits[$recipeNum]->recipe->yield;
      ?>
          <div id="<?php echo 'detailedRecipe' . $recipeNum; ?>" class="modal">
            <div class="modalContent animateZoom">
              <div class="container" style="margin: 1.5vw 0 2vw 0; position: relative;">
                <span onclick="document.getElementById('<?php echo ('detailedRecipe' . $recipeNum); ?>').style.display='none'" class="close" title="Close" style="padding=top:2px; font-size:3vw;">&times;</span>
              </div>
              <div class="container" style="overflow: hidden;">

                <!--content start-->
                <table>
                  <thead>
                    <tr>
                      <th style="width:33%; padding:0 0 0 0;">
                        <img style="width:100%; height:100%; margin:0;" src=<?php echo $outputJSON->hits[$recipeNum]->recipe->image ?>></img>
                      </th>
                      <th style="width:67%;">
                        <b><a style="font-size:4vw;" href=<?php echo ($outputJSON->hits[$recipeNum]->recipe->url);?> target="_blank"><?php echo ($outputJSON->hits[$recipeNum]->recipe->label);?></a></b>
                      </th>
                    </tr>
                  </thead>
                </table>

                <!-- Nutrient info -->
                <table style="width:33%; float:left;">
                  <tbody>
                    <tr><td colspan="2"><b>Nutrients Per Serving</b></td></tr>
                    <tr>
                      <td class="tableData"><b>Calories</b></td>
                      <td class="tableData" style="text-align:right;">
                        <b><?php echo (round(($outputJSON->hits[$recipeNum]->recipe->calories)/$numServings) . "cal");?></b>
                      </td>
                    </tr>
                    <tr>
                      <td class="tableData"><b>Fat</b></td>
                      <td class="tableData" style="text-align:right;">
                        <b><?php echo (round($outputJSON->hits[$recipeNum]->recipe->totalNutrients->FAT->quantity/$numServings) . $outputJSON->hits[$recipeNum]->recipe->totalNutrients->FAT->unit);?></b>
                      </td>
                    </tr>
                    <tr>
                      <td class="tableData"><b>Carbohydrates</b></td>
                      <td class="tableData" style="text-align:right;">
                        <b><?php echo (round($outputJSON->hits[$recipeNum]->recipe->totalNutrients->CHOCDF->quantity/$numServings) . $outputJSON->hits[$recipeNum]->recipe->totalNutrients->CHOCDF->unit);?></b>
                      </td>
                    </tr>
                    <tr>
                      <td class="tableData"><b>Fibre</b></td>
                      <td class="tableData" style="text-align:right;">
                        <b><?php echo (round($outputJSON->hits[$recipeNum]->recipe->totalNutrients->FIBTG->quantity/$numServings) . $outputJSON->hits[$recipeNum]->recipe->totalNutrients->FIBTG->unit);?></b>
                      </td>
                    </tr>
                    <tr>
                      <td class="tableData"><b>Sugar</b></td>
                      <td class="tableData" style="text-align:right;">
                        <b><?php echo (round($outputJSON->hits[$recipeNum]->recipe->totalNutrients->SUGAR->quantity/$numServings) . $outputJSON->hits[$recipeNum]->recipe->totalNutrients->SUGAR->unit);?></b>
                      </td>
                    </tr>
                    <tr>
                      <td class="tableData"><b>Protein</b></td>
                      <td class="tableData" style="text-align:right;">
                        <b><?php echo (round($outputJSON->hits[$recipeNum]->recipe->totalNutrients->PROCNT->quantity/$numServings) . $outputJSON->hits[$recipeNum]->recipe->totalNutrients->PROCNT->unit);?></b>
                      </td>
                    </tr>
                    <tr>
                      <td class="tableData"><b>Calcium</b></td>
                      <td class="tableData" style="text-align:right;">
                        <b><?php echo (round($outputJSON->hits[$recipeNum]->recipe->totalNutrients->CA->quantity/$numServings) . $outputJSON->hits[$recipeNum]->recipe->totalNutrients->CA->unit);?></b>
                      </td>
                    </tr>
                    <tr>
                      <td class="tableData"><b>Iron</b></td>
                      <td class="tableData" style="text-align:right;">
                        <b><?php echo (round($outputJSON->hits[$recipeNum]->recipe->totalNutrients->FE->quantity/$numServings) . $outputJSON->hits[$recipeNum]->recipe->totalNutrients->FE->unit);?></b>
                      </td>
                    </tr>
                    <tr>
                      <td class="tableData"><b>Potassium</b></td>
                      <td class="tableData" style="text-align:right;">
                        <b><?php echo (round($outputJSON->hits[$recipeNum]->recipe->totalNutrients->K->quantity/$numServings) . $outputJSON->hits[$recipeNum]->recipe->totalNutrients->K->unit);?></b>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <!-- Ingredients info -->
                <table class="tableAPI" style="width:67%; float:left; border-spacing: 0; overflow: auto; height: 100px; ">
                  <thead>
                    <tr>
                      <th style="border-top:none; border-right:none; border-left:none; position: sticky; top: 0; z-index: 1;">
                        <b>Ingredients for <?php echo $numServings ?> Servings</b>
                      </th>
                    </tr>
                  </thead>
                  <tbody style="overflow-y: auto; overflow-x: hidden; width:100%; height: 378px;">
                    <?php
                      for ($i = 0; $i < count($outputJSON->hits[$recipeNum]->recipe->ingredientLines); $i++) {
                    ?>
                        <tr><td class="tableData" style="text-align: left;"><?php echo ($outputJSON->hits[$recipeNum]->recipe->ingredientLines[$i]);?></td></tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>

                <!-- content end -->
              </div>
              <div class="container">
                <button type="button" onclick="document.getElementById('<?php echo ('detailedRecipe' . $recipeNum); ?>').style.display='none'" class="cancelbtn">return</button>
              </div>
            </div>
          </div>
        </div>
    <?php
      }

      // Page navigation buttons only if logged in
      // if (isset($_COOKIE["loggedIn"])) {
      // For the purposes of demonstration, assume logged in
      if (true) {
        $nextPageNum = $currPageNum + 1;
        $currPageLinkData[$nextPageNum] = $outputJSON->_links->next->href;
        
        $currPageDataEncode = json_encode($currPageLinkData);
        file_put_contents("../database/pageLinks.json", $currPageDataEncode);

        // Page Number update
        $currPageData['currPage'] = $nextPageNum;
        $currPageNumFileEncode = json_encode($currPageData);
        file_put_contents("../database/currPageNum.json", $currPageNumFileEncode);
    ?>
        <div class="pageNavButtons">
          <!-- Prev page does not work and will not work with the current system, will require overhaul of our database system which we should not do at this point -->
          <p class="previous hoverCursor">&#8249;</p>
          <!-- Next page -->
          <?php 
            if (!empty($currPageLinkData[$nextPageNum])) {
          ?>
              <a href="/html/results.php" class="next">&#8250;</a>
          <?php
            } else {
          ?>
              <p class="next hoverCursor">&#8250;</p>
          <?php
            }
          ?>
        </div>
    <?php 
      }
    ?>

    <!-- Translation + Footer -->
    <?php
      if(isset($_COOKIE["loggedIn"])) {
    ?>
        <div style="text-align: center; background-color: var(--gray); color: var(--tan); botom: 0px;">
          <div class="spaceH"></div>
          <div id="google_translate_element"></div> 
            
          <script type="text/javascript"> 
            function googleTranslateElementInit() { 
                new google.translate.TranslateElement(
                    {pageLanguage: 'en'}, 
                    'google_translate_element'
                ); 
            } 
          </script> 
            
          <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <?php
      }
    ?>

      <!-- Footer -->
      <script id="replaceWithFooter" src="/js/includes/footer.js"></script>
    </div>
  </body>
</html>