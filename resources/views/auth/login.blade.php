@extends('layouts.website')

@section('title', 'Login your account!')

@section('content')
    <div class="page-heading">
        <div class="container">
            <div class="page-title">
                <h2>Login or Create an Account</h2>
            </div>
        </div>
    </div>
    <!-- BEGIN Main Container -->

    <div class="main-container col1-layout">
        <div class="main">
            <div class="account-login container">
                <!--page-title-->
                <form method="post" id="login-form">
                    @csrf
                    <fieldset class="col2-set">
                        <div class="col-1 new-users">
                            <strong>New Customers</strong>
                            <div class="content">
                                <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
                                <div class="buttons-set">
                                    <a href="/register" title="Create an Account" class="button"><span><span>Create an Account</span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 registered-users">
                            <strong>Registered Customers</strong>
                            <div class="content">
                                <p>If you have an account with us, please log in.</p>
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
                                        <label for="pass">Password<em class="required">*</em></label>
                                        <div class="input-box">
                                            <input type="password" name="password" class="input-text required-entry validate-password" id="pass" title="Password">
                                            @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </li>
                                    <li>
                                        <label>
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me?
                                        </label>
                                    </li>
                                </ul>

                                <div class="buttons-set">
                                    <button type="submit" class="button login" title="Login" name="send" id="send2"><span>Login</span></button>
                                    <a href="{!! route('password.request') !!}" class="forgot-word">Forgot Your Password?</a>
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
