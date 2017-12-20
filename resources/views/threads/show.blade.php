@extends('layouts.app') 

@section('content')

<div class="uk-section">
	<div class="uk-container">
		<div class="uk-card uk-card-default uk-card-body">
			<h1>
			{{$thread->title}}</h1>
			<h4><a class="uk-text-muted" href="#">{{$thread->creator->name}}</a> |  {{$thread->created_at}}</h4>
			<p>{{$thread->body}}</p>
		</div>
	</div>
</div>


<div class="uk-section">
	<div class="uk-container">
		@foreach($thread->replies as $reply) 
			@include('threads.partials.reply') 
		@endforeach
		@if(auth()->check())
		<form  method="POST" action="{{$thread->path() . '/replies'}}">
		{{csrf_field()}}
			<div class="uk-card uk-card-default uk-margin-small-top">
			<div class="uk-card-header">
				<h3 class="uk-card-title">Contribute</h3>
			</div>
			<div class="uk-card-body">
				<textarea class="uk-textarea" rows="5" name="body" placeholder="Write something intelligent..."></textarea>
			</div>
				<div class="uk-card-footer"><button class="uk-button uk-button-primary uk-align-right">Submit</button></div>
			</div>
		</form>
		@else
		<p>Please <a href="{{route ('login')}}"> sign in </a> to participate in this discussion.</p>
		@endif
	</div>
</div>
@endsection
