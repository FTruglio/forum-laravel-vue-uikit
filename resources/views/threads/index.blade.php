@extends('layouts.app') @section('content')

<div class="uk-section">
	<div class="uk-container">
		@forelse($threads as $thread)
		<div class="uk-card uk-card-default uk-card-body uk-margin-small-top">
			<div class="uk-child-width-expand" uk-grid>
				<div class="uk-child-width-expand" uk-grid>
					<div class="uk-width-5-6">
						<h4 class="uk-heading-bullet uk-text-bold">
							@if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
							<a class="uk-text-bold" style="color: #00bfa5" href="{{$thread->path()}}">
								{{$thread->title}}
							</a>
							@else
								<a style="color: #4a4a4a" href="{{$thread->path()}}">
								{{$thread->title}}
							</a>
							@endif
						</h4>
					</div>
					<div>
						<span class="uk-text-bold uk-align-right uk-margin-small-right">
							<a href="{{$thread->path()}}">
								{{$thread->replies_count}} {{ str_plural('reply', $thread->replies_count)}}
							</a>
						</span>
					</div>
				</div>
			</div>
			<p>{{$thread->body}}</p>
			<h5 class="uk-margin-remove"><a class="uk-text-muted" href="{{ route('profile', $thread->creator )}}">{{$thread->creator->name}}</a> |  {{$thread->created_at->diffForHumans()}}</h5>
		</div>
		@empty
		<p> There are no relevant results at this time.</p>
		@endforelse
	</div>
</div>

@endsection
