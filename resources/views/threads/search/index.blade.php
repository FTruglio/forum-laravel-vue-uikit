@extends ('layouts.app')

@section ('content')
<div class="uk-container">
    <ais-index
    app-id="{{config('scout.algolia.id')}}"
    api-key="{{config('scout.algolia.key')}}"
    index-name="threads"
    query="{{request('q')}}"
    >

    <div uk-grid>
      <div class="uk-width-2-3">
        <ais-search-box >
            <ais-input class="uk-search-input uk-width-1-1" placeholder="Find Threads...." :autofocus="true"></ais-input>
        </ais-search-box>
        <ais-results>
            <template slot-scope="{ result }">
                <div class="uk-card uk-card-default uk-card-body uk-margin-small">
                    <a :href="result.path">
                        <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                    </a>
                    <p><ais-highlight :result="result" attribute-name="body"></ais-highlight></p>
                </div>
            </template>
        </ais-results>
    </div>
    <div class="uk-width-expand">
        @if(count($trending))
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <h4 class="uk-text-bold">Trending Threads</h4>
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
        <div class="uk-card uk-card-default uk-margin-small-top">
            <div class="uk-card-header">
                <h4 class="uk-text-bold">Channel Name</h4>
            </div>
            <div class="uk-card-body">
                <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
            </div>
        </div>
    </div>
</div>
</ais-index>
</div>
@endsection
