<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Heróes Digitales</title>
    <link rel="icon" href="/app/images/app-arts/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/bower_components/lumx/dist/lumx.css">
    <link rel="stylesheet" type="text/css" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/app/css/app.min.css">
</head>
<body ng-app="heroesDigitalesApp">
    <div id="loading"></div>
    <div ui-view="header"></div>
    <div ui-view="content"></div>
    <div ui-view="footer"></div>
    <div ui-view="user-header"></div>
    <div ui-view="user-content"></div>
    <div ui-view="user-footer"></div>
    <div ui-view="admin-header"></div>
    <div ui-view="admin-content"></div>
    <div ui-view="admin-footer"></div>
<!-- JS script to load gif -->
<script src="/app/js/loader.js"></script>
<script src="https://www.youtube.com/iframe_api"></script>
<!-- Bower dependencies -->
<script src="/app/js/main.min.js"></script>
<!-- Angular Script dependencies -->
<!-- App -->
<script src="/app/js/app.min.js"></script>
<!-- Controllers -->
<script src="/app/js/controllers.min.js"></script>
<!-- Services -->
<script src="/app/js/services.min.js"></script>
<!-- Filters -->
<script src="/app/js/filters.min.js"></script>
</body>
</html>
