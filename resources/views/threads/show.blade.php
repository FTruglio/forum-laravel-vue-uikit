@extends('layouts.app')

@section('header')
<!-- Styles -->
<link rel="stylesheet" href="/css/jquery.atwho.css">
@endsection

@section('content')

<thread-view :data-thread="{{ $thread }}" inline-template>
	<div class="uk-grid-collapse" uk-grid>
		<div class="uk-section uk-width-2-3@m">
			<div class="uk-container uk-padding-small">
				@include('threads._question')
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
						<subscribe-button v-if="signedIn" :is-active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>

						<button v-if="authorize('isAdmin')" class="uk-button uk-button-default uk-button-small" @click="toggleLock" v-text="locked ? 'Unlock' : 'Lock'"></button>
					</div>
				</div>
			</div>
		</div>
	</thread-view>
	@endsection
