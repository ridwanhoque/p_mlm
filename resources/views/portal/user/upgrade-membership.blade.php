@extends('layouts.portal')

@section('title', 'Upgrade Membership')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
@endpush

@section('content')
    @include('partials.page-title', ['title' => 'Upgrade Membership'])

    <section class="main-container col2-right-layout">
        <div class="main container">
            <div class="my-account">
                <!--page-title-->
                <!-- BEGIN DASHBOARD-->
                <div class="dashboard">
                    <upgrade-membership></upgrade-membership>
                </div>
            </div>
        </div>
        <!--main container-->
    </section>
@stop

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