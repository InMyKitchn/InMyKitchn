<!--
  navigation.html

  Only called on when navigation.js is referenced in the body of a page
  Is not directly linked to

  Includes the code for the navigation bar
-->

<link rel="stylesheet" href="/css/modal.css" type="text/css"/>
<script src="/js/includes/navigation.js"></script>

<!--navigation bar-->
<nav class="topNav">
  <a href="/html/main.php"><i class="fa fa-home navIcon"></i>&ensp;home</a>
  <a href="/html/about.php"><i class="fa fa-info navIcon"></i>&ensp;about us</a>

  <!-- Information dropdown -->
  <div class="dropdown">
    <button class="dropbtn"><i class="fa fa-leanpub navIcon" aria-hidden="true"></i>&ensp;information&ensp;<i class="fa fa-caret-down navIcon"></i></button>
    <div class="dropdown-content">
      <a href="/html/healthTips.php"><i class="fa fa-medkit navIcon"></i>&ensp;health tips&ensp;&ensp;&nbsp;</a>
      <a href="/html/kitchenTips.php"><i class="fa fa-apple navIcon"></i>&ensp;kitchen tips&ensp;&ensp;&nbsp;</a>
    </div>
  </div>

  <!-- Login/Logout -->
  <a style="float: right" href=<?php 
    if (isset($_COOKIE["loggedIn"])) {
      echo "/html/includes/logout.php";
    } else {
      echo "#account";
    }
  ?>
    onclick=<?php
                      if (!isset($_COOKIE["loggedIn"])) {
                        // If not logged in, onclick show login modal
                        echo "document.getElementById('id01').style.display='block'";
                      } else {
                        // If already logged in, onclick logout by removing cookie
                        echo "location.href = 'logout.php'";
                      }
                    ?>>
    <i class="fa fa-sign-in navIcon"></i>
    &ensp;<?php 
            if (!isset($_COOKIE["loggedIn"])) {
              // If not logged in, prompt login
              echo "login";
            } else {
              // If already logged in, prompt logout
              echo "logout";
            }
          ?>
  </a>
  <a class="barIcon" href=# onclick="navCondense();"><i class="fa fa-bars navIcon"></i></a>
</nav>



<!--login-->
<div id="id01" class="modal">
  <!-- action="/action_page.php" -->
  <form class="modalContent animateZoom" method="POST">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close">&times;</span>
      <!--<img src="img_avatar2.png" alt="avatar" class="avatar">-->
    </div>
    <div class="container">
      <label for="uname"><b>username</b></label>
      <input type="text" id="usernameLoginBox" placeholder="enter username" name="uname" required><br><br>

      <label for="psw"><b>password</b></label>
      <input type="password" id="passwordLoginBox" placeholder="enter password" name="psw" required>
      <br><br>
      <button type="submit" onclick="getLoginCookie(); checkLoginCred();">log in</button><br>
      <a onclick="document.getElementById('id02').style.display='block'" class="showSignup" id="signup"><center> not signed up, yet? create an account today!</center></a>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">cancel</button>
      <span class="psw"><a href="#" id="psw">forgot password?</a></span>
    </div>
  </form>
</div>

<script>
  // Get the modal
  var modal = document.getElementById('id01');

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }
</script>


<!--signup-->
<div id="id02" class="modal">
  <!-- action="/action_page.php" -->
  <form class="modalContent animateZoom"  method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close">&times;</span>
      <!--<img src="img_avatar2.png" alt="avatar" class="avatar">-->
    </div>
    <div class="container">
      <label for="uname"><b>username</b></label>
      <input type="text" id="usernameSignupBox" placeholder="enter username" name="unameSignUp" required><br><br>

      <label for="psw"><b>password</b></label>
      <input type="password" id="passwordSignupBox" placeholder="enter password" name="pswSignUp" required><br><br>

      <label for="credit"><b>credit card</b></label>
      <input type="text" id="creditCard" placeholder="enter credit card information" name="creditSignUp" required>
      <br><br>
      <button type="submit">sign up</button>
      
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">cancel</button>
    </div>
  </form>
</div>

<script>
  // Get the modal
  var modal = document.getElementById('id02');

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }
</script>  




