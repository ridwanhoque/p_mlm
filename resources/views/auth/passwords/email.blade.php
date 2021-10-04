@extends('layouts.website')

@section('title', 'Reset password')

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
                <form method="post" id="login-form" action="{{ route('password.email') }}">
                    @csrf
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
                                </ul>

                                <div class="buttons-set">
                                    <button type="submit" class="button login" title="Login" name="send" id="send2"><span>Send Verification Link</span></button>
                                    <a href="/login" class="forgot-word">Back to login</a>
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
