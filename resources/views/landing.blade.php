@extends('layouts.app')

@section('content')

<div class="uk-section">
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-2-3">
              @include('threads._list')
              {{$threads->render()}}
          </div>
          <div class="uk-width-expand">
            @if(count($trending))
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                   <h3 class="uk-text-bold">Trending Threads</h3>
               </div>
               <div class="uk-card-body">
                <ul class="uk-list uk-list-divider">
                    @foreach($trending as $thread)
                    <li><a href="{{$thread->path}}">{{$thread->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>
</div>
</div>
@endsection
