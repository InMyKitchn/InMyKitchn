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
?>

<!DOCTYPE html>
<html>
<head>
  <title>in my kitchen</title>

  <!-- Favicon -->
  <link rel="icon" type="png" href="/images/icons/logo.png"/>

  <!-- Links for Styling -->
  <!--League spartan font-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Spartan"/>
  <!-- Misc icons from "https://fontawesome.com/v4.7/icons/" -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
  <!-- CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/css/style.css" type="text/css"/> 
  <link rel="stylesheet" href="/css/modal.css" type="text/css"/>
  <link rel="stylesheet" href="/css/navigation.css" type="text/css"/>
  <link rel="stylesheet" href="/css/login.css" type="text/css"/>
  <link rel="stylesheet" href="/css/footer.css" type="text/css"/>

  <link rel="stylesheet" type="text/css" href="/css/healthTips.css"/>
</head>
<body>
  <!-- Navigation Bar -->
  <script id="replaceWithNavigation" src="/js/includes/navigation.js"></script>

  <div class="pageContent">
    <div class="slideshow-container">

    <div class="mySlides fade">
      <div class="numbertext">1 / 8</div>
      <center><img src="/images/kitchenImages/1.png"></center>
      <div class="text"><h3>1. To prevent cutting yourself</h3>
    - When using scissors, always cut away from yourself <br>
    - When using a knife, curl your fingers inwards <br><br><br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">2 / 8</div>
      <center><img src="/images/kitchenImages/2.png"></center>
      <div class="text"><h3>2. When dealing with hot objects</h3>
    - Use oven mitts or a towel to hold hot items <br>
    - Do not rush!<br>
    - Keep utensils away from hot items <br><br><br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">3 / 8</div>
      <center><img src="/images/kitchenImages/3.jpeg"></center>
      <div class="text"><h3>3. Always keep watch!</h3>
    - Make sure you constantly monitor anything cooking <br>
    - Do not leave kitchen when cooking <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">4 / 8</div>
      <center><img src="/images/kitchenImages/4.jpeg"></center>
      <div class="text"><h3>4. Clean up any spills immediately</h3>
    - Clean up before any accidents happen <br>
    - Food that sits out could cause illness <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">5 / 8</div>
      <center><img src="/images/kitchenImages/5.jpeg"></center>
      <div class="text"><h3>5. Keep a first aid kit</h3>
    - It is important to keep one nearby just in case of any emergencies<br>
    - Should include gauze, burn salve, and scissors<br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">6 / 8</div>
      <center><img src="/images/kitchenImages/6.jpeg"></center>
      <div class="text"><h3>6. Wear appropriate clothing</h3>
      <h4>Long sleeves, long hair or jewelery can:</h4>
      - Catch fire <br>
      - Tug on pots and pans <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">7 / 8</div>
      <center><img src="/images/kitchenImages/7.jpeg"></center>
      <div class="text"><h3>7. Keep kitchen sanitary</h3>
    - In order to prevent the spread of bacteria and germs <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">8 / 8</div>
      <center><img src="/images/kitchenImages/8.jpeg"></center>
      <div class="text"><h3>8. Check that everything is turned off before you leave</h3>
    - Make sure all appliances are off before going to eat or leaving the kitchen <br> </div>
    </div>

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

    </div>
    <br>

    

    <script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      if (n > slides.length) {slideIndex = 1}    
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";  
      }
      for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";  
      dots[slideIndex-1].className += " active";
    }
    </script>
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
