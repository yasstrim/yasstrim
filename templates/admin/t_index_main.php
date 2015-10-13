<html ng-app="App">
    <head>
        <title>Бизнес контроль v 2.02</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="/resourses/css/reset.css">
        <link rel="stylesheet" type="text/css" href="/resourses/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/resourses/elfinder.min.css">    
        <link rel = "stylesheet" type = "text/css" href = "/resourses/css/admstyle.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="/resourses/js/jquery-2.1.1.min.js"></script>
        <script src="/resourses/bootstrap/js/bootstrap.js"></script>
        <script src="//ulogin.ru/js/ulogin.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.15/angular.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.15/angular-route.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.15/angular-animate.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.15/angular-cookies.js"></script>
        <script src="/script/core/controller.js"></script>
        <script src="/script/core/app.js"></script>
    </head>
    <body>
        <div class="left">
            <ul id="menu">
                <li>
                    <a>NDPORT</a>
                    <ul>
                        <li>
                            <a href="#adverts">Объявления</a>
                        </li>
                        <li>
                            <a href="#users">Пользователи</a>
                        </li>
                        <li>
                            <a href="#NScat">Дерево</a>
                        </li>


                    </ul>
                </li>
                <li>
                    <a href="/index/exit">Выйти</a>
                </li>
            </ul>
        </div>
        <div ng-view class="container"></div>
        <div class="clear"></div>
    </body>
</html>