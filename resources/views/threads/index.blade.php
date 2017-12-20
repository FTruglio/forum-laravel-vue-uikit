@extends('layouts.app') @section('content')

<div class="uk-section">
	<div class="uk-container">
		<div class="uk-card uk-card-default uk-card-body">
			<h3 class="uk-card-title">Threads</h3>
			@foreach($threads as $thread)
			<h4>
				<a href="{{$thread->path()}}">{{$thread->title}}
				</a>
			</h4>
			<p>{{$thread->body}}</p>
			<hr> @endforeach
		</div>
	</div>
</div>

@endsection
