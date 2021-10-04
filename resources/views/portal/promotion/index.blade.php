@extends('layouts.portal')

@section('title', 'Promotion')

@section('content')
    @include('partials.page-title', ['title' => 'Promotional Designation'])

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
                                    <th>Stage</th>
                                    <th>Promotion To</th>
                                    <th>Required Number</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($designations as $designation)
                                    <tr>
                                        <td>{{ $designation->stage }}</td>
                                        <td>{{ $designation->name }}</td>
                                        @if ($designation->requiredDesignation)
                                            <td>{{ $designation->required_designation }} {{ $designation->requiredDesignation->name }}</td>
                                        @else
                                            <td>Joining</td>
                                        @endif
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
@stop