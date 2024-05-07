<?php
  // Logout
  if (isset($_COOKIE["loggedIn"])) {
    
    setcookie("loggedIn", null, time() - 3600, "/");
    unset($_COOKIE["loggedIn"]);
  }
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

    <!-- Home Page Content -->
    <div class="pageContent">
      <!-- Let user know they logged out -->
      <br><br><br><br>
      <h1>So sad to see you go! We hope you come back soon!</h1>
      <br><br><br><br>
    </div>


    <!-- Translation + Footer -->
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

      <!-- Footer -->
      <script id="replaceWithFooter" src="/js/includes/footer.js"></script>
    </div>
  </body>
</html>