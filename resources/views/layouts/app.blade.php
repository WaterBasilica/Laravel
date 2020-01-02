<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{-- config('app.name', 'BLOG') --}}</title> -->
    <!-- <title>BLOG</title> -->
    <!-- <title>{{-- config(['app.name'=> true]) --}}</title> -->
    <title>@yield('title')</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
    $(function(){
      $(".delete_complete_message:not(:animated)").fadeIn("0",function(){
        $(this).delay(2700).fadeOut("slow");
      });
    });
    </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
            <a class="navbar-brand" href="{{ url('/', 'fromclick') }}">
            {{--    <a class="navbar-brand" href="{{ action('PostsController@index', 'frompost') }}">--}}
                    {{-- config('app.name', 'BLOG') --}}
                    {{Config::get('const.name')}}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                      <!--↓↓ 検索フォーム ↓↓-->
                      <div class="">
                      <form class="form-inline" action="{{ action('PostsController@serch', 'serch') }}">
                        <div class="form-group">
                        <input type="text" name="keyword" value="" class="form-control" placeholder="">
                        </div>
                        <input type="submit" value="検索" class="btn btn-info">
                      </form>
                      </div>
                      <!--↑↑ 検索フォーム ↑↑-->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
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
                                    <a class="dropdown-item" href="{{ route('deleteAccount') }}"
                                       onclick="if(confirm('アカウント削除します。本当によろしいですか？')) {
                                                    event.preventDefault();
                                                     document.getElementById('delete-form').submit();}">
                                        {{ __('DeleteAccount') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <form id="delete-form" action="{{ route('deleteAccount') }}" method="POST" style="display: none;">
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

          <div class="container">
            <div class="leftsidebar">
              @yield('leftsidebar')
            </div>
            <div class="contents">
              @yield('content')
          </div>
          <div class="allarticles">
            @yield('allarticlestitle')
            @yield('allarticles')
          </div>
          <div class="prfRightBox">
            @yield('prfRightBox')
          </div>

          </div>
        </main>
    </div>

</body>
</html>
