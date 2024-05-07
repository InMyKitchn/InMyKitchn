/**
 * navigation.js
 * 
 * Navigation bar related functions and code
 * 
 * MUST be referenced on any HTML page with the navigation bar
 * SHOULD be referenced on ALL HTML pages for consistency
 */

// Helps find hidden errors; do not remove
'use strict';

// Adds the navigation bar to the pages this js file is referenced
fetch('/html/includes/navigation.php')
.then(res => res.text())
.then(text => {
    let oldelem = document.querySelector("script#replaceWithNavigation");
    let newelem = document.createElement("div");
    newelem.innerHTML = text;
    oldelem.parentNode.replaceChild(newelem,oldelem);
})

// Adds the responsive class to the navigation bar when screen width is small
// Makes the navigation bar look better on smaller screens
function navCondense() {
  var navBars = document.getElementsByClassName("topNav");
  var num;
  for (num = 0; num < navBars.length; num++) {
    if (navBars[num].className === "topNav") {
      navBars[num].className += " responsive";
    } else {
      navBars[num].className = "topNav";
    }
  }
}
