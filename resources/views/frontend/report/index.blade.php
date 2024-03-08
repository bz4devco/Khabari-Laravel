@extends('frontend.layouts.master')
@section('haed-tag')
<meta name="robots" content="index, follow">
<title>{{request()->search ? request()->search : ($reportCategory ? $reportCategory->name : 'عناوین خبر')}} | {{$setting->title}}</title>
@endsection


@section('content')
<section class="content max-width m-auto">
    <div class="row container-fluid m-auto">
        <div class="col-md-8">
            <div class="row mb-5">
                <div class="col">
                    <div class="w-100 mt-4  border-bottom border-danger">
                        <a href="health.html" class="text-decoration-none">
                            <h3 class="title h4 border-danger text-right text-hover text-dark">
                                {{request()->search ? request()->search : ($reportCategory ? $reportCategory->name : 'عناوین خبر')}}
                            </h3>
                        </a>
                    </div>
                    @forelse ($reports as $report)
                    @if($loop->iteration == 1)
                    <a href="{{ route('user.reports.detail', $report) }}" target="_black" class="text-decoration-none text-right">
                        <div class="card w-100 mt-3 mb-2 border-bottom b1 border-light">
                            <img class="card-img-top" src="{{ $report->image ? hasFileUpload($report->image['indexArray'][$report->image['currentImage']]) : hasFileUpload('a.png') }}" alt="{{$report->title}}" style="width:100%;max-height: 400px;object-fit: cover;">
                            <div class="card-body">
                                <h4 class="card-title text-dark text-hover">{!! strip_tags(Str::limit($report->title, 25)) !!}</h4>
                                <p class="card-text text-dark">{!! strip_tags(Str::limit($report->abstract, 60)) !!}</p>
                            </div>
                            <div class="card-footer text-right">
                                <div class="time-dallas font-10 mt-2">
                                    <span class="text-dark"><i class="fa fa-clock-o"></i>
                                        {{ jalaliDate($report->new_date, '%a %d %b %Y H:i:s')}}
                                    </span>
                                    <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-comment-o mr-3"></i>
                                        {{$report->comments()->count()}} نظر
                                    </a>
                                    <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-eye mr-3"></i>
                                        {{$report->visit_counter}} بازدید
                                    </a>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endif
                    @if($loop->iteration >= 2)
                    <div class="card border-0" my-2 style="max-width: 1000px;">
                        <div class="row no-gutters border-bottom b1 border-light">
                            <div class="col-lg-4 align-self-center">
                                <a href="details.html" target="_black" class="text-decoration-none align-self-center text-dark">
                                    <img src="images/1972797.jpg" class="card-img" alt="">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body text-right">
                                    <a href="details.html" target="_black" class="text-decoration-none text-dark">
                                        <h5 class="card-title text-hover">{!! strip_tags(Str::limit($report->title, 25)) !!}</h5>
                                    </a>
                                    <p class="card-text">{!! strip_tags(Str::limit($report->abstract, 60)) !!}</p>
                                    <p class="card-text">
                                    <div class="time-dallas font-10 mt-2">
                                        <span class=""><i class="fa fa-clock-o"></i>
                                            {{ jalaliDate($report->new_date, '%a %d %b %Y H:i:s')}}
                                        </span>
                                        <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-comment-o mr-3"></i>
                                            {{$report->comments()->count()}} نظر
                                        </a>
                                        <a href="javascript:void(0);" target="_black" class="text-decoration-none text-hover"><i class="fa fa-eye mr-3"></i>
                                            {{$report->visit_counter}} بازدید
                                        </a>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @empty
                    <div class="card border-0 py-5" my-2 style="max-width: 1000px;">
                        <p class="text-center"><strong>خبری وجود ندارد</strong></p>
                    </div>
                    @endforelse

                    <section class="mb-3 mt-5 d-flex justify-content-center">
                        <nav>
                            {{ $reports->links('pagination::bootstrap-4') }}
                        </nav>
                    </section>
                </div>
            </div>

        </div>

        @include('frontend.layouts.sidebar')

    </div>
</section>
@endsection