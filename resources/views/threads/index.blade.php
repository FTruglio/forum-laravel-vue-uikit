@extends('layouts.app')

@section('content')

<div class="uk-section">
	<div class="uk-container uk-container-large">
    <div uk-grid>
      <div class="uk-width-2-3">
        <form class="uk-heading-divider" method="GET" action="/threads/search/">
          {{-- <span uk-search-icon></span> --}}
          <div class="uk-grid-collapse" uk-grid>
            <div class="uk-width-expand">
              <input class="uk-search-input" type="search" placeholder="Search..." name="q">
           </div>
           <div class="uk-width-auto">
            <button class="uk-align-right uk-button uk-button-small uk-button-primary">Search</button>
          </div>
        </div>
      </form>
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
