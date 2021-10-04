@extends('layouts.website')

@section('content')
    <div class="page-heading">
        <div class="container">
            <div class="page-title">
                <h2>Verification Email</h2>
            </div>
        </div>
    </div>
    <div class="main-container col1-layout">
        <div class="main">
            <div class="account-login container">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif
                <p>Before proceeding, please check your email for a verification link. If you did not receive the email, <a href="{{ route('verification.resend') }}" class="text-warning">{{ __('click here to request another') }}</a>.</p>
            </div>
            <!--account-login-->
        </div>
        <!--main-container-->
    </div>
@endsection
