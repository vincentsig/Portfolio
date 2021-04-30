/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/admin.scss'; 


const $ = require('jquery');
require('bootstrap');
// start the Stimulus application
import './bootstrap';
import './animation.js';

// Effet Image Hero 

$( ".meLink" ).mouseover(function() {
    $( ".photobase" ).addClass( "hidehero" );
    $( ".photoskill" ).addClass( "hidehero" );
  }).mouseout(function() {
      $( ".photobase" ).removeClass( "hidehero" );
      $( ".photoskill" ).removeClass( "hidehero" );
  });
  
  $( ".projectsLink" ).mouseover(function() {
      $( ".photobase" ).addClass( "hidehero" );
    }).mouseout(function() {
        $( ".photobase" ).removeClass( "hidehero" );
    });


// Skill partials 

// Check pour la couleur
function isEven(value) {
	if (value%2 == 0) 
		return true;
	else
		return false;
}
// Check pour le décalage
function isThird(value) {
 const numbArray = [1,4,7,10,13,16,19];
numbArray.includes(value)
	if (numbArray.includes(value)  )
		return true;
	else
		return false;
}
// Récupération des boxs et contener de box
var skillsbox = document.querySelectorAll(".skills_list_box");
var skillsboxctn = document.querySelectorAll(".ctn_skills_list_box");

// Boucle d'ajout de la couleur
for (var i = 0; i < skillsbox.length; i++) {
  if (isEven(i) === true){
    skillsbox[i].classList.add('box_one');
} else {
   skillsbox[i].classList.add('box_two');
}
}
// Boucle d'ajout de la classe de decalage
for (var i = 0; i < skillsboxctn.length; i++) {
  if (isThird(i) === true){
   skillsboxctn[i].classList.add('ctn2_skills_list_box');
} 
}

//Projects Partial

    // clicking button with class "category-button"
    $(".category-button").click(function(){
 // get the data-filter value of the button
        var filterValue = $(this).attr('data-filter');
         
        // show all items
        if(filterValue == "all")
        {
            $(".all").show("");
        }
        else
        {   
            // hide all items
            $(".all").not('.'+filterValue).hide("");
            // and then, show only items with selected data-filter value
            $(".all").filter('.'+filterValue).show("");
        }
    })



