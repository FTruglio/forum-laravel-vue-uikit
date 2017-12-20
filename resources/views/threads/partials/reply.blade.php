<div class="uk-card uk-card-default uk-card-body uk-margin-small-top">
    <h3 class="uk-card-title uk-heading-divider">
    <a href="#">{{$reply->owner->name}}
    </a> said {{$reply->created_at->diffForHumans()}}</h3>
    <p>{{$reply->body}}</p>
</div>