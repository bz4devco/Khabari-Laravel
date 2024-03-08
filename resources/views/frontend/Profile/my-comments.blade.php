@extends('frontend.layouts.master')

@section('haed-tag')
<meta name="robots" content="index, follow">
<title>لیست نظرات من | {{$setting->title}}</title>
@endsection

@section('content')
<section class="content max-width m-auto">
    <div class="row container-fluid mx-auto my-3">
        @include('frontend.layouts.partials.profile.sidebar')
        <section class="col-md-9 my-2">
            <div class="modal-content text-right ">
                <div class="modal-header textt-right">
                    <h5 class="modal-title">لیست نظرات من</h5>
                </div>
                <div class="modal-body">
                    <section class="row">
                        @forelse (auth()->user()->comments as $comment)
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="row border-light">
                                    <div class="col-lg-4 align-self-center">
                                        <a href="{{ route('user.reports.detail', $comment->commentable) }}" target="_black" class="text-decoration-none align-self-center text-dark">
                                            <img src="{{ $comment->commentable->image ? hasFileUpload($comment->commentable->image['indexArray'][$comment->commentable->image['currentImage']]) : hasFileUpload('a.png') }}" alt="{{$comment->commentable->title}}" class="card-img" >
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body text-right">
                                            <a href="" target="_black" class="text-decoration-none text-dark">
                                                <h5 class="card-title text-hover">{{ $comment->commentable->title }}</h5>
                                            </a>
                                            <div class="card m-2 p-2">
                                                <div class="card-title border-bottom pb-1 text-right">
                                                    <i class="fa fa-comments ml-2"></i>نظر شما در این خبر
                                                </div>
                                                <div class="card-body text-right">
                                                    <p class="card-text ">{{ $comment->body }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12">
                                <p class="text-center my-3">
                                    <strong>
                                        نظری در لیست نظرات شما وجود ندارد
                                    </strong>
                                </p>
                        </div>
                        @endforelse
                    </section>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection