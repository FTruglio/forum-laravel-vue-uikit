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
		window.App = {!! json_encode([
			'csrfToken' => csrf_token(),
			'signedIn' => Auth::check(),
			'user' => Auth::user(),
			]) !!}
		</script>

		<link rel="stylesheet" href="{{asset('/css/trix.css')}}" />

		<!-- UIkit CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/css/uikit.min.css" />

		<!-- UIkit JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/js/uikit.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/js/uikit-icons.min.js"></script>

		<style>
			[v-cloak] {display:none;}
		</style>

		@yield('header')
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
