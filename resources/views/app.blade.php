<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @routes
</head>
<body class="bg-gray-100">

@inertia

</body>
</html>
