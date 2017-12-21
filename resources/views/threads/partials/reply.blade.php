<div class="uk-card uk-card-default uk-card-body uk-margin-small-top">
    <div class="uk-child-width-expand" uk-grid>
        <div>
            <h5>
                <a href="{{$reply->owner->path()}}">{{$reply->owner->name}}
                </a> said {{$reply->created_at->diffForHumans()}}
            </h5>
        </div>
        <div>
            <div class="uk-align-right">
                <form  method="POST" action="/replies/{{$reply->id}}/favorites">
                {{csrf_field()}}
                <button class="uk-button uk-button-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>{{$reply->favorites_count}} {{ str_plural('Favorite', $reply->favorites_count)}}</button>
                </form>
                </div>
        </div>
    </div>
    <p>{{$reply->body}}</p>
</div>
