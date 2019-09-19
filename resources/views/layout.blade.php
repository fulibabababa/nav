<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@if(isset($title) && !empty($title)){{$title.'_'}}@endif{{config('app.name')}}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="{{asset('link/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="{{asset('link/css/mdb.min.css')}}" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="{{asset('link/css/style.css')}}" rel="stylesheet">
    <style type="text/css">
        @media (min-width: 800px) and (max-width: 850px) {
            .navbar:not(.top-nav-collapse) {
                background: #1C2331 !important;
            }
        }

        .index-banner {
            margin-bottom: 3rem;
            text-align: center;
        }

        .index-banner h3 {
            color: #fff;
            font-weight: bolder;
        }

        .index-banner img {
            max-width: 70%;
        }
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140684953-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-140684953-2');
    </script>

</head>

<body>
<header>
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar">
        <div class="container">

            <!-- Brand -->
            <a class="navbar-brand" href="{{route('home')}}">
                <strong>{{config('app.name')}}</strong>
            </a>

            <!-- Collapse -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Left -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('home')}}">首页

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('employ')}}">收录</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#footer">广告合作联系邮箱</a>
                    </li>
                </ul>

                <!-- Right -->
                <ul class="navbar-nav nav-flex-icons">
                    <li class="nav-item">
                        <a href="javascript:addFavorite()" class="nav-link">
                            <i class="fa fa-plus mr-2"></i>收藏本页
                        </a>
                    </li>
                </ul>

            </div>

        </div>
    </nav>
    <!-- Navbar -->
</header>


<!--Main layout-->
<main class="rgba-gradient p-6">
    <div class="container">
        @yield('content')
    </div>
</main>
<!--Main layout-->

<!--Footer-->
<footer class="page-footer text-center font-small wow fadeIn" id="footer">
    <!--Copyright-->
    <div class="footer-copyright py-3">
        Copyright © 2012-{{now()->year}} {{config('app.name')}}. All Rights Reserved. 邮箱: {{config('protect.email')}}
        本站设在美国佛罗里达州，主机位于美国亚利桑那州，服务全球华人，受美国法律约束和保护。
    </div>
    <!--/.Copyright-->
</footer>
<!--/.Footer-->


<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="{{asset('link/js/jquery-3.4.1.min.js')}}"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="{{asset('link/js/popper.min.js')}}"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{asset('link/js/bootstrap.min.js')}}"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="{{asset('link/js/mdb.min.js')}}"></script>
<!-- Initializations -->
<script type="text/javascript">
    // Animations initialization
    new WOW().init();

    function addFavorite() {
        let url = window.location;
        let title = document.title;
        let ua = navigator.userAgent.toLowerCase();
        if (ua.indexOf("360se") > -1) {
            alert("由于360浏览器功能限制，请按 Ctrl+D 手动收藏！");
        }
        else if (ua.indexOf("msie 8") > -1) {
            window.external.AddToFavoritesBar(url, title); //IE8
        }
        else if (document.all) {
            try {
                window.external.addFavorite(url, title);
            } catch (e) {
                alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
            }
        }
        else if (window.sidebar) {
            window.sidebar.addPanel(title, url, "");
        }
        else {
            alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
        }
    }

    $(function(){
        $('.friend-link a').click(function () {
            // console.log($(this).attr('data-web-name'));
            gtag('event', 'outbound', {
                'event_category': 'outbound',
                'event_label': $(this).attr('data-web-name'),
            });
        });
    })

</script>

@includeWhen(config('protect.check_console') && is_null(request()->input('cc')), 'check_console')

</body>

</html>
