@extends('layouts.portal')

@section('title', 'Commission and bonus')

@section('content')
    @include('partials.page-title', ['title' => 'Commission and Bonus'])
    <section class="main-container col2-right-layout">
        <div class="main container">
            <div class="my-account">
                <!--page-title-->
                <!-- BEGIN DASHBOARD-->
                <div class="dashboard">
                    <div class="recent-orders">
                        <div class="table-responsive">
                            <table class="data-table table-striped" id="my-orders-table">
                                <thead>
                                <tr class="first last">
                                    <th>Name</th>
                                    <th>% of the total commission</th>
                                    <th>Payable</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>General Commission</td>
                                        <td>{{ $option->getOption('general_commission') }}%</td>
                                        <td>Instantly</td>
                                    </tr>
                                @foreach($commissions as $commission)
                                    <tr>
                                        <td>{{ $commission->name }}</td>
                                        <td>{{ $commission->percentage }}%</td>
                                        <td>{{ $commission->payable }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--main container-->
    </section>
@endsection