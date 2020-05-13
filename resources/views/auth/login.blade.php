@extends('layouts.app')

@php
    $enabled_socials = collect(config('services'))->only(['facebook', 'twitter', 'google', 'github'])
->where('enabled', true);
@endphp
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="@if($enabled_socials->count() > 0)col-md-8 @else col-md-10 @endif">
            <div class="card">
                <div class="card-header">{{ __('Login with email') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="@if($enabled_socials->count() > 0)col-md-3 @else d-none @endif">
            <div class="card">
                <div class="card-header">{{ __('Login with Social') }}</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach($enabled_socials as $social => $config)


                            <li class="mb-2">
                                <a href="{{ route('login.social', $social) }}" class="btn btn-block btn-social btn-{{$social}}">
                                    <span class="fab fa-{{$social}}"></span>
                                    {{ \Str::title($social) }}</a>
                            </li>

                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
