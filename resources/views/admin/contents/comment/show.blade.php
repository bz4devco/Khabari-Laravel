@extends('admin.layouts.master')

@section('haed-tag')
<title> نمایش نظر | پنل مدیریت </title>
@endsection

@section('content')
<!-- category page Breadcrumb area -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb m-0 font-size-12">
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.home') }}">خانه</a></li>
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="#">بخش محتوی</a></li>
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.content.comment.index') }}">نظرات</a></li>
        <li class="breadcrumb-item active" aria-current="page">نمایش نظر</li>
    </ol>
</nav>
<!-- category page Breadcrumb area -->

<!--category page category list area -->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    نمایش نظر
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <a href="{{ route('admin.content.comment.index') }}" class="btn btn-sm btn-info text-white">بازگشت</a>
            </section>
            <section class="card mb-3">
                <section class="card-header bg-custom-yellow text-white font-size-14">
                    {{$comment->author->full_name}} - {{$comment->author->id}}
                </section>
                <section class="card-body">
                    <h5 class="card-title mb-3">عنوان خبر : {{$comment->commentable->title}} &nbsp;-&nbsp; کد خبر: {{$comment->commentable->id}}</h5>
                    <section class="d-flex">
                        <i class="far fa-comments ms-2"></i>
                        <p class="card-text font-size-14">{{strip_tags($comment->body)}}</p>
                    </section>
                    <section class="card-footer">
                        <small class="text-success"><i class="fa fa-calendar-alt ms-2"></i> {{jalaliDate($comment->created_at)}}</small>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- category page category list area -->
@endsection