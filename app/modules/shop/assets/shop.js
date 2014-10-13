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
        deliveries: '/shop/basket-rest/deliveries/',
        confirm: '/shop/basket-rest/confirm/'

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

        /**
         * Поиск объекта в массиве по значению атрибута
         * @param array arr массив
         * @param string key ключ
         * @param mixed value значение
         * @returns {*}
         */
        this.findObject = function(arr, key, value) {

            for(var i in arr) {

                if(arr[i][key] == value) {

                    return arr[i];

                }

            }

            return null;

        }

        /**
         * Удаляет все свойства объекта
         * @param obj
         */
        this.clearObject = function(obj) {

            for(var k in obj)
                delete obj[k];

        }

        /**
         * Получение способов доставки
         * @returns {{}}
         */
        this.getDeliveries = function() {

            var o = self.getOrder();

            if(!o.delivery_id && o.deliveries.length > 0) {
                o.delivery_id = o.deliveries[0].id;
                self.syncOrder();
            }


            return o.deliveries;

        }

        /**
         * Получение способов оплаты
         * @returns {{}}
         */
        this.getPayments = function() {


            var o = self.getOrder();

            if(!o.payment_id && o.payments.length > 0)
                o.payment_id = o.payments[0].id;


            return o.payments;

        }

        /**
         * Подтверждение заказа
         */
        this.confirmOrder = function(okCallback, errorCallback) {


            var error = function(data) {

                errorCallback(data);

            }

            var success = function(data) {

                okCallback(data);

                self.setStat({count:0, summ: 0});

                self.clearObject(order);

            }


            $http.post(urlMapping.confirm, {'Order': this.getOrder()}).success(function(data, status){

                if(status == 201)
                    success(data)
                else
                    error(data);

            }).error(error);

        }

    }]);

})(angular, jQuery);