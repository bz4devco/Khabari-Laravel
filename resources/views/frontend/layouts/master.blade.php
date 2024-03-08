<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('frontend.layouts.head-tag')
    @yield('haed-tag')
</head>

<body>

    @include('frontend.layouts.header')

    <!-- CONTENT -->
    <main id="main">
        @yield('content')
    </main>

    <!-- SCROLL UP -->
    <a id="up" class="hide" href="#">
        <div class="up">
            <i class="fa fa-angle-up"></i>
        </div>
    </a>

    @include('frontend.layouts.partials.modals.login-modal')

    
    @include('frontend.layouts.footer')
    @include('frontend.layouts.scripts')
    @yield('script')
    
    @include('frontend.alerts.sweetalert.success')
    @include('frontend.alerts.sweetalert.error')

</body>

</html>