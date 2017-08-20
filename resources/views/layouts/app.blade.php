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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <!--<li><a href="{{ route('register') }}">Register</a></li>-->
                        @else
                            @if(Session::has('eventSelectedByUserForReceipt'))
                                <li><a href="{{ route('changeEvent') }}">{{ \App\Event::where('id', session('eventSelectedByUserForReceipt'))->first()->name }}</a></li>
                            @endif
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Receipt <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('newReceiptView') }}">New Receipt</a></li>
                                    <li><a href="{{ route('viewFullyPaid') }}">View Fully Paid Receipts</a></li>
                                    <li><a href="{{ route('viewNotFullyPaid') }}">View Not Fully Paid Receipts</a></li>
                                    <li><a href="{{ route('changeEvent') }}">Change Event</a></li>
                                    <?php 
                                        if (Auth::guest())
                                        {
                                            $event = \App\Event::where('id', session('eventSelectedByUserForReceipt'))->first();
                                            $privileged = $event->organization->receipts_handle_privileges;
                                            $privileged = json_decode($privileged);
                                            $user = \Auth::user();
                                            $user_privilege = $user->roles()->where('organization_id', $event->organization->id)->get();
                                            $privileges = [];
                                            foreach ($user_privilege as $userprivilege) {
                                                array_push($privileges, $userprivilege->privilege_level);
                                            }
                                            if (!empty(array_intersect($privileges, $privileged))) {
                                    ?>
                                                <li><a href="{{ route('dateWisePayment') }}">Date Wise Payment</a></li>
                                    <?php 
                                            }
                                        }
                                    ?>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    @yield('scripts')
</body>
</html>
