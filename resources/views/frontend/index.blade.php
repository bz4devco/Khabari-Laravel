@extends('frontend.layouts.master')

@section('haed-tag')
<meta name="robots" content="index, follow">
<title>صفحه اصلی | {{$setting->title}}</title>
@endsection


@section('content')
<section class="content max-width m-auto">
    <div class="row container-fluid m-auto">
        <div class="col-md-8">
            @include('frontend.layouts.partials.home.main-slider')
            @include('frontend.layouts.partials.home.main-categories')
        </div>

        @include('frontend.layouts.sidebar')
        
        @include('frontend.layouts.partials.home.categories-slider')

        @include('frontend.layouts.partials.home.relatedCategories')

        @include('frontend.layouts.partials.home.bottom-banner')
    </div>
</section>
@endsection