@extends('layouts.app')

@section('content')
<div class="card rounded-0 mb-0 p-2">
            <div class="card-header pt-50 pb-1">
                <div class="card-title">
                    <h4 class="mb-0"> {{ __('Register') }}</h4>
                </div>
            </div>
            <p class="px-2">Fill the below form to sign in to your account.</p>
            <div class="card-content">
                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-label-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <label for="inputName">Email Address </label>
                         @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        </div>
                        <div class="form-label-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        </div>

                        <div class="form-group row">
                                                        <div class="col-12">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span class="">  {{ __('Remember Me') }}</span>
                                                                </div>
                                                            </fieldset>
                                                            @if (Route::has('password.request'))
                                    <a class="btn btn-outline-primary float-left btn-inline mb-50" href="{{ route('password.request') }}">
                                       Forgot password?
                                    </a>
                                @endif
                                <button type="submit" class="btn btn-primary float-right btn-inline mb-50">Login</a>
                                                      
                                                
                                                </div>
                                                    </div>
                                                   
                     
                       
                    </form>
                </div>
            </div>
        </div>
   
@endsection
