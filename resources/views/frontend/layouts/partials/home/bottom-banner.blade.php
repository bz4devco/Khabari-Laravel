@if($contentBanner)
<div class="col-md-12 image-height2 d-md-block d-none text-truncate my-4">
    <a href="{{ urldecode($contentBanner->url) }}" target="_black" class="text-decoration-none">
        <img class="img-header mt-n4" src="{{ hasFileUpload($headerBanner->image, 'banner-width') }}" alt="{{ $contentBanner->title }}">
    </a>
</div>
@else
<div class="col-md-12 image-height2 d-md-block d-none text-truncate my-4">
    <img class="img-header mt-n4" src="{{ hasFileUpload('images/banner/a.png', 'banner-width') }}" alt="none-banner">
</div>
@endif