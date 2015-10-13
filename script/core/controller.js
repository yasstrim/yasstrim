$(document).ready(function() {
    $("#status").hide();
});
function server(module, table) {
    this.module = module;
    this.table = table;
}
server.prototype.get = function(object) {
    var request;
    $.ajax({
        url: '/settings/factory',
        data: 'module=' + this.module + '&action=get&table=' + this.table + '&object=' + JSON.stringify(object),
        cache: true,
        type: "POST",
        async: false,
        dataType: "json",
        success: function(data) {
            request = data;
            console.log(data);
        },
    });
    return request;
};
server.prototype.getById = function(object) {
    console.log(object);
    var request;
    $.ajax({
        url: '/settings/factory',
        data: 'module=' + this.module + '&action=create&table=' + this.table + '&object=' + JSON.stringify(object),
        type: "POST",
        async: false,
        dataType: "json",
        success: function(data) {
            request = data;
            console.log(data);
        },
    });
    return request;
};
server.prototype.getByGood = function(object) {
    console.log(object);
    var request;
    $.ajax({
        url: '/settings/factory',
        data: 'module=' + this.module + '&action=get_by_good&table=' + this.table + '&object=' + JSON.stringify(object),
        type: "POST",
        async: false,
        dataType: "json",
        success: function(data) {
            request = data;
            console.log(data);
        },
    });
    return request;
};
server.prototype.insert = function(object, files) {
    console.log(JSON.stringify(object));
    if (files) {
        console.log(files);
        fd = new FormData();
        for (i = 0; i < files.length; i++) {
            fd.append("file" + i, files[i]);
        }
        fd.append('object', JSON.stringify(object));
        fd.append('module', this.module);
        fd.append('action', 'insert');
        fd.append('table', this.table);
        console.log(fd);
        $.ajax({
            url: '/settings/factory',
            data: fd,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
            }

        });
    } else {
        $("#status").show();
        $.ajax({
            url: '/settings/factory',
            data: 'module=' + this.module + '&action=insert&table=' + this.table + '&object=' + JSON.stringify(object),
            type: "POST",
            success: function(data) {
                console.log(data);
                $("#status").text("Сохранено!");
                $("#status").fadeOut(2500);
            },
        });
    }
};
server.prototype.edit = function(object, files) {
    if (files) {
        console.log(files);
        fd = new FormData();
        for (i = 0; i < files.length; i++) {
            fd.append("file" + i, files[i]);
        }
        fd.append('object', JSON.stringify(object));
        fd.append('module', this.module);
        fd.append('action', 'edit');
        fd.append('table', this.table);
        console.log(fd);
        $.ajax({
            url: '/settings/factory',
            data: fd,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
            }

        });
    } else {
        $("#status").show();
        $.ajax({
            url: '/settings/factory',
            data: 'module=' + this.module + '&action=edit&table=' + this.table + '&object=' + JSON.stringify(object),
            type: "POST",
            success: function(data) {
                console.log(data);
                $("#status").text("Сохранено!");
                $("#status").fadeOut(2500);
            },
        });
    }
};
server.prototype.del = function(object) {
    $("#status").show();
    $.ajax({
        url: '/settings/factory',
        data: 'module=' + this.module + '&action=del&table=' + this.table + '&object=' + JSON.stringify(object),
        type: "POST",
        success: function(data) {
            console.log(data);
            $("#status").text("Сохранено!");
            $("#status").fadeOut(2500);
        },
    });
};
app.service('server', function($http) {
    return {
        get: function(object) {
            var request;
            $.ajax({
                url: '/settings/factory',
                data: 'module=' + this.module + '&action=get&table=' + this.table + '&object=' + JSON.stringify(object),
                cache: true,
                type: "POST",
                async: false,
                dataType: "json",
                success: function(data) {
                    request = data;
                    console.log(data);
                },
            });
            return request;
        },
        insert: function(object) {
            $("#status").show();
            $.ajax({
                url: '/settings/factory',
                data: 'module=' + this.module + '&action=insert&table=' + this.table + '&object=' + JSON.stringify(object),
                type: "POST",
                success: function(data) {
                    console.log(data);
                    $("#status").text("Сохранено!");
                    $("#status").fadeOut(2500);
                },
            });
        }
    };
});