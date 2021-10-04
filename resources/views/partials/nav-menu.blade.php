<!-- BEGIN NAV -->
<ul id="nav" class="hidden-xs">
    <li class="mega-menu"><a href="javascript:void()" class="level-top"><span>Categories</span></a>
        <div class="level0-wrapper dropdown-6col">
            <div class="container">
                <div class="level0-wrapper2">
                    <div class="nav-block nav-block-center">

                        <ul class="level0">
                            @foreach($categories as $category)
                            <li class="level1 nav-6-1 parent item"><a href="{!! $category->permalink() !!}"><span>{{ $category->name }}</span></a>
                                <ul class="level1">
                                    @foreach($category->immediateChildren as $children)
                                        <li class="level2 nav-6-1-1"><a href="{!! $children->permalink() !!}"><span>{{ $children->name }}</span></a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
                <!--level0-wrapper2-->
            </div>
        </div>
    </li>

    @foreach($featuredCategories as $featuredCategory)
        <li class="mega-menu">
            <a href="{{ $featuredCategory->permalink() }}" class="level-top"><span>{{ $featuredCategory->name }}</span>
            </a>
            <div class="level0-wrapper dropdown-6col">
                <div class="container">
                    <div class="level0-wrapper2">
                        <div class="nav-block nav-block-center">
                            <ul class="level0">
                                @foreach($featuredCategory->menuChildrens  as $category)
                                <li class="level1 nav-6-1 parent item"><a href="{!! $category->permalink() !!}"><span>{{ $category->name }}</span></a>
                                    <ul class="level1">
                                        @foreach($category->immediateChildren as $children)
                                            <li class="level2 nav-6-1-1">
                                                <a href="{!! $children->permalink() !!}"><span>{{ $children->name }}</span></a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!--level0-wrapper2-->
                </div>
            </div>
        </li>
    @endforeach
</ul>
<!--nav-->