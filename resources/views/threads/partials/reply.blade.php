<div id="reply-{{$reply->id}}" class="uk-card uk-card-default uk-margin-small-top">
    <div class="uk-card-header">
        <div class="uk-child-width-expand" uk-grid>
            <div>
                <h5>
                    <a href="{{$reply->owner->path()}}">{{$reply->owner->name}}
                    </a> said {{$reply->created_at->diffForHumans()}}
                </h5>
            </div>
        </div>
        <div>
            <div class="uk-align-right">
                <form  method="POST" action="/replies/{{$reply->id}}/favorites">
                    {{csrf_field()}}
                    <button class="uk-button uk-button-primary uk-button-small" {{ $reply->isFavorited() ? 'disabled' : '' }}>{{$reply->favorites_count}} {{ str_plural('Favorite', $reply->favorites_count)}}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="uk-card-body">
        <p>{{$reply->body}}</p>
    </div>
    <div class="uk-card-footer">
       @can('update', $thread)
       <form class="uk-align-left" method="POST" action="{{'/replies/' . $reply->id}}">
        {{csrf_field()}}
        {{ method_field('DELETE')}}
        <button class="uk-button uk-button-danger uk-button-small">X Destroy</button>
    </form>
    @endcan
</div>
</div>
