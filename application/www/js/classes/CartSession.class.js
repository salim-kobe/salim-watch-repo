'use strict';



var CartSession = function() {
    // Contenu du panier
    this.items = null;
    this.$alertKo = $(".alert-danger");
    this.$alertOk = $(".alert-success");

    this.load();
};


// Message d'erreur
CartSession.prototype.showAlertFailed = function(message) {
    this.$alertKo.empty().text(message).show();
    this.$alertOk.hide();
}


// Message de validation
CartSession.prototype.showAlertSuccess = function(message) {
    this.$alertOk.empty().text(message).show();
    this.$alertKo.hide();
}


// Ajout des données dans le panier
CartSession.prototype.add = function(id, name, description, quantity, price, picture) {

    var index;

    if (isNaN(quantity)) {
        return this.showAlertFailed(" La quantité doit être un nombre");
    }
    if (quantity <= 0) {
        return this.showAlertFailed(" La quantité minimum est de 1 unité");
    }
    // Conversion explicite des valeurs spécifiées en nombres
    id = parseInt(id);
    quantity = parseInt(quantity);
    if (price.length > 0) {
        price = price.replace(" €", "").replace(",", "");
        price = parseFloat(price);
    }
    

    // Recherche de L'élément spécifié
    for (index = 0; index < this.items.length; index++) {


        if (this.items[index].id == id) {
            // L'élément spécifié a été trouvé, mise à jour de la quantité commandée
            this.items[index].quantity = quantity;
            

            this.save();
            this.showAlertSuccess("Votre panier a bien été mis à jour");
            $('.alert').alert();

            return;
        }
    }

    // L'élément spécifié n'a pas été trouvé, ajout au panier
    this.items.push({
        id: id,
        name: name,
        description: description,
        quantity: quantity,
        price: price,
        picture: picture
    });

    this.save();
    this.showAlertSuccess("Votre produit a bien été ajouté");

};


// Destruction du panier dans le DOM storage
CartSession.prototype.clear = function() {
    saveDataToDomStorage('panier', null);
};


CartSession.prototype.isEmpty = function() {
    return this.items.length == 0;
};


// Chargement du panier depuis le DOM storage
CartSession.prototype.load = function() {
    this.items = loadDataFromDomStorage('panier');

    if (this.items == null) {
        this.items = new Array();
    }
};


// Suppression d'un élément du panier
CartSession.prototype.remove = function(watchId) {
    var index;

    // Recherche de L'élément spécifié
    for (index = 0; index < this.items.length; index++) {
        if (this.items[index].id == watchId) {
            // L'élément spécifié a été trouvé, suppression
            this.items.splice(index, 1);

            this.save();

            this.showAlertSuccess("Le produit a bien été supprimé de votre panier");

            return true;
        }
    }
    this.showAlertFailed("Le produit n'a pas été retrouvé dans votre panier");

    return false;
};


// Enregistrement du panier dans le DOM storage
CartSession.prototype.save = function() {
    saveDataToDomStorage('panier', this.items);
};

// Construction du panier
CartSession.prototype.buildCart = function() {
    var productsCart = $("#productsCart");
    productsCart.empty();
    var totalPrice = 0;
    if (this.items.length > 0) {
        for (var index = 0; index < this.items.length; index++) {

            // Recherche dans le DOM et copie des éléments
            var card = $("#firstCard").find(".one-card").clone();

            var itemId = this.items[index].id;
            var itemName = this.items[index].name;
            var itemDescription = this.items[index].description;
            var itemPrice = this.items[index].price;
            var itemQuantity = this.items[index].quantity;
            var itemPicture = this.items[index].picture;
            var ItemTotalPrice = itemPrice * itemQuantity;
            totalPrice += ItemTotalPrice;

            // Attribution de valeurs aux éléments copiés
            card.find(".card-delete a").attr("onclick", "deleteCart(" + itemId + ")");
            card.find(".card-title").text(itemName);
            card.find(".card-text").text(itemDescription);
            card.find(".card-price").text(itemPrice + " €");
            card.find(".card-quantity input").val(itemQuantity);
            card.find(".card-quantity").attr("id", itemId);
            card.find(".card-picture img").attr("src", itemPicture);

            // Insèrtion du contenu spécifié
            productsCart.append(card.show());
        }
        $("#totalPrice").text(totalPrice + " €");

    } else {
        $("#submitCart").hide();
        $("#totalPrice").text("0 €");
        $("#productsCart").text("Aucun produit dans le panier");
    }

}


// Mise à jour du montant total du panier
CartSession.prototype.updateTotalCard = function() {
    var totalPrice = 0;

    $("#productsCart .card-quantity").each(function() {
        var quantity = parseInt($(this).find('input').val());
        var price = $(this).siblings().find(".card-price").text().replace(" €", "");
        price = parseFloat(price);
        totalPrice += price * quantity; 
    });

    $("#totalPrice").text(totalPrice + " €");

}

