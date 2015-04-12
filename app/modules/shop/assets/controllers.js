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

            shopBasket.del(model.item_key);

        }

        this.update = function(model) {

            shopBasket.update(model.item_key, model.qty);

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

        $scope.shopBasket = shopBasket;


        $scope.$watch('shopBasket.hasOrderLoaded', function(newVal){

            if(newVal) {

                $scope.deliveries = shopBasket.getDeliveries();

                $scope.payments = shopBasket.getPayments();

                $scope.$watch('order.delivery_id', function(newVal){

                    var d =shopBasket.findObject($scope.deliveries, 'id', newVal);

                    if(d)
                        $scope.deliveryDescription = d.text;

                });

                $scope.$watch('order.payment_id', function(newVal){

                    var p = shopBasket.findObject($scope.payments, 'id', newVal);

                    if(p)
                        $scope.paymentDescription = p.text;

                });

            }

        });

        this.confirmOrder = function() {

            shopBasket.confirmOrder(function(data){
                $scope.success = true;
                $scope.orderId = data.id;
            }, function(){
                $scope.success = false;
            });

        }

    }]);

    /**
     * Контроллер виджета корзины показывающего статистику
     */
    module.controller('BasketInfoCtrl', ['$scope', 'shopBasket', function($scope, shopBasket){

        $scope.stat = shopBasket.getStat();

    }]);


})(angular);