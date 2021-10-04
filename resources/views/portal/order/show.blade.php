@extends('layouts.portal')

@section('content')
    @include('partials.page-title', ['title' => 'Order #' . $order->id])
    <!-- BEGIN Main Container col2-right -->
    <section class="main-container col2-right-layout">
        <div class="main container">
            <div class="my-account">
                <!--page-title-->
                <!-- BEGIN DASHBOARD-->
                <div class="dashboard">
                    <div class="recent-orders">
                        <p>
                            <b>Order Status:</b> {{ $order->status() }}
                            <br> <b>Order Total:</b> {{ $order->total }}
                            <br> <b>Order Date:</b> {{ $order->created_at->format('Y-m-d h:i:s A') }}
                        </p>
                        <div>
                            <p>
                                <b>Shipping Address:</b>
                                {{ $order->shipping_address }}
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table class="data-table table-striped" id="my-orders-table">
                                <thead>
                                <tr class="first last">
                                    <th>Product # </th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->orderable->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->subtotal }}</td>
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