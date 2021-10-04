@extends('layouts.website')

@section('title', 'Register')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
@endpush

@section('content')
    <div class="page-heading">
        <div class="container">
            <div class="page-title">
                <h2>Register as a new user</h2>
            </div>
        </div>
    </div>
    <!-- BEGIN Main Container -->

    <div class="main-container col1-layout">
        <div class="main">
            <div class="account-login container">
                <register></register>
            </div>
            <!--account-login-->
        </div>
        <!--main-container-->
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).on('focus', '.date', function () {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
@endpush
