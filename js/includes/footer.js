/**
 * footer.js
 * 
 * Footer related functions and code
 * 
 * MUST be referenced on any HTML page with the navigation bar
 * SHOULD be referenced on ALL HTML pages for consistency 
 */

// Helps find hidden errors; do not remove
'use strict';

// Adds the footer to the pages this js file is referenced
fetch('/html/includes/footer.html')
.then(res => res.text())
.then(text => {
    let oldelem = document.querySelector("script#replaceWithFooter");
    let newelem = document.createElement("div");
    newelem.innerHTML = text;
    oldelem.parentNode.replaceChild(newelem,oldelem);
})