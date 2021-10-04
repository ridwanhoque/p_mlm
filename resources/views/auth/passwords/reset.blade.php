@extends('layouts.website')

@section('content')
    <div class="page-heading">
        <div class="container">
            <div class="page-title">
                <h2>Reset Password</h2>
            </div>
        </div>
    </div>
    <!-- BEGIN Main Container -->

    <div class="main-container col1-layout">
        <div class="main">
            <div class="account-login container">
                <!--page-title-->
                <form method="post" id="login-form" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <fieldset class="col2-set">
                        <div class="col-2 registered-users">
                            <strong>Reset your password</strong>
                            <div class="content">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <ul class="form-list">
                                    <li>
                                        <label for="email">Email Address<em class="required">*</em></label>
                                        <div class="input-box">
                                            <input type="text" name="email" value="{{ old('email') }}" id="email" class="input-text required-entry validate-email" title="Email Address">
                                            @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </li>
                                    <li>
                                        <label for="password">Password<em class="required">*</em></label>
                                        <div class="input-box">
                                            <input type="password" name="password" id="password" class="input-text required-entry" title="Password">
                                            @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </li>
                                    <li>
                                        <label for="password_confirmation">Confirm Password <em class="required">*</em></label>
                                        <div class="input-box">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="input-text required-entry" title="Confirm Password">
                                            @error('password_confirmation')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </li>
                                </ul>

                                <div class="buttons-set">
                                    <button type="submit" class="button login" title="Reset Password" name="send" id="send2"><span>Reset Password</span></button>
                                </div>
                                <!--buttons-set-->
                            </div>
                            <!--content-->
                        </div>
                        <!--col-2 registered-users-->
                    </fieldset>
                    <!--col2-set-->
                </form>
            </div>
            <!--account-login-->
        </div>
        <!--main-container-->
    </div>
@endsection
