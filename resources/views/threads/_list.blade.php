@forelse($threads as $thread)
<div class="uk-card uk-card-default uk-margin-small-top">
    <div class="uk-card-header">
        <div class="uk-child-width-expand" uk-grid>
            <div class="uk-child-width-expand" uk-grid>
                <div class="uk-width-5-6">
                    <h4 class="uk-text-bold uk-margin-remove-bottom">
                        @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                        <a style="color: #00bfa5; letter-spacing: 1px;" href="{{$thread->path()}}">
                            {{$thread->title}}
                        </a>
                        @else
                        <a style="color: #4a4a4a; letter-spacing: 1px;" href="{{$thread->path()}}">
                            {{$thread->title}}
                        </a>
                        @endif
                    </h4>
                    <h5 class="uk-margin-small-top uk-text-muted">Author:
                        <img src="{{ $thread->creator->avatar_path }}" alt={{$thread->creator->name}} style="width: 25px; height: 100%; max-height: 25px;">
                        <a href="{{ route('profile', $thread->creator) }}">{{$thread->creator->name}} | {{$thread->created_at->diffForHumans()}}</a>
                    </h5>
                </div>
                <div>
                    <span class="uk-text-bold uk-align-right uk-margin-small-right">
                        <a href="{{$thread->path()}}">
                            {{$thread->replies_count}} {{ str_plural('reply', $thread->replies_count)}}
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-card-body">
        <p>{{$thread->body}}</p>
    </div>
    <div class="uk-card-footer">
        {{$thread->visits()->count()}} Visits
    </div>
</div>
@empty
<p> There are no relevant results at this time.</p>
@endforelse
