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
  
  /** 
   * isLoggedIn
   *
   * Checks if the user has the logged in cookie
   */
  function isLoggedIn() {
    // For the purposes of demonstration, assume always logged in
    return true;
    // Otherwise can delete the previous line to use login system
    if(isset($_COOKIE["loggedIn"])) {
      return true;
    } else {
      return false;
    }
  }

  // Reset page number to 0
  $currPageFile = file_get_contents("../database/currPageNum.json");
  $currPageData = json_decode($currPageFile, true);
  $currPageData['currPage'] = 0;
  $currPageFileEncode = json_encode($currPageData);
  file_put_contents("../database/currPageNum.json", $currPageFileEncode);
?>

<!-- Main Page -->
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
    
    <link rel="stylesheet" href="/css/mainPage.css" type="text/css"/>
    
    <!-- Scripts -->
    <script src="/js/generalScript.js"></script>
  </head>


  <body>
    <!-- Navigation Bar -->
    <script id="replaceWithNavigation" src="/js/includes/navigation.js"></script>
    
    <!-- Display Login Errors -->
    <?php 
      if ($throwErrors !== "") {
        echo $throwErrors;
      }
    ?>

    <!-- Title Image -->
    <div id="titleContainer" class="transparentBKGD">
      <div class="spaceH"></div>
      <div class="spaceH"></div>
      <div class="spaceH"></div>
      <div id="titleText" class="transparentBKGD noCursor">
        <div class="transparentBKGD">in my</div>
        <div class="transparentBKGD">kitchen</div>
      </div>
    </div>


    <!-- Home Page Content -->
    <div class="pageContent">

      <!-- Get started and about us information -->
      <div class="getStarted">
        <div class="getStartedContent">
          <h3>need to find recipes for delicious meals customized just for you? click to get started!</h3>
          <!--button brings to "recipes" page"-->
          <button type="button" onclick="document.getElementById('searchBox').scrollIntoView();" id="startbtn">find recipes</button><br><br>
        </div>
      </div>

      <center><div class="about">
        <br>
        <h1>who are we?</h1>
        <p>we are team k from the canadian youth champions fall 2021 program. we are a group of high school students dedicated to helping youth improve on their health and wellness through healthy eating.</p><br>
        <h1>our mission</h1>
        <p>our mission is to help youth improve on their eating habits for a healthier and more nutritional dietary lifestyle.</p><!--if that even makes sense--><br>
        <!--<p>our mission is to help youth improve their eating habits and help them change into a healthier and more nutritional dietary lifestyle.</p> 
        I think this would work better? Idk, someone check for me. -Francis --> 
      </div></center>

      <!-- API submission form -->
      <form action="/html/results.php" method="post">
        <label for="textInput" id="searchBox">search for recipes by listing available ingredients:</label>
        <input type="text" name="textInput" placeholder="enter ingredients" required/>
        <button type="submit"><i class="fa fa-search"></i>&ensp;Search</button>

        <!-- If user is logged in to premium account; show filters options -->
        <?php if (isLoggedIn()) { ?>
          <button type="button" class="collapsible">Select your preferred filters&ensp;<i class="fa fa-caret-down"></i></button>
          <div class="doNotShow" style="position: absolute; z-index: 2;">
            <table class="noBorder" style="width:600px;">
              <thead class="noBorder">
                <tr class="noBorder">
                  <th class="noBorder" style="background-color:var(--tan); width:200px;">
                    <p>Diets</p>
                  </th>
                  <th class="noBorder" style="background-color:var(--tan); width:200px;">
                    <p>Nutrition</p>
                  </th>
                  <th class="noBorder" style="background-color:var(--tan); width:200px;">
                    <p>Allergies</p>
                  </th>
                </tr>
              </thead>
              <tbody class="noBorder">
                <tr class="noBorder">
                  <!-- Diet Filters -->
                  <td class="selectFilters noBorder">
                    <input type="checkbox" name="healthLabels[]" value="keto-friendly"><label class="transparentBKGD">Keto</label><br>
                    <input type="checkbox" name="healthLabels[]" value="kosher"><label class="transparentBKGD">Kosher</label><br>
                    <input type="checkbox" name="healthLabels[]" value="paleo"><label class="transparentBKGD">Paleo</label><br>
                    <input type="checkbox" name="healthLabels[]" value="vegan"><label class="transparentBKGD">Vegan</label><br>
                    <input type="checkbox" name="healthLabels[]" value="vegetarian"><label class="transparentBKGD">Vegetarian</label><br>
                    <input type="checkbox" name="healthLabels[]" value="Mediterranean"><label class="transparentBKGD">Mediterranean</label><br>
                  </td>
                  <!-- Nutrition Filters -->
                  <td class="selectFilters noBorder">
                    <input type="checkbox" name="dietLabels[]" value="balanced"><label class="transparentBKGD">Balanced</label><br>
                    <input type="checkbox" name="dietLabels[]" value="high-fiber"><label class="transparentBKGD">High Fiber</label><br>
                    <input type="checkbox" name="dietLabels[]" value="high-protein"><label class="transparentBKGD">High Protein</label><br>
                    <input type="checkbox" name="dietLabels[]" value="low-carb"><label class="transparentBKGD">Low Carbs</label><br>
                    <input type="checkbox" name="dietLabels[]" value="low-fat"><label class="transparentBKGD">Low Fat</label><br>
                    <input type="checkbox" name="dietLabels[]" value="low-sodium"><label class="transparentBKGD">Low Sodium</label><br>
                    <input type="checkbox" name="healthLabels[]" value="low-sugar"><label class="transparentBKGD">Low Sugar</label><br>
                    <input type="checkbox" name="healthLabels[]" value="no-oil-added"><label class="transparentBKGD">No Oil Added</label><br>
                  </td>
                  <!-- Allergy Filters -->
                  <td class="selectFilters noBorder">
                    <input type="checkbox" name="healthLabels[]" value="dairy-free"><label class="transparentBKGD">Dairy Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="egg-free"><label class="transparentBKGD">Egg Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="fish-free"><label class="transparentBKGD">Fish Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="gluten-free"><label class="transparentBKGD">Gluten Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="mustard-free"><label class="transparentBKGD">Mustard Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="peanut-free"><label class="transparentBKGD">Peanut Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="pork-free"><label class="transparentBKGD">Pork Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="red-meat-free"><label class="transparentBKGD">Red Meat Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="sesame-free"><label class="transparentBKGD">Sesame Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="shellfish-free"><label class="transparentBKGD">Shellfish Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="soy-free"><label class="transparentBKGD">Soy Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="sulfite-free"><label class="transparentBKGD">Sulfite Free</label><br>
                    <input type="checkbox" name="healthLabels[]" value="tree-nut-free"><label class="transparentBKGD">Tree Nut Free</label><br>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Script for the collapsible classes only applicable if user is logged in -->
          <script>
            var coll = document.getElementsByClassName("collapsible");
            var i;

            for (i = 0; i < coll.length; i++) {
              coll[i].addEventListener("click", function() {
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                  content.style.display = "none";
                } else {
                  content.style.display = "block";
                }
              });
            }
          </script>
        <?php } ?>
      </form>
      <br>
    </div>


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