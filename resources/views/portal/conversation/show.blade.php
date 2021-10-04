@extends('layouts.portal')

@section('title', 'Conversation')

@section('content')
    @include('partials.page-title', ['title' => 'Conversation of ' . $userNames])
    <section class="main-container col2-right-layout">
        <div class="main container">
            <div class="my-account">
                <!--page-title-->
                <!-- BEGIN DASHBOARD-->
                <div class="dashboard">

                </div>
            </div>
        </div>
        <!--main container-->
    </section>
@stop