<reply :attributes="{{$reply}}" inline-template>
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
            <div v-if="editing">
                <div class="uk-margin">
                    <textarea class="uk-textarea" v-model="body"></textarea>
                </div>
                <button class="uk-button uk-button-primary uk-button-small" @click="update"> Update</button>
                <button class="uk-button uk-button-default uk-button-small" @click="editing = false"> Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>
        <div class="uk-card-footer">
         @can('update', $thread)
         <button class="uk-button uk-button-default uk-button-small" @click="editing = true"> Edit</button>
         <button class="uk-button uk-button-danger uk-button-small" @click="destroy">X Destroy</button>
         @endcan
     </div>
 </div>
</reply>
