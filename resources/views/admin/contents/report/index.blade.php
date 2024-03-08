@extends('admin.layouts.master')

@section('haed-tag')
<!-- status switch on list -->
<link rel="stylesheet" href="{{ asset('admin-assets/css/component-custom-switch.css') }}">

<title>اخبار | پنل مدیریت</title>
@endsection

@section('content')
<!-- post page Breadcrumb area -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb m-0 font-size-12">
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="{{ route('admin.home') }}">خانه</a></li>
        <li class="breadcrumb-item deco"><a class="text-decoration-none" href="#">بخش محتوی</a></li>
        <li class="breadcrumb-item active" aria-current="page">اخبار</li>
    </ol>
</nav>
<!-- post page Breadcrumb area -->

<!--post page post list area -->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    اخبار
                </h5>
            </section>
            @include('admin.alerts.alert-section.success')
            <section class="d-flex justify-content-between align-items-center mt-4 pb-3 mb-3 border-bottom">
                <section>
                    @can('create-report')
                    <a href="{{ route('admin.content.reports.create') }}" class="btn btn-sm btn-info text-white">ایجاد خبر جدید</a>
                    @endcan
                </section>
                <form class="d-flex" action="{{ route('admin.content.reports.index') }}" method="get">
                    <div class="max-width-16-rem">
                        <input type="text" name="search" value="{{request()->search ?? ''}}" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                    <button class="mt-1 btn btn-primary btn-sm me-2" style="height: fit-content;">جستجو</button>
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="border-bottom border-dark table-col-count">
                        <th>#</th>
                        <th>عنوان خبر</th>
                        <th>دسته</th>
                        <th>تصویر</th>
                        @can('edit-report')
                        <th>وضعیت</th>
                        @endcan
                        <th>امکان درج نظرات</th>
                        <th class="max-width-16-rem text-center"><i class="fa fa-cogs ms-2"></i>تنظیمات</th>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr class="align-middle">
                            <th>{{ iteration($loop->iteration, request()->page) }}</th>
                            <td>{{ $report->title }}</td>
                            <td>{{ $report->Category->name }}</td>
                            <td>
                                <img src="{{ $report->image ? hasFileUpload($report->image['indexArray'][$report->image['currentImage']]) : hasFileUpload($report->image) }}" width="50" height="50" alt="{{ $report->name }}">
                            </td>
                            @can('edit-report')
                            <td>
                                <section>
                                    <div class="custom-switch custom-switch-label-onoff d-flex align-content-center" dir="ltr">
                                        <input data-url="{{ route('admin.content.reports.status', $report->id) }}" onchange="changeStatus(this.id)" class="custom-switch-input" id="{{ $report->id . '-status' }}" name="status" type="checkbox" @if($report->status) checked @endif>
                                        <label class="custom-switch-btn" for="{{ $report->id . '-status' }}"></label>
                                    </div>
                                </section>
                            </td>
                            <td>
                                <section>
                                    <div class="custom-switch custom-switch-label-onoff d-flex align-content-center" dir="ltr">
                                        <input data-url="{{ route('admin.content.reports.commentable', $report->id) }}" onchange="changeCommentable(this.id)" class="custom-switch-input" id="{{ $report->id . '-commentable' }}" name="commentable" type="checkbox" @if($report->commentable) checked @endif>
                                        <label class="custom-switch-btn" for="{{ $report->id . '-commentable' }}"></label>
                                    </div>
                                </section>
                            </td>
                            @endcan
                            <td class="width-16-rem text-start">
                                @can('edit-report')
                                <a href="{{ route('admin.content.reports.edit', $report->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit ms-2"></i>ویرایش</a>
                                @endcan
                                @can('delete-report')
                                <form class="d-inline" action="{{ route('admin.content.reports.destroy', $report->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="{{ $report->id }}" class="btn btn-danger btn-sm delete"><i class="fa fa-trash ms-2"></i>حذف</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr class="align-middle">
                            <th colspan="" class="text-center emptyTable  py-4">جدول اخبار ها خالی می باشد</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <section class="mb-3 mt-5 d-flex justify-content-center border-0">
                    <nav>
                        {{ $reports->links('pagination::bootstrap-4') }}
                    </nav>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- post page post list area -->
@endsection
@section('script')
<script src="{{ asset('admin-assets/js/plugin/ajaxs/commentable-ajax.js') }}"></script>
<script src="{{ asset('admin-assets/js/plugin/ajaxs/status-ajax.js') }}"></script>

@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete','fieldTitle' => 'اخبار'])


@endsection