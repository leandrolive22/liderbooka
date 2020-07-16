
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<!-- Dependências CSS -->
	@include('assets.title.title')
	<!-- Dependências CSS -->
	@include('assets.meta.meta')
	<!-- Dependências CSS -->
	@include('assets.css.cssMetronic')
	@include('assets.css.cssLogin')
	<link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />

</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">

	@yield('content')
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157308339-1"></script>
    <script async src="{{asset('js/plugins/googleAnalitics.js')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-157308339-1');
    </script>
</body>
</html>
