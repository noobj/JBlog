<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JBlog</title>
  <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
  <script src="https://code.jquery.com/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
  <!-- Fonts -->
  <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
  <!-- Google Code prettify -->
  <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
  <style>
    .linenums li {
      list-style-type: decimal;
    }
  </style>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">JBlog</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li>
              <a href="{{ url('/') }}">About</a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
            <!--li>
              <a href="{{ route('login') }}">Login</a>
            </li-->
            @else
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                @if (Auth::user()->can_post())
                <li>
                  <a href="{{ url('/new-post') }}">Add new post</a>
                </li>
                <li>
                  <a href="{{ url('/user/'.Auth::id().'/posts') }}">My Posts</a>
                </li>
                @endif
                <li>
                  <a href="{{ url('/user/'.Auth::id()) }}">My Profile</a>
                </li>
                <li>
                  <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                  <input type="hidden" name="user_token" value="{{ Auth::user()->api_token }}">
                </form>
              </li>
            </ul>
          </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    @if (Session::has('message'))
    <div class="flash alert-info">
      <p class="panel-body">
        {{ Session::get('message') }}
      </p>
    </div>
    @endif
    @if ($errors->any())
    <div class='flash alert-danger'>
      <ul class="panel-body">
        @foreach ( $errors->all() as $error )
        <li>
          {{ $error }}
        </li>
        @endforeach
      </ul>
    </div>
    @endif
    <div id='content' class="row-fluid">
      <div class=" col-md-10 main">
        <div class="">
          <div class="">
            @yield('content')
          </div>
        </div>
      </div>

      <div class="col-md-2 sidebar ">
        <b>Tag</b>
        <ul style="padding-left: 20px;">
          @foreach (\App\Tag::all() as $tag)
          @if ($tag->posts->count())
          <li>
            <a href="{{ url('showtag/'.$tag->name)}}">{{ $tag->name }}</a>&nbsp;({{ $tag->posts->count() }})
          </li>
          @endif
          @endforeach
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <p>Copyright © 2017 | <a href="/">JJJ</a></p>
      </div>
    </div>
  </div>

</body>
</html>