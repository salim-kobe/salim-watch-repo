'use strict'; 


// Images du slider
var slides = [
    { image: getWwwUrl() + '/images/slider/slider1.jpg'},
    { image: getWwwUrl() + '/images/slider/slider2.jpg'},
    { image: getWwwUrl() + '/images/slider/slider3.jpg'},
    { image: getWwwUrl() + '/images/slider/slider4.jpg'},
    { image: getWwwUrl() + '/images/slider/slider5.jpg'},
    { image: getWwwUrl() + '/images/slider/slider6.jpg'},
    { image: getWwwUrl() + '/images/slider/slider7.jpg'}
];


// Objet contenant l'état du slider
var state;


function sliderNext()
{
    // Passage à l'image suivante
    state.index++;

    // Si on arriver à la fin du tableau des images
    if(state.index == slides.length)
    {
        // On revient au début
        state.index = 0;
    }

    // Mise à jour de l'affichage.
    refreshSlider();
    
}


function sliderPrevious()
{
    // Passage à l'image précédente.
    state.index--;

    // Est-ce qu'on est revenu au début de la liste des slides ?
    if(state.index < 0)
    {
        // Oui, on revient à la fin 
        state.index = slides.length - 1;
    }

    // Mise à jour de l'affichage.
    refreshSlider();
}


function sliderButton(event)
{
var right = 37;
var left = 39;

    switch(event.keyCode)
    {
        case right:
        // On passe à l'image suivante.
        sliderNext();
        break;

        case left:
        // On passe à l'image précédente.
        sliderPrevious();
        break;
    }
}

function onSliderToggle()
{
        // Changement d'image toutes les 5 secondes.
        state.timer = window.setInterval(sliderNext, 5000);
 
}


function refreshSlider()
{
    var sliderImage;
    var sliderLegend;

    // Recherche des balises de contenu du slider
    sliderImage  = document.querySelector('#slider img');
    sliderLegend = document.querySelector('#slider figcaption');

    // Changement de la source de l'image 
    sliderImage.src = slides[state.index].image;
    
}


// Appel des fonctions du slider
document.addEventListener('DOMContentLoaded', function()
{
    // Initialisation du slider.
    state       = {};
    state.index = 0; // On commence du début
  
    // démarrage du slider
    onSliderToggle(); 

    // Utilisation des flèches gauche et droite
    document.addEventListener('keyup', sliderButton);
    
    // Affichage initial.
    refreshSlider();
});

