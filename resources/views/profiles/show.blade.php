@extends('layouts.app')

@section('content')
<div class="uk-section">
    <div class="uk-container">
        <div class="uk-heading-divider uk-flex">
            <h1 class="uk-margin-medium-right">{{$profileUser->name}}</h1>
        </div>
        @foreach($activities as $date => $activity)
        <h3>{{$date}}</h3>
        @foreach($activity as $record)
        @if(view()->exists('profiles.activities.' . $record->type))
        @include('profiles.activities.' . $record->type, ['activity' => $record])
        @endif
        @endforeach
        @endforeach
    </div>
</div>
@endsection
