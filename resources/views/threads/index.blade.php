@extends('layouts.app') @section('content')

<div class="uk-section">
	<div class="uk-container">
		@include('threads._list')
		{{$threads->render()}}
	</div>
</div>

@endsection
