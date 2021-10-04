@extends('layouts.website')

@section('title', $category->name)
@push('styles')
    <link rel="stylesheet" type="text/css" href="/web/stylesheet/flexslider.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
@endpush


@section('content')
    @include('partials.page-heading')

    <section class="main-container col2-left-layout bounceInUp animated">
        <div class="container">
            <div class="row">
                <div class="col-main product-grid">
                    <div class="pro-coloumn">
                        <article class="col-main">
                            <div class="toolbar">
                                <div class="sorter">
                                    <div class="view-mode">
                                        @if(request()->query('view') == 'list')
                                            <a href="?view=grid" title="Grid" class="button-list">Grid</a>
                                            <span title="List" class="button-grid button button-active">List</span>
                                        @else
                                            <span title="Grid" class="button-grid button button-active">Grid</span>
                                            <a href="?view=list" title="List" class="button-list {!! request()->query('view') == 'list' ? 'button button-active' : '' !!}">List</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @include('partials.package-slider', ['section_class' => 'pb-4'])

                            <div class="category-products">
                                @if(request()->query('view') == 'list')
                                    @include('product.list-view')
                                @else
                                    @include('product.grid-view')
                                @endif
                            </div>
                            <div class="toolbar">
                                <div class="pager">
                                    {!! $products->links('partials.pagination') !!}
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
            <!--row-->
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript" src="/web/js/jquery.flexslider.js"></script>
    <script type="text/javascript" src="/web/js/cloud-zoom.js"></script>
    <script type="text/javascript" src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script>
        $('.packages').flickity({
            pageDots: false,
            contain: true,
            cellAlign: 'left',
            autoPlay: 1500
        });
    </script>
@endpush