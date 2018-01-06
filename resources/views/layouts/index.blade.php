<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <!-- <script src="//{{ Request::getHost() }}:9090/socket.io/socket.io.js"></script> -->

    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
    <style type="text/css">
        /* Enter and leave animations can use different */
        /* durations and timing functions.              */
        .slide-fade-enter-active {
            transition: all .3s ease;
        }
        .slide-fade-leave-active {
            transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
        }
        .slide-fade-enter, .slide-fade-leave-to
            /* .slide-fade-leave-active below version 2.1.8 */ {
            transform: translateX(10px);
            opacity: 0;
        }

        .fade-enter-active, .fade-leave-active {
            transition: opacity .5s
        }
        .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
            opacity: 0
        }

        .bounce-enter-active {
            animation: bounce-in .5s;
        }
        .bounce-leave-active {
            animation: bounce-in .5s reverse;
        }
        @keyframes bounce-in {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.5);
            }
            100% {
                transform: scale(1);
            }
        }

        .card {
            transition: all 0.5s;

        }
        .card-enter, .card-leave-to
            /* .card-leave-active for <2.1.8 */ {
            opacity: 0;
            transform: scale(0);
        }
        .card-enter-to {
            opacity: 1;
            transform: scale(1);
        }

        .card-leave-active {
            /*position: absolute;*/
        }

        .card-move {
            opacity: 1;
            transition: all 0.5s;
        }
    </style>
</head>
<body>
    <div id="app" class="container-full" style="background:#f3f3f3;">
        <navbar :sitename="'{{ config('app.name', 'Laravel') }}'"  :user="{{ $user }}"></navbar>
        <br><br><br><br>
        <router-view :sitename="'{{ config('app.name', 'Laravel') }}'" :user="{{ $user }}"></router-view>
        <vue-progress-bar></vue-progress-bar>
        <vue-footer :sitename="'{{ config('app.name', 'Laravel') }}'"></vue-footer>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <scirpt type="javascript">

    </scirp>
    <script type="text/javascript">
        $(document).ready(function(){
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        });

        if ( (location.hash == "#_=_" || location.href.slice(-1) == "#_=_") ) {
            removeHash();
        }

        function removeHash() {
            var scrollV, scrollH, loc = window.location;
            if ('replaceState' in history) {
                history.replaceState('', document.title, loc.pathname + loc.search);
            } else {
                // Prevent scrolling by storing the page's current scroll offset
                scrollV = document.body.scrollTop;
                scrollH = document.body.scrollLeft;

                loc.hash = '';

                // Restore the scroll offset, should be flicker free
                document.body.scrollTop = scrollV;
                document.body.scrollLeft = scrollH;
            }
        }

    </script>
</body>
</html>
