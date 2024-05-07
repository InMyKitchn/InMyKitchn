<!DOCTYPE html>
<html>
  <head>
    <!-- Go to website -->
    <script>
      window.onload = function() {
        window.location.href = "/html/main.php";
      }
    </script>

    <!-- If javascript is disabled -->
    <style>
      noscript {
        font-size: 4.5vw;
        text-align: center;
        color: crimson;
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
      }

      .textCenter {
        display: block; 
        width: 90%; 
        margin: auto; 
        margin-top: 25px;
      }

      .imgCenter {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 15%;
      }
    </style>
  </head>
  
  <body>
    <noscript>
      <p class="textCenter">JavaScript needs to be enabled for the site to work!</p>
      <br>
      <img src="/images/icons/kitchenError.svg" class="imgCenter"></img>
    </noscript>
  </body>
</html>