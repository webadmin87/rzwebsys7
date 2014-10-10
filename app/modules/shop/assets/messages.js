(function(angular){

    var module = angular.module('shopModule');

    /**
     * Сообщения локализации
     */
    module.value('shopMessages', {
        addedToCart:"Товар успешно добавлен в корзину",
        toCart: "В корзину",
        inCart: "В корзине",
        fieldError: "Значение поля задано неверно"
    });

})(angular);