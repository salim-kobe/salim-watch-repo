'use strict';
function getWwwUrl()
{
	var wwwUrl;

	/*
	 * Création de l'équivalent de la variable de template PHP $wwwUrl
	 * contenant l'URL du dossier www.
	 *
	 * Cette variable permet de créer des URLs vers des fichiers statiques.
	 */
	wwwUrl = window.location.href;
	wwwUrl = wwwUrl.substr(0, wwwUrl.indexOf('/index.php')) + '/application/www';

	return wwwUrl;
}

$(document).ready(function() {

    //ajout produit dans le panier
    $("#submitProduct").click(function() {
        var cart = new CartSession();
        var productId = $("#productId").val();
        var productName = $("#productName").text();
        var productDescription = $("#productDescription").text();
        var productQuantity = $("#productQuantity").val();
        var productPrice = $("#productPrice").text();
        var productPicture = $("#productPicture").attr("src");
        var response = cart.add(productId, productName, productDescription, productQuantity, productPrice, productPicture);
    });

    //mise à jour de la quantité dans le panier
    $(".card-quantity input").change(function() {
        var quantity = $(this).val();
        if (isNaN(quantity) == false && quantity >= 0) {
            var cart = new CartSession();
            var productId = $(this).parent().attr("id");

            var response = cart.add(productId, "", "", quantity, 0, "");

            cart.updateTotalCard();
        }
    });

    // Enregistrement de la commande
    $("#submitCart").click(function() {
        var cart = new CartSession();
        var datas = [];
        var totalAmount = $("#totalPrice").text().replace(" €", "");

        for (var index = 0; index < cart.items.length; index++) {
            datas.push({
                id: cart.items[index].id,
                quantity: cart.items[index].quantity,
                price: cart.items[index].price
            });
        }

        // requête ajax pour enregistrer la commande dans la BDD
        datas = JSON.stringify(datas);
        $.ajax({
            url: "cart",
            method: "POST",
            dataType: "json",
            data: {
                "orderLines": datas,
                "totalAmount": totalAmount,
                "isAjax": "true",
                "method": "saveCart"
            },
            success: function(response) {

                if (response =="1") {
                    $("#modalBodyContent").empty().text("Votre commande a bien été enregistrée.");
                    cart.clear();
                } else {
                    $("#modalBodyContent").empty().text("Votre commande n'a pu être enregistrée. Veuillez réessayer ultérieurement.");
                }
                $('#myModal').modal("show");
            }
        });
    });
});

// Supprime un produit du panier à partir de son ID
function deleteCart(itemId) {
    var cart = new CartSession();
    var result = cart.remove(itemId);
    if (result == true) {
        cart.buildCart();
    }

}