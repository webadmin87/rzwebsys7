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

        $scope.readOnly = false;

    }]);

    /**
     * Контроллер оформления заказа
     */
    module.controller('ProcessOrderCtrl', ["$scope", "shopBasket", "shopMessages", function($scope, shopBasket, shopMessages){

        $scope.order = shopBasket.getOrder();

        $scope.messages = shopMessages;

        $scope.readOnly = true;

        $scope.deliveries = shopBasket.getDeliveries();

        $scope.payments = shopBasket.getPayments();


        this.syncOrder = function() {

            shopBasket.syncOrder();

        }

        /*$scope.$watch('order.delivery_id', function(newVal, oldVal){

            if(newVal != oldVal) {

                console.log(newVal, oldVal)



            }


        });*/

    }]);

    /**
     * Контроллер виджета корзины показывающего статистику
     */
    module.controller('BasketInfoCtrl', ['$scope', 'shopBasket', function($scope, shopBasket){

        $scope.stat = shopBasket.getStat();

    }]);


})(angular);