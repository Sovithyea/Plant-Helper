<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Plant Helper</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{asset('images/plant_helper.png')}}">
    {{-- <link href="{{ asset('mdicon/materialdesignicons.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('fonts/icofont/icofont.min.css') }}">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}" >
</head>
<body>
    <div id="app">
        <main-app></main-app>
    </div>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7xGqVP1Ph-zAHD1A4HaTE4-iKMhcdiVc"></script>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
