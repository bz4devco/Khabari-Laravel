@extends('frontend.layouts.master')

@section('haed-tag')
<meta name="robots" content="index, follow">
<title>لیست علاقه مندی ها | {{$setting->title}}</title>
@endsection

@section('content')
<section class="content max-width m-auto">
    <div class="row container-fluid mx-auto my-3">
        @include('frontend.layouts.partials.profile.sidebar')
        <section class="col-md-9 my-2">
            <div class="modal-content text-right ">
                <div class="modal-header textt-right">
                    <h5 class="modal-title">لیست علاقه مندی ها</h5>
                </div>
                <div class="modal-body">
                    <section class="row">
                        @forelse (auth()->user()->reports as $new)
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="row border-light">
                                    <div class="col-lg-4 align-self-center">
                                        <a href="{{ route('user.reports.detail', $new) }}" target="_black" class="text-decoration-none align-self-center text-dark">
                                            <img src="{{ $new->image ? hasFileUpload($new->image['indexArray'][$new->image['currentImage']]) : hasFileUpload('a.png') }}" class="card-img" alt="{{$new->title}}">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body text-right">
                                            <a href="details.html" target="_black" class="text-decoration-none text-dark">
                                                <h5 class="card-title text-hover">{{$new->title}}</h5>
                                            </a>
                                            <p class="card-text ">{{ strip_tags(Str::limit($new->body,50,'...')) }}</p>
                                            <div class="time-dallas font-10 mt-2">
                                                <span class="text-dark"><i class="fa fa-clock-o"></i>
                                                    {{ jalaliDate($new->new_date, '%a %d %b %Y H:i:s')}}
                                                </span>
                                                <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-comment-o mr-3"></i>
                                                    {{$new->comments()->count()}} نظر
                                                </a>
                                                <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-eye mr-3"></i>
                                                    {{$new->visit_counter}} بازدید
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <p class="text-center">
                                    <strong>لیست علاقه مندی های شما خالی می باشد</strong>
                                </p>
                            </div>
                        </div>
                        @endforelse
                    </section>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection