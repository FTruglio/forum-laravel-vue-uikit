@extends('layouts.app')

@section('content')
<div class="uk-section">
    <div class="uk-container">
        <div class="uk-heading-divider">
            <img src="{{ asset($profileUser->avatar()) }}" alt="{{$profileUser->name}}" style="width: 100px; height: 100%; max-height: 100px;">
         <h1 class="uk-margin-medium-right">{{$profileUser->name}}</h1>
         @can ('update', $profileUser)
         <form method="POST" action="{{route('avatar', $profileUser)}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <input name="avatar" type="file">
            <button>upload</button>
        </form>
        @endcan
    </div>
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
