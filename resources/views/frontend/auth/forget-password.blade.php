@extends('frontend.layouts.master')

@section('haed-tag')
<meta name="robots" content="index, follow">
<title>ثبت نام | {{$setting->title}}</title>
@endsection


@section('content')
<section class="content max-width m-auto">
    <div class="row container-fluid m-auto">

        <section class="col-md-6 mx-auto my-5">
            <div class="modal-content text-right">
                <div class="modal-header textt-right">
                    <h5 class="modal-title" id="exampleModalLabel">فراموشی رمزعبور</h5>
                </div>
                <div class="modal-body">
                    <form id="register-form" action="{{route('user.auth.password.forget')}}" method="post">
                        @csrf
                        <section class="row">
                            <section class="col-md-12">
                                <div class="alert alert-info alert-dismissible pr-3 fade show">
                                    <strong class="alert-heading ">توجه داشته باشید</strong>
                                    <hr class="my-2">
                                    <p class="mb-0">
                                        جهت ارسال لینک صفحه تغییر رمزعبور به ایمیل شما، لطفاً آدرس ایمیلی که در وبسایت ثبت نام کرده اید را وارد نمایید.
                                    </p>
                                </div>
                            </section>
                            <section class="col-md-12">
                                <div class="form-group">
                                    <label for="email">ایمیل</label>
                                    <input type="email" class="form-control form-control-sm" name="email" id="email" value="{{ old('email') }}">
                                    @error('email')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                    @error('emailError')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                </div>
                            </section>
                        </section>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="submit" form="register-form" class="btn btn-sm btn-danger">ارسال</button>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
