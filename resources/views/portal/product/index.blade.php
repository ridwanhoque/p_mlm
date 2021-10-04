@extends('layouts.portal')

@section('title', 'Products')

@section('content')
    @include('partials.page-title', ['title' => (request()->has('joining') ? 'Joining' : 'General') . ' Products'])
    @inject(request, Illuminate\Http\Request)

    <section class="main-container col2-right-layout">
        <div class="main container">
            <div class="my-account">
                <!--page-title-->
                <!-- BEGIN DASHBOARD-->

                <div class="dashboard">
                    <form>
                        @if($request->has('joining'))
                            <input type="hidden" name="joining" value="true">
                        @endif
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <div class="input-box">
                                        <input type="text" value="{{ $request->get('code') }}" id="code" name="code" class="input-text w-100">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <div class="input-box">
                                        <input type="text" value="{{ $request->get('name') }}" id="name" name="name" class="input-text w-100">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <div class="input-box">
                                        <select data-selected="{{ $request->get('category') }}" name="category" id="category" class="input-text w-100">
                                            <option value="">Select category</option>
                                            @foreach($categories as $category)
                                                <option value="{!! $category->id !!}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="sort_by">Highest/Lower</label>
                                    <div class="input-box">
                                        <select data-selected="{{ $request->get('sort_by') }}" name="sort_by" id="sort_by" class="input-text w-100">
                                            <option value="">Select category</option>
                                            <option value="desc">Highest</option>
                                            <option value="asc">Lowest</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2" style="padding-top: 23px">
                                <button type="submit" class="button"><span>Filter</span></button>
                            </div>
                            <div class="col-md-2 text-right">
                                <p>Total: {{ $products->total() }}</p>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="data-table table-striped">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Previous Price</th>
                                    <th>Discount</th>
                                    <th>Present Price</th>
                                    <th>Commission</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->immediateCategory->parents->first()->name }}</td>
                                    <td>{{ $product->prevoiusPrice ?? '---' }}</td>

                                    <td>{{ $product->discountAmount ?? '---' }}</td>
                                    <td>{{ $product->price() }}</td>
                                    <td>{{ $product->commission }}</td>
                                    <td>
                                        <a href="{!! $product->permalink() !!}">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!--main container-->
    </section>
@stop