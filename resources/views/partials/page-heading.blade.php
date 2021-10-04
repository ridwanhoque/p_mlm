<div class="page-heading">
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div>
                    <ul>
                        <li>
                            <a href="/" title="Go to Home Page">Home</a>
                            @if($category->parents->isNotEmpty())
                                <span>&rsaquo; </span>
                            @endif
                        </li>
                        @foreach($category->parents as $parent)
                            <li>
                                <a href="{!! $parent->permalink() !!}" title="{{ $parent->name }}">{{ $parent->name }}</a>
                                @if(!$loop->last)
                                    <span>&rsaquo; </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!--col-xs-12-->
                <div class="page-title">
                    <h2>{{ $category->name }}</h2>
                </div>
                <!--row-->
            </div>
        </div>
        <!--container-->
    </div>
</div>