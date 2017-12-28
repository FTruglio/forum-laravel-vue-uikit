@extends('layouts.app')

@section('content')
<div class="uk-section">
    <div class="uk-container">
        <div class="uk-flex uk-flex-middle uk-flex-center">
            <div class="uk-card uk-card-default uk-width-medium">
                <div class="uk-card-header uk-text-center uk-text-bold">Login</div>
                <form class="uk-form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="uk-card-body">
                        <div class="uk-fieldset">
                            <div class="uk-margin{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div>
                                    <input id="email" type="email" class="uk-input" name="email" value="{{ old('email') }}" required autofocus placeholder="email">

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="uk-margin{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div>
                                    <input id="password" type="password" class="uk-input" name="password" required placeholder="password">

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-card-footer">
                        <div>
                            <div class="uk-align-left">
                                <label class="uk-link-muted uk-text-small">
                                    <input class="uk-checkbox" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="uk-button uk-button-primary uk-button-small uk-width-1-1">
                                Login
                            </button>
                            <br>
                            <div class="uk-margin">
                                <a class="uk-link uk-link-muted uk-text-small" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
