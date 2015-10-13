function menu() {
//    this.element = element;
}
menu.prototype.get = function(template, table) {
    $.ajax({
        url: "/settings/template",
        type: 'POST',
        data: 'template=' + template + '&table=' + table,
        success: function(data) {
            window.table = table;
            window.object = null;
            if ($("#" + template).length) {
                $("#" + template).remove();
            }
            $('#container').append(data);
            angular.bootstrap('#' + template, ["BusinessTablesApp"]);
        },
    });
};
menu.prototype.get_by_id = function(template, object, table) {
    $.ajax({
        url: "/settings/template",
        type: 'POST',
        data: 'template=' + template + '&table=' + table,
        success: function(data) {
//            console.log(template + table + object);
            window.object = object;
            window.table = table;
            if ($("#" + template).length) {
                $("#" + template).remove();
            }
            $('#container').append(data);
            angular.bootstrap('#' + template, ["BusinessTablesApp"]);
        },
    });
};