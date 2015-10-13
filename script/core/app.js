//menu = new menu();
window.onbeforeunload = function() {
    return "Данные не будут сохранены!";
};
var app = angular.module('BusinessTablesApp', []);
app.service('$menu', function() {
    return{
        get: function(param, table) {
            console.log('init');
        },
    }
});
app.controller('mainCtrl', function($scope, $rootScope) {
    console.log('main init');
    $scope.dialogs = [];
    $rootScope.get = function(param, table, object) {
        $rootScope.table = table;
        $rootScope.object = object;
        $rootScope.close(param);
        $scope.dialogs.push({
            template: '/template/admin/view/' + param + '.html',
            show: true
        });
        console.log($scope.dialogs + $rootScope.table);
    }
    $rootScope.close = function(param) {
        console.log('close ' + param);
        angular.forEach($scope.dialogs, function(item, i) {
            if (item.template === '/template/admin/view/' + param + '.html') {
                $scope.dialogs.splice(i, 1);
            }
        });
        console.log($scope.dialogs);
    }
    $rootScope.get_by_id = function(param, object) {
        console.log('by_id');
        $rootScope.object = object;
        console.log($rootScope.object);
        $rootScope.get(param, null, object);
    }
});
app.filter('myfilter', function() {

    function strStartsWith(str, prefix) {
        return (str + "").indexOf(prefix) === 0;
    }
    return function(items, amount) {

        var filtered = [];
//        if (!filtered){
//            filtered = [];
//        }

        angular.forEach(items, function(item) {
            if (strStartsWith(item.goods_name, amount)) {
                filtered.push(item);
            }
        });

        return filtered;
    };
});
app.filter('categoryfilter', function() {
    return function(items, amount) {
        var filtered = [];
        if (amount !== '*') {
            angular.forEach(items, function(item) {
                if (item.goods_cat_idgoods_cat === amount) {
                    filtered.push(item);
                }
//                    console.log(item.customer_cat_idcustomer_cat);
            });
            return filtered;
        } else {
            return items;
        }

    };
});
app.filter('customer_cat', function() {
    return function(items, amount) {
        var filtered = [];
        if (amount !== '*') {
            angular.forEach(items, function(item) {
                if (item.customer_cat_idcustomer_cat === amount) {
                    filtered.push(item);
                }
//                    console.log(item.customer_cat_idcustomer_cat);
            });
            return filtered;
        } else {
            return items;
        }

    };
});
app.filter('content_cat', function() {
    return function(items, amount) {
        var filtered = [];
        if (amount !== '*') {
            angular.forEach(items, function(item) {
                if (item.content_cat_idcontent_cat === amount) {
                    filtered.push(item);
                }
//                    console.log(item.customer_cat_idcustomer_cat);
            });
            return filtered;
        } else {
            return items;
        }

    };
});
app.filter('contragent_cat', function() {
    return function(items, amount) {
        var filtered = [];
        if (amount !== '*') {
            angular.forEach(items, function(item) {
                if (item.contragent_cat_idcontragent_cat === amount) {
                    filtered.push(item);
                }
//                    console.log(item.customer_cat_idcustomer_cat);
            });
            return filtered;
        } else {
            return items;
        }

    };
});
app.filter('services_cat', function() {
    return function(items, amount) {
        var filtered = [];
        if (amount !== '*') {
            angular.forEach(items, function(item) {
                if (item.services_cat_idservices_cat === amount) {
                    filtered.push(item);
                }
//                    console.log(item.customer_cat_idcustomer_cat);
            });
            return filtered;
        } else {
            return items;
        }

    };
});
app.filter('repgoodfilter', function() {
    return function(items, amount) {
        var filtered = [];
        angular.forEach(items, function(item) {
            if (item.plus > 0 || item.minus > 0) {
                filtered.push(item);
            }
        });
        return filtered;
    };
});
