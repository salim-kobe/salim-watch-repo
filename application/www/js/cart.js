'use strict';

// Execute la fonction lorsque le DOM sera complètement chargé
$( document ).ready(function() {
	 var cart = new CartSession();

	cart.buildCart();
});