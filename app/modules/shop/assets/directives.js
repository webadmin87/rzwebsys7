(function(angular){

    var module = angular.module("shopModule");

    /**
     * Директива добавления товара в корзину
     */
    module.directive('shopToBasket', ['shopBasket', 'shopMessages', function(shopBasket, shopMessages) {

        return {

            restrict: 'A',

            link: function($scope, element, attrs) {

                $scope.qty = 1;

                $scope.label = shopMessages.toCart;

                $scope.order = shopBasket.getOrder();

                $scope.$watch('order', function(newVal) {

                    if(shopBasket.inOrder(newVal, attrs.itemId, attrs.className)) {

                        $scope.label = shopMessages.inCart;

                    }

                }, true);

                $scope.addToCart = function() {

                    shopBasket.add(attrs.itemId, attrs.className, $scope.qty);

                    $scope.label = shopMessages.inCart;

                }

            }

        }

    }]);

})(angular);