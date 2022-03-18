<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <style scoped>
      /*
      *
      * ==========================================
      * CUSTOM UTIL CLASSES
      * ==========================================
      *
      */

      .vertical-nav {
        min-width: 17rem;
        width: 17rem;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.4s;
      }

      .page-content {
        width: calc(100% - 17rem);
        margin-left: 17rem;
        transition: all 0.4s;
      }

      /* for toggle behavior */

      #sidebar.active {
        margin-left: -17rem;
      }

      #content.active {
        width: 100%;
        margin: 0;
      }

      @media (max-width: 768px) {
        #sidebar {
          margin-left: -17rem;
        }
        #sidebar.active {
          margin-left: 0;
        }
        #content {
          width: 100%;
          margin: 0;
        }
        #content.active {
          margin-left: 17rem;
          width: calc(100% - 17rem);
        }
      }

      /*
      *
      * ==========================================
      * FOR DEMO PURPOSE
      * ==========================================
      *
      */

      body {
        /** background: #599fd9; */
        min-height: 100vh;
        overflow-x: hidden;
      }

      .separator {
        margin: 3rem 0;
        border-bottom: 1px dashed #fff;
      }

      .text-uppercase {
        letter-spacing: 0.1em;
      }

      .text-gray {
        color: #aaa;
      }
      </style>


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <img src="{{ asset('img/tc_logo.png') }}" class="img-fluid" width="35" alt="">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
{{--                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif--}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12 mx-auto">

                <div>
                    {{-- Sidebar --}}
                    @auth()
                      <dashboard-sidebar-menu-component brand="{{ asset('img/tc_logo.png') }}" username="{{ Auth()->user()->name }}"></dashboard-sidebar-menu-component>
                    @endauth

                  <!-- Page content holder -->
                  <div class="page-content p-5" id="content">
                    <!-- Toggle button -->
                    @auth()
                    <button
                      id="sidebarCollapse"
                      type="button"
                      class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"
                    >
                      <i class="fa fa-bars mr-2"></i>
                      <small class="text-uppercase font-weight-bold">Toggle Sidebar</small>
                    </button>
                    @endauth

                    @yield('content')

                  </div>
                  <!-- End demo content -->
                </div>
              </div>
            </div>
          </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script>
      $(function() {
        // Sidebar toggle behavior
        $('#sidebarCollapse').on('click', function() {
          $('#sidebar, #content').toggleClass('active');
        });
      });
    </script>
</body>
