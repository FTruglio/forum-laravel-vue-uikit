@extends('layouts.app')

@section('content')
<div class="uk-section">
    <div class="uk-container">
        <div class="uk-flex uk-flex-middle uk-flex-center">
            <div class="uk-card uk-card-default uk-width-large">
                <div class="uk-card-header uk-text-center uk-text-bold">Register</div>
                <form class="uk-form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="uk-card-body">
                        <div class="uk-fieldset">

                            <div class="uk-margin{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div>
                                    <input id="name" type="text" class="uk-input" name="name" value="{{ old('name') }}" required autofocus placeholder="Full name">

                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="uk-margin{{ $errors->has('email') ? ' has-error' : '' }}">

                                <div>
                                    <input id="email" type="email" class="uk-input" name="email" value="{{ old('email') }}" required placeholder="email">

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

                            <div class="form-group">

                                <div>
                                    <input id="password-confirm" type="password" class="uk-input" name="password_confirmation" required placeholder="confirm password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-card-footer">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="uk-button uk-button-primary uk-button-small uk-width-1-1">
                                Register
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
