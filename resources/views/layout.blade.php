<!DOCTYPE html>
<html lang="{{ $app->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="channel" content="@channel()">
    <meta name="locale" content="{{ $app->getLocale() ?? 'en' }}">

    <title>@if(isset($title)){{ $title }} -@endif Treasury</title>
    @include('hub::partials.head')
    @routes
  </head>
  <body>
    <div class="wrap" id="app">
      <div class="sidebar">

        @include('hub::partials.top-menu')

        <div class="side-purple-overlay"></div>

                <div class="user-info">
          <small>Selamat Datang,</small>
          <strong>
            @if(Auth::user()->firstname)
              {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
            @else
              {{ Auth::user()->email }}
            @endif
          </strong>
        </div>

        <hr>

        @yield('side_menu')

        <hr>

        <nav class="side-nav">
          <ul>
              <li @if(request()->segment(2) == 'dashboard') class="active" @endif><a href="{{ route('hub.index') }}" >Halaman Dasbor</a></li>
              <li><a href="{{ route('logout') }}">Keluar</a></li>
          </ul>
        </nav>

      </div>

      <div class="content-panel">

        <!-- Section Header -->
        <div class="section header">
          @yield('header_title')
          <div class="actions">
            @yield('header_actions')
          </div>
        </div>
        <!-- END Section Header -->

        <!-- Products -->
        <div class="section">
          @yield('content')
        </div>

      </div>
      <candy-notification></candy-notification>
    </div>
    <div class="main-purple-overlay"></div>
    <script src="{{ url('/candy-hub/js/setup.js') }}"></script>
    @foreach($plugin_scripts as $script)
      <script src="{{ url('hub/plugins/' . $script) }}"></script>
    @endforeach
    @include('hub::partials.scripts')
    @yield('scripts')
  </body>
</html>