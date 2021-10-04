@extends('layouts.portal')

@section('content')
    @include('partials.page-title', ['title' => 'Orders'])

    <!-- BEGIN Main Container col2-right -->
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
                                        <th>Order # </th>
                                        <th>Date</th>
                                        <th><span class="nobr">Order Total</span></th>
                                        <th>Status</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr class="first odd">
                                        <td>{{ $order->id }}</td>
                                        <td><span class="nobr">{!! $order->orderedAt !!}</span></td>
                                        <td><span class="price">৳{{ number_format($order->total, 2) }}</span></td>
                                        <td><em>{{ $order->status() }}</em></td>
                                        <td class="a-center last">
                                            <span class="nobr">
                                                <a href="{!! route('portal.orders.show', $order) !!}">View Order</a>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($orders->isEmpty())
                                    <tr class="first odd">
                                        <td colspan="5" class="text-center">You haven't order anything.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <!--table-responsive-->
                        <div class="pager pt-4">
                            {!! $orders->links('partials.pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--main container-->
    </section>
@endsection