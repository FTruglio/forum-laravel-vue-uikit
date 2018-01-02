@extends ('layouts.app')

@section ('content')
<div class="uk-container">
    <ais-index
    app-id="{{config('scout.algolia.id')}}"
    api-key="{{config('scout.algolia.key')}}"
    index-name="threads"
    >
    <ais-search-box></ais-search-box>
    <div>
        <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
    </div>

    <ais-results>
        <template slot-scope="{ result }">
            <p>
                <a :href="result.path">
                    <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                </a>
            </p>
        </template>
    </ais-results>
</ais-index>
</div>
@endsection
