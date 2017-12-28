@extends('layouts.app')

@section('content')
<div class="uk-section">
    <div class="uk-container">
        <avatar-form :user="{{$profileUser}}"></avatar-form>
        @forelse($activities as $date => $activity)
        <h3>{{$date}}</h3>
        @foreach($activity as $record)
        @if(view()->exists('profiles.activities.' . $record->type))
        @include('profiles.activities.' . $record->type, ['activity' => $record])
        @endif
        @endforeach
        @empty
        <p>There is no activity for this user yet.</p>
        @endforelse
    </div>
</div>
@endsection
