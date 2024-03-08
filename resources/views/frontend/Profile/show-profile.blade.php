@extends('frontend.layouts.master')

@section('haed-tag')
<meta name="robots" content="index, follow">
<title>پروفایل | {{$setting->title}}</title>
@endsection

@section('content')
<section class="content max-width m-auto">
    <div class="row container-fluid mx-auto my-3">
        @include('frontend.layouts.partials.profile.sidebar')
        <section class="col-md-9 my-2">
            <div class="modal-content text-right ">
                <div class="modal-header textt-right">
                    <h5 class="modal-title" id="exampleModalLabel">اطلاعات کاربری</h5>
                    <a href="{{ route('user.profile.edit') }}" class="btn btn-danger btn-sm">ویرایش اطلاعات</a>
                </div>
                <div class="modal-body">
                    <section class="row">
                        <section class="col-md-12 my-2">
                            <img class="rounded-pill d-block mx-auto" width="100" height="100" src="{{ $user->profile_photo_path ? asset($user->profile_photo_path) : asset('frontend/images/img_avatar3.png')}}" alt="avatar">
                        </section>
                        <section class="col-md-12 my-3">
                            <h4 class="text-center">
                                <strong>
                                    {{$user->full_name}}
                                </strong>
                            </h4>
                        </section>
                        <section class="col-md-6 my-3">
                            <h6>
                                شماره موبایل : {{$user->mobile}}
                            </h6>
                        </section>
                        <section class="col-md-6 my-3">
                            <h6>
                                ایمیل : {{$user->email}}
                            </h6>
                        </section>
                        <section class="col-md-6 my-3">
                            <h6>
                                استان : {{$user->address['province_name']}}
                            </h6>
                        </section>
                        <section class="col-md-6 my-3">
                            <h6>
                                شهر : {{$user->address['city_name']}}
                            </h6>
                        </section>
                        <section class="col-md-6 my-3">
                            <h6>
                                جنسیت : {{$user->gender == 0 ? 'مرد' : 'زن'}}
                            </h6>
                        </section>
                        <section class="col-md-6 my-3">
                            <h6>
                                وضعیت نظام وظیفه : {{$user->service_status == 0 ? 'درحال تحصیل' : ($user->service_status == 1 ? 'معافیت' : 'پایان خدمت')}}
                            </h6>
                        </section>
                        <section class="col-md-6 my-3">
                            <h6>
                                نام کاربری : {{$user->username}}
                            </h6>
                        </section>
                        <section class="col-md-6 my-3">
                            <h6>
                                کد ملی : {{$user->national_code}}
                            </h6>
                        </section>
                    </section>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
