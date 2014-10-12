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

        // Был ли получен заказ с сервера

        this.hasOrderLoaded = false;

        /**
         * Получение заказа
         * @param bool refresh перезагрузить
         * @returns {{}}
         */

        this.getOrder = function(refresh) {

            if(!this.hasOrderLoaded || refresh) {

                $http.get(urlMapping.order).success(function(data){

                    angular.extend(order, data);

                    self.hasOrderLoaded = true;

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
         * @param function callback
         */

        this.loadIfNotEmpty = function(url, obj, callback) {

            if(angular.equals(obj, {})) {

                $http.get(url).success(function(data){

                    angular.extend(obj, data);

                    if(callback)
                        callback(data);

                });

            }

        }

        /**
         * Получение первого свойства объекта
         * @param obj
         * @returns {*}
         */
        this.getFirstKey = function(obj) {

            for(var k in obj) {

                return k;
                break;
            }

            return null;

        }

        var deliveries = {};

        /**
         * Получение способов доставки
         * @returns {{}}
         */
        this.getDeliveries = function() {

            this.loadIfNotEmpty(urlMapping.deliveries, deliveries, function(data){

                var o = self.getOrder();

                if(!o.delivery_id) {
                    o.delivery_id = self.getFirstKey(data);
                    self.syncOrder();
                }
            });

            return deliveries;

        }

        var payments = {};

        /**
         * Получение способов оплаты
         * @returns {{}}
         */
        this.getPayments = function() {

            this.loadIfNotEmpty(urlMapping.payments, payments, function(data){

                var o = self.getOrder();

                if(!o.payment_id)
                    o.payment_id = self.getFirstKey(data);

            });

            return payments;

        }


    }]);

})(angular, jQuery);