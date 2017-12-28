@extends('layouts.app')

@section('header')
<!-- Styles -->
<link rel="stylesheet" href="/css/jquery.atwho.css">
@endsection

@section('content')

<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
	<div class="uk-grid-collapse" uk-grid>
		<div class="uk-section uk-width-2-3@m">
			<div class="uk-container uk-padding-small">
				<div class="uk-card uk-card-default uk-card-body">
					<div class="uk-child-width-expand" uk-grid>
						<div>
							<h1 class="uk-text-bold">
								{{$thread->title}}
							</h1>
							<img src="{{ $thread->creator->avatar_path }}" alt={{$thread->creator->name}} style="width: 100px; height: 100%; max-height: 100px;">
							<h5><a class="uk-text-muted" href="{{$thread->path()}}">{{$thread->creator->name}}</a> |  {{$thread->created_at->diffForHumans()}}</h5>
						</div>
						<div>
							@can('update', $thread)
							<form class="uk-align-right" method="POST" action="{{$thread->path()}}">
								{{csrf_field()}}
								{{ method_field('DELETE')}}
								<button class="uk-button uk-button-danger uk-button-small">X Destroy</button>
							</form>
							@endcan
						</div>
					</div>
					<p>{{$thread->body}}</p>
				</div>
			</div>

			<div class="uk-container uk-padding-small">

				<replies @removed="repliesCount--" @added="repliesCount++"></replies>
			</div>
		</div>
		<div class="uk-section uk-width-1-2@s uk-width-1-3@m">
			<div class="uk-container uk-padding-small">
				<div class="uk-card uk-card-default uk-card-body">
					<p>	This thread was published {{$thread->created_at->diffForHumans()}} by <a href="{{$thread->creator->path()}}">{{$thread->creator->name}}</a> and currently has
						<span v-text="repliesCount"></span>
						{{str_plural('comment', $thread->replies_count)}}.</p>
					</div>
					<div class="uk-card uk-card-default uk-card-body">
						<subscribe-button :is-active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
					</div>
				</div>
			</div>
		</div>
	</thread-view>
	@endsection
