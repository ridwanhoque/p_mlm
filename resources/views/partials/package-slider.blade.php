@if($packages->isNotEmpty())
    <div class="brand-logo {!! $section_class ?? 'pt-4' !!}">
        <div class="container">
            <div class="packages related-pro">
                @foreach($packages as $package)
                    <a href="{!! $package->permalink() !!}" style="margin-right: 20px">
                        <img src="{!! $package->firstImagePath() !!}" alt="">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif

