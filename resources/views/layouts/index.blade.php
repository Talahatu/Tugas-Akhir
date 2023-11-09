<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ShopNow</title>
    <!-- MDB icon -->
    <link rel="icon" type="image/x-icon" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('mdb5/css/mdb.min.css') }}" />
    <!-- LeafletJS -->
    <link rel="stylesheet" href="{{ asset('leafletjs/leaflet.css') }}" />
    <script src="{{ asset('leafletjs/leaflet.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <!-- CSS -->
    @yield('css')
    @laravelPWA
</head>

<body>
    @include('layouts.navbar')
    <!-- Start your project here-->
    <div class="container">
        @yield('content')
    </div>
    <!-- End your project here-->

    <!-- MDB -->
    <script type="text/javascript" src="{{ asset('mdb5/js/mdb.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
        integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous">
    </script>
    <!-- Custom scripts -->
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", "#logout", function() {
                $(this).parent().submit()
            })

            $("#alertClose").on("click", function() {
                ($(this).parent()[0]).remove()
            });
        });
    </script>
    @yield('js')
</body>

</html>
