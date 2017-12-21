@extends('layouts.app')

@section('content')
<div class="uk-section">
    <div class="uk-container">
        <div class="uk-heading-divider uk-flex">
          <h1 class="uk-margin-medium-right">{{$profileUser->name}}</h1>
          <p>{{$profileUser->created_at->diffForHumans()}}</p>
      </div>
      @foreach($profileUser->threads as $thread)
      <div class="uk-card uk-card-default uk-card-body uk-margin-small-top">
        <div class="uk-child-width-expand" uk-grid>
            <div>
              <h1 class="uk-text-bold">
                <a href="{{$thread->path()}}">{{$thread->title}}</a></h1>
            </div>
            <div>
                <h5><a class="uk-text-muted" href="{{ route('profile', $thread->creator )}}">{{$thread->creator->name}}</a> |  {{$thread->created_at->diffForHumans()}}</h5>
            </div>
        </div>
        <p>{{$thread->body}}</p>
    </div>
    @endforeach
    {{$threads->links()}}
</div>
</div>
@endsection
