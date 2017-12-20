@extends('layouts.app') 

@section('content')

<div class="uk-section">
	<div class="uk-container">
		<form  method="POST" action="/threads">
		{{csrf_field()}}
			<div class="uk-card uk-card-default uk-margin-small-top">
			<div class="uk-card-header">
				<h3 class="uk-card-title">New Thread</h3>
			</div>
			<div class="uk-card-body">
                <fieldset class="uk-fieldset">
                <div class="uk-margin">
                <input class="uk-input" type="text" name="title" placeholder="Catchy thread title">
                </div>
                <div class="uk-margin">
				<textarea class="uk-textarea" rows="8" name="body" placeholder="Create something intelligent..."></textarea>
                </div>
                </fieldset>
            </div>
				<div class="uk-card-footer"><button class="uk-button uk-button-primary uk-align-right">Submit</button></div>
			</div>
		</form>
	</div>
</div>
@endsection
