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



    <!-- Scripts -->
  </head>


  <body>
    <!-- Navigation Bar -->
    <script id="replaceWithNavigation" src="/js/includes/navigation.js"></script>

    <div class="pageContent">
      
      <table>
        <thead>
          <tr>
            <th colspan="2">
              <h2>about the team</h2>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <img src="/images/people/Annie.jpg" width="700" height="700"> 
            </td>
            <td>
              <p> <h3>Annie Xie </h3>
               Annie is a Grade 10 student at Markville Secondary School. During her leisure time, she enjoys playing video games, watching anime and snowboarding.</p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/images/people/Ben.jpg" width="700" height="700">
            </td>
            <td>
              <p> <h3>Benjamin Ly</h3>
              Benjamin is a Grade 11 student attending	Tommy Douglas Secondary School. He enjoys video games and swimming as well as video editing and solving puzzles during his free time.  </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/images/people/Ellie.jpg" width="700" height="700">
            </td>
            <td>
              <p> <h3>Ellie Chan</h3>
              Ellie is a Grade 9 student at Markville Secondary School. When she has time, she likes dancing, swimming, playing piano, reading and doing calligraphy. </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/images/people/Francis.jpg" width="700" height="700">
            </td>
            <td>
              <p> <h3>Francis Lin</h3>
              Francis is a Grade 9 student attending Markville Secondary School. He likes to read, conduct research and learn new things in his free time. He also enjoys picking up new skills and new experiences. </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/images/people/Kevin.jpg" width="700" height="700">
            </td>
            <td>
              <p> <h3>Kevin Ge</h3> 
              Kevin is a Grade 11 student at Maple High School. During his free time, he enjoys swimming and playing video games. He holds a keen interest in coding and the arts. </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/images/people/Maham.jpg" width="700" height="700">
            </td>
            <td>
              <p> <h3>Maham Malik</h3>
              Maham goes to Maple High School. Some of her hobbies include painting, video editing and exploring the outdoors. </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/images/people/Samantha.jpeg" width="700" height="700">
            </td>
            <td>
              <p> <h3>Samantha Ly</h3>
              Samantha is a Grade 11 student attending Pierre Elliott Trudeau High School. She is interested in photograph, video editing and journaling. </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/images/people/Sinchana.jpg" width="700" height="700">
            </td>
            <td>
              <p> <h3>Sinchana Ananth</h3>
              Sinchana is currently a Grade 11 student at Stouffville District Secondary School. In her free time, she enjoys singing, reading and watching movies. </p>
            </td>
          </tr>
          <tr>
            <td>
              <img src="/images/people/Sophia.jpg" width="700" height="700">
            </td>
            <td>
              <p> <h3>Sophia Nguyen</h3>      
               Sophia is a Grade 11 student attending Maple High School. She plays sports recreationally and codes during her free time. </p>
            </td>
          </tr>
        </tbody>
      </table>
      
      
      
      
      
      
      
      
      
      
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