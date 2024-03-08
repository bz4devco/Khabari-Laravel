@extends('frontend.layouts.master')

@section('haed-tag')
<meta name="robots" content="index, follow">
<title>{{$report->title}} | {{$setting->title}}</title>
@endsection


@section('content')
<section class="content max-width m-auto mb-3">
    <div class="row container-fluid m-auto">
        <div class="col-md-8">
            <div class="row">
                <div class="col-12">
                    <div class="mt-4 border-bottom b1 border-secondary">
                        <ul class="list-unstyled m-0 p-0 d-flex">
                            <li class="font-10">{{ jalaliDate($report->new_date, '%d %B %Y ،H:i:s')}}</li>
                            <li class="mr-auto">
                                <ul class="bold list-unstyled font-14 p-0 d-flex justify-content-center">
                                    <li class="nav-item mx-1">
                                        <a class="nav-link text-dark p-0 text-hover" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="انتشار خبر در فیس بوک"><i class="fa fa-instagram mr-2 text-hover" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a class="nav-link text-dark p-0 " href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="انتشار خبر در تلگرام"><i class="fa fa-telegram mr-2 text-hover" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a class="nav-link text-dark p-0  text-hover" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="انتشار خبر در توییتر"><i class="fa fa-twitter mr-2 text-hover" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a class="nav-link text-dark p-0  text-hover" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="انتشار خبر در واتس اپ"><i class="fa fa-whatsapp mr-2 text-hover" aria-hidden="true"></i></a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a class="nav-link text-dark p-0  text-hover" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="چاب خبر"><i class="fa fa-print mr-2 text-hover" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="text-right mt-4 d-flex justify-content-between">
                        <a href="javascript:void(0);" class="text-decoration-none text-dark">
                            <h5 class="card-title text-hover">{{ $report->title }}</h5>
                        </a>
                        <section class="d-flex justify-content-between">
                            @auth
                            @if(auth()->user()->user_type == 0)
                            @if ($report->user->contains(auth()->user()->id))
                            <a href="{{route('user.reports.add-to-favorite', $report)}}" class="ml-2">
                                <span class="badge badge-dark px-3 py-2">حذف از علاقه مندی</span>
                            </a>
                            @else
                            <a href="{{route('user.reports.add-to-favorite', $report)}}" class="ml-2">
                                <span class="badge badge-dark px-3 py-2">افزودن به علاقه مندی</span>
                            </a>
                            @endif
                            @endif
                            @endauth

                            <a href="{{ route('user.reports.index', $report->category) }}">
                                <span class="badge badge-dark px-3 py-2">{{$report->category->name}}</span>
                            </a>
                        </section>
                    </div>
                    <a href="javascript:void(0);" class="text-decoration-none text-right">
                        <div class="card mx-auto mt-3 mb-2 border-bottom b1 border-light">
                            <img class="card-img-top" src="{{ $report->image ? hasFileUpload($report->image['indexArray'][$report->image['currentImage']]) : hasFileUpload('a.png') }}" alt="{{$report->title}}" style="width:100%;max-height: 400px;object-fit: cover;">
                            <div class="card-footer text-right">
                                {!! strip_tags($report->abstract) !!}
                            </div>
                        </div>
                    </a>
                    <div class="row p-0 mx-0 my-4">
                        <div class="col-12 p-0 text-justify border-bottom b1 border-secondary py-3">
                            {{ strip_tags($report->abstract) }}
                            <br>
                            <small class="text-secondary">کد خبر {{$report->id}}</small>
                        </div>
                        <div class="col-12 my-3 text-right">
                            <p>لینک اشتراک گذاری این خبر :</p>
                            <a class="text-decoration-none">
                                <p class="copy-code d-inline float-left" data-clipboard-text="{{ Route('user.reports.detail', $report)}}">
                                    <span class="font-13 ml-2"> {{ Route('user.reports.detail', $report)}}</span><i class="fa fa-link font-14"></i>
                                </p>
                            </a>
                        </div>
                        @if($tags)
                        <div class="col-12 mb-3 border-bottom border-danger">
                            <h3 class="title h5 border-danger text-right  text-dark">برچسب ها</h3>
                        </div>
                        <div class="col-12 mb-2 border-bottom b1 border-light">
                            <ul class="list-unstyled p-0">
                                <li class="d-flex flex-wrap font-14">
                                    @forelse($tags as $tag)
                                    <a href="javascript:void(0);" target="_black" class="bg-black text-white text-decoration-none bg-hover p-2  m-2">
                                        {{$tag}}
                                    </a>
                                    @empty
                                    @endforelse
                                </li>
                            </ul>
                        </div>
                        @endif
                    </div>
                    @include('frontend.layouts.partials.report.comments', ['report' => $report])
                </div>
            </div>
        </div>
        @include('frontend.layouts.sidebar')
    </div>
</section>
@endsection