
{{-- Editing the question --}}
<div class="uk-card uk-card-default" v-if="editing" v-cloak>
    <div class="uk-card-body">
        <div class="uk-child-width-expand" uk-grid>
            <div>
                <input type="text" class="uk-input" v-model="form.title">
                <div uk-grid>
                    <div>
                        <img src="{{ $thread->creator->avatar_path }}" alt={{$thread->creator->name}} style="width: 25px; height: 100%; max-height: 25px;">
                    </div>
                    <div>
                        <h5><a class="uk-text-muted" href="{{$thread->path()}}">{{$thread->creator->name}}</a> |  {{$thread->created_at->diffForHumans()}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <textarea class="uk-textarea" id="" cols="30" rows="10" v-model="form.body"></textarea>
    </div>
    <div class="uk-card-footer uk-child-width-expand" uk-grid>
        <div>
            <button class="uk-button uk-border-rounded uk-button-default uk-button-small" @click="editing = true" v-show="! editing">Edit</button>
            <button class="uk-button uk-border-rounded uk-button-primary uk-button-small" @click="update">Update</button>
            <button class="uk-button uk-border-rounded uk-button-default uk-button-small" @click="resetForm">Cancel</button>
        </div>
        <div>
            @can('update', $thread)
            <form class="uk-align-right" method="POST" action="{{$thread->path()}}">
                {{csrf_field()}}
                {{ method_field('DELETE')}}
                <button class="uk-button uk-border-rounded uk-button-danger uk-button-small">X Destroy</button>
            </form>
            @endcan
        </div>
    </div>
</div>

{{-- Viewing the question --}}
<div class="uk-card uk-card-default" v-else>
    <div class="uk-card-body">
        <div class="uk-child-width-expand" uk-grid>
            <div>
                <h1 class="uk-text-bold">
                    <span v-text="title"></span>
                </h1>
                <div uk-grid>
                    <div>
                        <img src="{{ $thread->creator->avatar_path }}" alt={{$thread->creator->name}} style="width: 25px; height: 100%; max-height: 25px;">
                    </div>
                    <div>
                        <h5><a class="uk-text-muted" href="{{$thread->path()}}">{{$thread->creator->name}}</a> |  {{$thread->created_at->diffForHumans()}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <p v-text="body"></p>
    </div>
    <div class="uk-card-footer" v-if="authorize('owns', dataThread)">
        <button class="uk-button uk-border-rounded uk-button-default uk-button-small" @click="editing = true">Edit</button>
    </div>
</div>
