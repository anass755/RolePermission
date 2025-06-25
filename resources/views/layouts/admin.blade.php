<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	 

    <title>XGadgets</title>
    <link rel="stylesheet" href="{{ asset('css/category.css')}}">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap -->
        <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{ asset('css/nprogress.css') }}" rel="stylesheet">
        <!-- iCheck -->
        <link href="{{ asset('css/green.css') }}" rel="stylesheet">
        
        <!-- bootstrap-progressbar -->
        <link href="{{ asset('css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
        <!-- JQVMap -->
        <link href="{{ asset('css/jqvmap.min.css') }}" rel="stylesheet"/>
        <!-- bootstrap-daterangepicker -->
        <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- menu footer buttons  -->
        @include('partials.left-navbar')
        <!-- /menu footer buttons -->
        <!-- top navigation -->
        @include('partials.top-navbar')
        <!-- /top navigation -->
        <div class="right_col" role="main" style="min-height: 1758px;">
          {{ $slot }}
        </div>  
        <!-- footer content -->
        @include('partials.footer')
        <!-- /footer content -->
      </div>
    </div>
       
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('js/fastclick.js') }}"></script>
        <!-- NProgress -->
        <script src="{{ asset('js/nprogress.js') }}"></script>
        <!-- Chart.js -->
        <script src="{{ asset('js/Chart.min.js') }}"></script>
        <!-- gauge.js -->
        <script src="{{ asset('js/gauge.min.js') }}"></script>
        <!-- bootstrap-progressbar -->
        <script src="{{ asset('js/bootstrap-progressbar.min.js') }}"></script>
        <!-- iCheck -->
        <script src="{{ asset('js/icheck.min.js') }}"></script>
        <!-- Skycons -->
        <script src="{{ asset('js/skycons.js') }}"></script>
        <!-- Flot -->
        <script src="{{ asset('js/jquery.flot.js') }}"></script>
        <script src="{{ asset('js/jquery.flot.pie.js') }}"></script>
        <script src="{{ asset('js/jquery.flot.time.js') }}"></script>
        <script src="{{ asset('js/jquery.flot.stack.js') }}"></script>
        <script src="{{ asset('js/jquery.flot.resize.js') }}"></script>
        <!-- Flot plugins -->
        <script src="{{ asset('js/jquery.flot.orderBars.js') }}"></script>
        <script src="{{ asset('js/jquery.flot.spline.min.js') }}"></script>
        <script src="{{ asset('js/curvedLines.js') }}"></script>
        <!-- DateJS -->
        <script src="{{ asset('js/date.js') }}"></script>
        <!-- JQVMap -->
        <script src="{{ asset('js/jquery.vmap.js') }}"></script>
        <script src="{{ asset('js/jquery.vmap.world.js') }}"></script>
        <script src="{{ asset('js/jquery.vmap.sampledata.js') }}"></script>
        <!-- bootstrap-daterangepicker -->
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('js/daterangepicker.js') }}"></script>

        <!-- Custom Theme Scripts -->
        <script src="{{ asset('js/custom.min.js') }}"></script>
        @stack('scripts')
  </body>
</html>
