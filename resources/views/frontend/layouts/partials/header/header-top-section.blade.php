<div class="row m-auto container-fluid max-width py-4 header-logo">
    <div class="col-lg-3">
        <a class="text-decoration-none" href="{{ route('user.home') }}">
            <div class="row">
                <div class="col-lg-6 col-12 d-flex justify-content-center"><img class="card-img logo-img" src="{{ hasFileUpload($setting->logo) }}" alt="logo"></div>
                <div class="col-lg-6 col-12 align-self-center">
                    <div class="row text-center">
                        <div class="col-12 p-0">
                            <h1 class="h2 bold text-dark">{{$setting->title}}</h1>
                        </div>
                        <div class="col-12 p-0">
                            <h5 class="text-dark">اخبار روز جهان و ایران</h1>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-9 image-height d-md-block d-none pl-0 text-truncate ">
        @if($headerBanner->count() > 0)
        <a href="{{ urldecode($headerBanner->url) }}" class="text-decoration-none" target="_black">
            <img class="img-header mt-n4" src="{{ hasFileUpload($headerBanner->image, 'banner-width') }}" alt="{{$headerBanner->title}}">
        </a>
        @else
        <img class="img-header mt-n4" src="{{ hasFileUpload('images/banner/a.png', 'banner-width') }}" alt="none-banner">
        @endif
    </div>
</div>