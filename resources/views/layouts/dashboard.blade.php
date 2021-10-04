<!DOCTYPE html>
<html lang="{!! app()->getLocale() !!}">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css">
</head>

<body class="app sidebar-mini rtl">
    <div id="app">
        <dashboard></dashboard>
    </div>
    <!-- Essential JavaScripts for application to work-->
    <script src="{!! mix('/js/dashboard.js') !!}"></script>
</body>

</html>