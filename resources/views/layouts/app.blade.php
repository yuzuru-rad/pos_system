<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <title>@yield('title')</title>
    <style>
    /* 追加のスタイルシート */
    nav {
        background-color: #1e90ff;  /* ナビゲーションバーの背景色 */
    }
    .nav-item-1 {
        background-color: #228b22;  /* 背景色1 */
        padding: 0px 10px;  /* パディング */
    }
    .nav-item-2 {
        background-color: #d2691e;  /* 背景色2 */
        padding: 0px 10px;  /* パディング */
    }
    .nav-item-3 {
        background-color: #c71585;  /* 背景色3 */
        padding: 0px 10px;  /* パディング */
    }
    </style>
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <div class="container">
                <a href="#" class="brand-logo">訪問販売</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li class="nav-item-1 center-align"><a href="{{ route('basic') }}">レ ジ 画 面</a></li>
                    <li class="nav-item-2 center-align"><a href="{{ route('show-earnings') }}">売 上 照 会</a></li>
                    <li class="nav-item-3 center-align"><a href="{{ route('register') }}">商 品 登 録</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <ul class="sidenav" id="mobile-demo">
        <li><a href="{{ route('basic') }}">レジ画面</a></li>
        <li><a href="{{ route('show-earnings') }}">売上照会</a></li>
        <li><a href="{{ route('register') }}">商品登録</a></li>
    </ul>

    <div class="container">
        @yield('content')
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/materialize.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
