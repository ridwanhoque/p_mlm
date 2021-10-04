@extends('layouts.portal')

@section('title', 'Wallet History')

@section('content')
    @include('partials.page-title', ['title' => 'Wallet History'])

    <section class="main-container col2-right-layout">
        <div class="main container">
            <div class="my-account">
                <!--page-title-->
                <!-- BEGIN DASHBOARD-->
                <div class="dashboard">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Transaction From</th>
                                    <th>Process Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($histories as $history)
                                <tr>
                                    <td>{{ $history->amount() }}</td>
                                    <td>{{ $history->transactionFrom() }}</td>
                                    <td><span class="label-{!! $history->processStatus('class') !!} label">{{ $history->processStatus() }}</span></td>
                                    <td>{{ $history->created_at->format('d F, Y') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pager">
                        {!! $histories->links('partials.pagination') !!}
                    </div>
                </div>
            </div>
        </div>
        <!--main container-->
    </section>
@endsection
