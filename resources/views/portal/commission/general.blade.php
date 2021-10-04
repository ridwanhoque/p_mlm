@extends('layouts.portal')

@section('title', 'General commission')

@section('content')
    @include('partials.page-title', ['title' => 'General commission'])
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
                                        <th>Label</th>
                                        <th>% of the General Commission</th>
                                        <th>Payable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($commissions as $commission)
                                    <tr>
                                        <td>Label - {{ $commission->hand_level }}</td>
                                        <td>{{ $commission->commission }}%</td>
                                        <td>Instantly</td>
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