@extends('layouts.app') @section('content')

<div class="uk-section">
	<div class="uk-container">
		<div class="uk-card uk-card-default uk-card-body">
			<div class="uk-child-width-expand" uk-grid>
				<div>
					<h3 class="uk-card-title">Threads</h3>
				</div>
				<div>
					<a class="uk-button uk-button-primary uk-button-small uk-align-right" href="/threads/create">New Thread</a>
				</div>
			</div>
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
