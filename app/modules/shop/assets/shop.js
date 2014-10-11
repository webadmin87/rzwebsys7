(function(angular, $){

    var module = angular.module('shopModule', []);

    /**
     * Меппинг url адресов
     */

    module.value('urlMapping', {

        add: '/shop/basket-rest/add/',
        del: '/shop/basket-rest/delete/',
        update: '/shop/basket-rest/update/',
        stat: '/shop/basket-rest/stat/',
        order: '/shop/basket-rest/order/',
        setOrder: '/shop/basket-rest/set-order/',
        payments: '/shop/basket-rest/payments/',
        deliveries: '/shop/basket-rest/deliveries/'

    });


    /**
     * Сервис уведомлений
     */
    module.service("basketNotifier", ["shopMessages", function(shopMessages){

        this.addNotify = function() {

            alert(shopMessages.addedToCart);

        }

    }]);

    /**
     * Сервис управления корзиной
     */

    module.service("shopBasket", ["$http", "urlMapping", "basketNotifier", function($http, urlMapping, basketNotifier){

        var self = this;

        // Статичтика корзины

        var stat = {};

        /**
         * Получение статистики
         * @param bool refresh перезагрузить
         * @returns {{}}
         */
        this.getStat = function(refresh) {

            if(angular.equals(stat, {}) || refresh) {

                $http.get(urlMapping.stat).success(function(data){

                    angular.extend(stat, data);

                });

            }

            return stat;

        }

        /**
         * Установка статистики
         * @param object data
         */
        this.setStat = function(data) {

            angular.extend(stat, data);

        }

        /**
         * Добавление товара в корзину
         * @param int id идентификатор товара
         * @param string className класс товара
         * @param int qty количество
         */

        this.add = function(id, className, qty) {

            $http.post(urlMapping.add, {id: id, class: className, qty: qty}).success(function(data){
                basketNotifier.addNotify();
                self.setStat(data);
            });


        }

        var order = {};

        var hasOrderLoaded = false;

        /**
         * Получение заказа
         * @param bool refresh перезагрузить
         * @returns {{}}
         */

        this.getOrder = function(refresh) {

            if(!hasOrderLoaded || refresh) {

                $http.get(urlMapping.order).success(function(data){

                    angular.extend(order, data);

                    hasOrderLoaded = true;

                });

            }

            return order;

        }

        /**
         * Установка заказа
         * @param object data
         */
        this.setOrder = function(data) {

            angular.extend(order, data);

        }

        /**
         * Присутствует ди в заказе товар
         * @param object order заказ
         * @param int id идентификатор товара
         * @param string className имя класса товара
         * @returns {boolean}
         */
        this.inOrder = function(order, id, className) {

            if(!order.allGoods)
                return false;

            for(var k in order.allGoods) {

                var i = order.allGoods[k];

                if(i.item_id == id && i.item_class == className)
                    return true;

            }

            return false;

        }

        /**
         * Удаление элемента из заказа
         * @param int id идентификатор элемента
         * @param string className класс элемента
         */
        this.del = function(id, className) {

            $http.delete(urlMapping.del, {params:{id: id, class: className}}).success(function(data){

                self.setOrder(data);

                self.getStat(true);

            });

        }

        /**
         * Изменение количества
         * @param int id идентификатор элемента
         * @param string className класс элемента
         * @param int qty количество
         */
        this.update = function(id, className, qty) {

            $http.put(urlMapping.update, {qty: qty}, {params:{id: id, class: className}}).success(function(data){

                self.setOrder(data);

                self.getStat(true);

            });

        }


        /**
         * Синхронизация заказа с сервером
         */
        this.syncOrder = function() {


            $http.put(urlMapping.setOrder, {'Order': this.getOrder()}).success(function(data){

                self.setOrder(data);

            });


        }

        /**
         * Получает данные с сервера если объект является путым {}
         * @param string url
         * @param object obj
         */

        this.loadIfNotEmpty = function(url, obj) {

            if(angular.equals(obj, {})) {

                $http.get(url).success(function(data){

                    angular.extend(obj, data);

                });

            }

        }


        var deliveries = {};

        /**
         * Получение способов доставки
         * @returns {{}}
         */
        this.getDeliveries = function() {

            this.loadIfNotEmpty(urlMapping.deliveries, deliveries);

            return deliveries;

        }

        var payments = {};

        /**
         * Получение способов оплаты
         * @returns {{}}
         */
        this.getPayments = function() {

            this.loadIfNotEmpty(urlMapping.payments, payments);

            return payments;

        }


    }]);

})(angular, jQuery);