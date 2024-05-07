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
      <div class="numbertext">1 / 11</div>
      <img src="https://media.npr.org/assets/img/2021/10/22/magic-water-2-3_custom-2e08bfd5fa678cc7f4e44e52b370d82075d7a1ef-s800-c85.webp" style="width:100%">
      <div class="text"><h3>1. Drink lots of water </h3><br>
        - Drinking water helps you stay hydrated without adding calories to your diet.<br>
        - If clean water is not available, drink boiled water.<br><br><br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">2 / 11</div>
      <img src="https://cdn1.sph.harvard.edu/wp-content/uploads/sites/21/2018/07/fruitveg-1024x706.jpeg" style="width:100%">
      <div class="text"><h3>2. Eat plenty of vegetables and fruits</h3><br>
        - They contain important nutrients such as antioxidants, vitamins, minerals and fibre which can help your body maintain a healthy weight. <br><br><br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">3 / 11</div>
      <img src="https://www.eatthis.com/wp-content/uploads/sites/4/2016/02/high-protein-foods.jpg?quality=82&strip=all" style="width:100%">
      <div class="text"><h3>3. Eat foods that are high in protein</h3><br>
        - Foods that are high in protein are legumes, nuts, tofu, meat, fish, lower fat yogurts, etc. <br>
        - If you are vegetarian/vegan, make sure you include a good amount of protein in your day-to-day diet (ex. legumes, nuts, tofu). <br>
        - Protein helps build your muscles, bones and skin. <br>
        - Low fat and unflavoured dairy products are also high in protein. <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">4 / 11</div>
      <center><img src="https://i.dailymail.co.uk/i/newpix/2018/09/13/21/5023BD2D00000578-6165377-image-a-1_1536869661623.jpg"></center>
      <div class="text"><h3>4. Cut down the amount of fast food you consume</h3>
    - Fast foods are good once in a while but your body should not be digesting it on a daily basis. <br>
    - Fast foods can make it harder for you to maintain a healthy weight and system in your body. <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">5 / 11</div>
      <img src="https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/creamy-oatmeal-bowl-with-banana-blueberries-royalty-free-image-1619015007.?crop=1.00xw:0.632xh;0,0.258xh&resize=980:*" style="width:100%">
      <div class="text"><h3>5. Do NOT skip breakfast</h3>
    - Breakfast is one of the most important meals of the day, please don’t skip it! <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">6 / 11</div>
      <img src="https://i.dietdoctor.com/wp-content/uploads/2018/07/starchyfoods.jpg?auto=compress%2Cformat&w=800&h=388&fit=crop" style="width:100%">
      <div class="text"><h3>6. Incorporate high fibre starchy carbohydrates into your meals/diet</h3>
    - Examples of these types of foods are : potatoes, bread, rice, pasta and cereals. <br>
    - Choosing foods with high fibre or are wholegrain, such as wholewheat pasta, brown rice or potatoes with their skins on is a better option.<br>
    - Recommended you include at least 1 starchy carbohydrate into each main meal. <br>
    - Be careful on how much oil you put on these foods. <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">7 / 11</div>
      <img src="https://images.livemint.com/rf/Image-621x414/LiveMint/Period2/2017/01/31/Photos/Processed/donouts-k1JD--621x414@LiveMint.jpg" style="width:100%">
      <div class="text"><h3>7. Cut down on your intake of saturated fat and sugary foods</h3>
      - Examples of these foods include : cakes, sweets, chocolate/candy, fatty cuts of meat, butter, etc. <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">8 / 11</div>
      <img src="https://belvoir-university-health.s3.amazonaws.com/media/2020/12/08041600/calcium-rich-foods.jpg">
      <div class="text"><h3>8. Make sure to have calcium </h3>
    - Important in developing your bones and teeth as well as carrying out cellular processes <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">9 / 11</div>
      <img src="https://www.pritikin.com/wp/wp-content/uploads/2014/10/salt-substitute-healthy.jpg" style="width:100%">
      <div class="text"><h3>9. Consume less sodium </h3>
      - Too much sodium can be bad for you health because it increases the risk of developing high blood pressure <br>
      - Make sure you read the Nutrition Facts label and choose food to get less than 100% daily value (less than 2300 mg) of sodium each day <br>
      - Buy fresh foods instead of processed foods <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">10 / 11</div>
      <img src="https://www.helpguide.org/wp-content/uploads/avocado-coconut-mixed-nuts-768.jpg" style="width:100%">
      <div class="text"><h3>10. Know the difference between good and bad fats </h3>
      - Unsaturated fats help maintain fullness and also help certain organs to grow and stay healthy <br>
      - Saturated fats can clog arteries leading to major health problems putting you at risk of stroke or heart attack <br>
      - Trans Fats more commonly clog arteries, as well as put you to risk of potential cancers <br></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">11 / 11</div>
      <img src="https://images.immediate.co.uk/production/volatile/sites/30/2020/08/balanced-diet-for-women-main-image-700-350-610255c.jpg?quality=90&webp=true&resize=300,272" style="width:100%">
      <div class="text"><h3>11. Manage your portions & balance your meals </h3>
    - Make sure that you have a balance in vegetables & fruits, whole grain foods, and protein <br>
    - Pay attention to the feeling of hunger, and stop eating once satisfied <br>
    - Do not overeat, Try to measure the amount of food you are consuming in every meal <br>
    - People generally aim to completely fill their plate, so next time don't buy the biggest ones at the store <br></div>
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
