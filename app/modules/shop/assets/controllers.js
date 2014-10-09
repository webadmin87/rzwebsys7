(function(angular){

    var module = angular.module('shopModule');

    /**
     * Контроллер виджета добавления товаров в корзину
     */
    module.controller('ToBasketCtrl', ["$scope", function($scope){ }]);

    /**
     * Контроллер списка заказанных товаров в корзине
     */
    module.controller('OrderListCtrl', ["$scope", "shopBasket", function($scope, shopBasket){

        $scope.order = shopBasket.getOrder();

        this.del = function(model) {

            shopBasket.del(model.item_id, model.item_class);

        }

        this.update = function(model) {

            shopBasket.update(model.item_id, model.item_class, model.qty);

        }


    }]);

    /**
     * Контроллер виджета корзины показывающего статистику
     */
    module.controller('BasketInfoCtrl', ['$scope', 'shopBasket', function($scope, shopBasket){

        $scope.stat = shopBasket.getStat();

    }]);


})(angular);