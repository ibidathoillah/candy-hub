
    <link rel="shortcut icon" type="image/png" href="{{ url('candy-hub/images/favicon.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">

    <!-- GetCandy -->
    <link href="{{ url('candy-hub/css/hub.css') }}" rel="stylesheet">

    @if(File::exists(public_path('css/candy-hub.css')))
        <link href="{{ url('css/candy-hub.css') }}" rel="stylesheet">
    @endif

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>

    @font-face {
    font-family: 'Modern Era Medium';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern\ Era\ Medium.ttf') format('truetype');
    }

    @font-face {
    font-family: 'Modern Era Regular';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern\ Era\ Regular.ttf') format('truetype');
    }


    @font-face {
    font-family: 'Modern Era Bold';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern\ Era\ Bold.ttf') format('truetype');
    }

    /*----*/

    @font-face {
    font-family: 'Modern Era Black';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Black.ttf') format('truetype');
    }

    @font-face {
    font-family: 'Modern Era Black Italic';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Black Italic.ttf') format('truetype');
    }

    @font-face {
    font-family: 'Modern Era Bold Italic';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Bold Italic.ttf') format('truetype');
    }

    @font-face {
    font-family: 'Modern Era Bold';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Bold.ttf') format('truetype');
    }

    @font-face {
    font-family: 'Modern Era ExtraBold Italic';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era ExtraBold Italic.ttf') format('truetype');
    }

    @font-face {
    font-family: 'Modern Era ExtraBold';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era ExtraBold.ttf') format('truetype');
    }


    @font-face {
    font-family: 'Modern Era Italic';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Italic.ttf') format('truetype');
    }
    @font-face {
    font-family: 'Modern Era Light Italic';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Light Italic.ttf') format('truetype');
    }
    @font-face {
    font-family: 'Modern Era Light';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Light.ttf') format('truetype');
    }
    @font-face {
    font-family: 'Modern Era Medium Italic';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Medium Italic.ttf') format('truetype');
    }
    @font-face {
    font-family: 'Modern Era Medium';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Medium.ttf') format('truetype');
    }
    @font-face {
    font-family: 'Modern Era Mono Bold';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Mono Bold.ttf') format('truetype');
    }
    @font-face {
    font-family: 'Modern Era Mono ExtraBold';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Mono ExtraBold.ttf') format('truetype');
    }


    @font-face {
    font-family: 'Modern Era Mono Medium';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Mono Medium.ttf') format('truetype');
    }

    @font-face {
    font-family: 'Modern Era Mono Regular';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Mono Regular.ttf') format('truetype');
    }

    @font-face {
    font-family: 'Modern Era Regular';
    src: url('/fonts/vendor/bootstrap-sass/bootstrap/Modern Era Regular.ttf') format('truetype');
    }
    
    </style>

    <script>
    window.Laravel = {
        "csrfToken": "{{ csrf_token() }}"
    };
    window.hubPrefix = "{{ config('getcandy.hub_prefix', 'hub') }}";
    </script>

    {!! $head_html !!}