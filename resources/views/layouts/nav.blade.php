<nav class="uk-navbar-container uk-margin" uk-navbar="mode: click">
    <div class="uk-navbar-left">

        <ul class="uk-navbar-nav">
            <li>
                <a class="uk-text-bold">Forum</a>
            </li>
            <li>
                <a href="#">Browse</a>
                <div class="uk-navbar-dropdown">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                        <li><a href="/threads">All Threads</a></li>
                        @if(auth()->check())
                        <li><a href="/threads?by={{ auth()->user()->name}}">My Threads</a></li>
                        @endif
                        <li><a href="/threads?popular=1">Popular Threads</a></li>
                        <li><a href="/threads?unanswered=1">Unanswered Threads</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#">Channels</a>
                <div class="uk-navbar-dropdown">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                      @foreach($channels as $channel)
                      <li><a href="/threads/{{$channel->slug}}">{{$channel->name}}</a></li>
                      @endforeach
                  </ul>
              </div>
          </li>
      </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
        <li>
            <a href=""><user-notification></user-notification></a>
        </li>
        <li>
            <a href="/threads/create">New Thread</a>
        </li>
        <!-- Authentication Links -->
        @guest
        <li>
            <a href="{{ route('login') }}">Login</a>
        </li>
        <li>
            <a href="{{ route('register') }}">Register</a>
        </li>
        @else

        <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                {{ Auth::user()->name }}
                <span class="caret"></span>
            </a>
            <div class="uk-navbar-dropdown">
                <ul class="uk-nav uk-navbar-dropdown-nav">
                    <li>
                        <a href="{{auth()->user()->path()}}">Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </li>
    @endguest
</ul>
</div>
</nav>

