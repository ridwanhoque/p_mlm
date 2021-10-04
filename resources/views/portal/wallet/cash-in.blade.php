@extends('layouts.portal')

@section('title', 'Cash In')

@section('content')
    @include('partials.page-title', ['title' => 'Cash In'])

    <section class="main-container col2-right-layout">
        <div class="main container">
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            <div class="my-account">
                <!--page-title-->
                <!-- BEGIN DASHBOARD-->
                <div class="dashboard">
                    <div class="row">
                        <div class="col-md-6">
                            <cash-in inline-template payment-method="{{ old('payment_method') }}">
                                <form action="/portal/wallet/cash-in" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <div class="input-box">
                                            <input type="text" value="{{ old('amount') }}" id="amount" name="amount" class="input-text w-100">
                                            @error('amount')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_method">Payment Method</label>
                                        <div class="input-box">
                                            <select v-model="payment_type" id="payment_method" name="payment_method" class="input-text w-100">
                                                <option value="bank">Bank</option>
                                                <option value="sslcommerz">SSL Commerz</option>
                                            </select>
                                        </div>
                                    </div>
                                    <template v-if="payment_type === 'bank'">
                                        <div class="form-group">
                                            <label for="bank_name">Bank Name</label>
                                            <div class="input-box">
                                                <input value="{{ old('bank_name') }}" type="text" id="bank_name" name="bank_name" class="input-text w-100">
                                                @error('bank_name')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="transaction_id">Transaction ID</label>
                                            <div class="input-box">
                                                <input type="text" value="{{ old('transaction_id') }}" id="transaction_id" name="transaction_id" class="input-text w-100">
                                                @error('transaction_id')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </template>

                                    <div class="form-group">
                                        <button type="submit" class="button">
                                            <span>Cash In</span>
                                        </button>
                                    </div>
                                </form>
                            </cash-in>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--main container-->
    </section>
@endsection
