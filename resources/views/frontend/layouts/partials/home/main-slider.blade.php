<div class="col mt-4">
    <!-- SLIDER -->
    <div id="demo" class="carousel slide" data-ride="carousel">

        <!-- Indicators -->
        <ul class="carousel-indicators flex-row-reverse">
            @forelse ($mainSlider as $mainSliderItem)
            <li data-target="#demo" data-slide-to="{{ $loop->iteration - 1 }}" class="{{ $loop->iteration - 1 == 0 ? 'active': '' }}"></li>
            @empty
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            @endforelse
        </ul>

        <!-- The slideshow -->
        <div class="carousel-inner">
            @forelse ($mainSlider as $mainSliderItem)
            @php 
             $active =  ($loop->iteration == 1) ? 'active' : '';
            @endphp
            <div class="carousel-item position-relative {{ $active }}">
                <div class="w-75 text-right bg-dark border-bottom border-danger d-md-block d-none position-absolute opacity-8 p-3">
                    <h2 class="h3 mt-3 text-white">{{ $mainSliderItem->title }}</h2>
                    <p class="font-14 text-justify text-white p-2">{!! strip_tags(Str::limit($mainSliderItem->body, 60,  '[...]')) !!}</p>
                </div>
                <a href="{{ urldecode($mainSliderItem->url) }}" target="_black" class="text-decoration-none">
                    <img src="{{ $mainSliderItem->image ? hasFileUpload($mainSliderItem->image) : hasFileUpload('a.png', 'slider') }}" class="w-100" alt="{{ $mainSliderItem->title }}">
                </a>
            </div>
            @empty
            <div class="carousel-item position-relative active">
                <a href="javascript:void(0);" target="_black" class="text-decoration-none">
                    <img src="{{ hasFileUpload('a.png', 'slider') }}" class="w-100" alt="no-slider">
                </a>
            </div> @endforelse
        </div>

        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>

    </div>
</div>