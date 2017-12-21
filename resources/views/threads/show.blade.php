@extends('layouts.app')

@section('content')

<div class="uk-grid-collapse" uk-grid>
	<div class="uk-section uk-width-2-3@m">
		<div class="uk-container uk-padding-small">
			<div class="uk-card uk-card-default uk-card-body">
				<div class="uk-child-width-expand" uk-grid>
					<div>
						<h1 class="uk-text-bold">
							{{$thread->title}}
						</h1>
						<h5><a class="uk-text-muted" href="#">{{$thread->creator->name}}</a> |  {{$thread->created_at->diffForHumans()}}</h5>
					</div>
					<div>
						@can('update', $thread)
							<form class="uk-align-right" method="POST" action="{{$thread->path()}}">
								{{csrf_field()}}
								{{ method_field('DELETE')}}
								<button class="uk-button uk-button-danger">Destroy</button>
							</form>
						@endcan
					</div>
				</div>
				<p>{{$thread->body}}</p>
			</div>
		</div>

		<div class="uk-container uk-padding-small">
			@foreach($replies as $reply)
			@include('threads.partials.reply')
			@endforeach

			{{$replies->links()}}


			@if(auth()->check())
			<form  method="POST" action="{{$thread->path() . '/replies'}}">
				{{csrf_field()}}
				<div class="uk-card uk-card-default uk-margin-small-top">
					<div class="uk-card-header">
						<h4 class="uk-card-title">Contribute</h4>
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
	<div class="uk-section uk-width-1-2@s uk-width-1-3@m">
		<div class="uk-container uk-padding-small">
			<div class="uk-card uk-card-default uk-card-body">
				<p>	This thread was published {{$thread->created_at->diffForHumans()}} by <a href="{{$thread->creator->path()}}">{{$thread->creator->name}}</a> and currently has {{$thread->replies_count}} {{str_plural('comment', $thread->replies_count)}}.</p>
			</div>
		</div>
	</div>
</div>
@endsection
