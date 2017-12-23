<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<script>
		window.laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
			]) !!}
		</script>

		<!-- Styles -->
		<!-- UIkit CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/css/uikit.min.css" />

		<!-- UIkit JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/js/uikit.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/js/uikit-icons.min.js"></script>
	</head>

	<body>
		<div id="app">
		@include('layouts.nav')

		@yield('content')

		<flash message="{{ session('flash') }}"></flash>
	</div>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
