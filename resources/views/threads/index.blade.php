@extends('layouts.app') @section('content')

<div class="uk-section">
	<div class="uk-container">
		@foreach($threads as $thread)
		<div class="uk-card uk-card-default uk-card-body uk-margin-small-top">
			<div class="uk-child-width-expand" uk-grid>
				<div class="uk-child-width-expand" uk-grid>
					<div>
						<h4>
							<a href="{{$thread->path()}}">{{$thread->title}}
							</a>
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
		</div>
		@endforeach
	</div>
</div>

@endsection
