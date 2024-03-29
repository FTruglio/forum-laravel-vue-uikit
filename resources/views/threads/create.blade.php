@extends('layouts.app')

@section('header')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')

<div class="uk-section">
	<div class="uk-container uk-container-small">
		<form  method="POST" action="/threads">
			{{csrf_field()}}
			<div class="uk-card uk-card-default uk-margin-small-top">
				<div class="uk-card-header">
					<h3 class="uk-card-title">New Thread</h3>
				</div>
				<div class="uk-card-body">
					<fieldset class="uk-fieldset">
						<div class="uk-margin">
							<select name="channel_id" id="" class="uk-select" required>
								<option value="">Select a channel</option>
								@foreach($channels as $channel)
								<option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ' '}}>
									{{$channel->name}}
								</option>
								@endforeach
							</select>
						</div>
						<div class="uk-margin">
							<input class="uk-input" type="text" name="title" placeholder="Catchy thread title" value="{{old('title')}}" required>
						</div>
						<div class="uk-margin">
							<wysiwyg name="body"></wysiwyg>
						</div>
					</fieldset>
				</div>
				<div class="uk-card-footer">
					<div class="g-recaptcha" data-sitekey="6LcV5z4UAAAAAMDBAK4gskWbwToeyjmV55TKqyqB"></div>

					<button class="uk-button uk-button-primary uk-align-right">Submit</button>
				</div>
			</div>
		</form>

		@if(count($errors))
		<ul class="uk-list uk-margin-medium-top">
			@foreach($errors->all() as $error)
			<li>
				<div class="uk-alert-danger" uk-alert>
					<p>{{$error}}</p>
				</div>
			</li>
			@endforeach
		</ul>
		@endif
	</div>
</div>
@endsection
