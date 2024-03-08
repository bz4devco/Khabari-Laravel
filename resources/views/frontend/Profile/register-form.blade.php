@extends('frontend.layouts.master')

@section('haed-tag')
<meta name="robots" content="index, follow">
<title>ثبت نام | {{$setting->title}}</title>
@endsection


@section('content')
<section class="content max-width m-auto">
    <div class="row container-fluid m-auto">
        <section class="container my-5">
            <div class="modal-content text-right">
                <div class="modal-header textt-right">
                    <h5 class="modal-title" id="exampleModalLabel">ثبت نام در وبسایت</h5>
                </div>
                <div class="modal-body">
                    <form id="register-form" action="{{ route('user.auth.register') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <section class="row">
                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">نام</label>
                                    <input type="text" class="form-control form-control-sm" name="first_name" id="first_name" value="{{ old('first_name') }}">
                                    @error('first_name')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">نام خانوادگی</label>
                                    <input type="text" class="form-control form-control-sm" name="last_name" id="last_name" value="{{ old('last_name') }}">
                                    @error('last_name')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">شماره موبایل</label>
                                    <input type="text" class="form-control text-left form-control-sm" name="mobile" id="mobile" value="{{ old('mobile') }}">
                                    @error('mobile')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-md-6">
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
                                </div>
                            </section>
                            <section class="col-md-12">
                                <div class="form-group">
                                    <label for="national_code">کد ملی</label>
                                    <input type="text" class="form-control form-control-sm" name="national_code" id="national_code" value="{{ old('national_code') }}">
                                    @error('national_code')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="province">استان</label>
                                    <select class="form-control form-control-sm" name="province" id="province">
                                        <option disabled selected>لطفاً جنسیت خود را انتخاب کنید</option>
                                        @forelse ($provinces as $province)
                                        <option value="{{$province->id}}" data-url="{{ route('user.auth.get-cities', $province->id)}}" @if(old('province')==$province->id) selected @endif > {{$province->name}} </option>
                                        @empty
                                        <option disabled>استانی وجود ندارد</option>
                                        @endforelse
                                    </select>
                                    @error('province')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="city" class="form-label">شهر</label>
                                    <select class="form-control form-control-sm" id="city" name="city" data-old="{{old('city')}}">
                                        <option disabled selected>شهر را انتخاب کنید</option>
                                    </select>
                                    @error('city')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="avatar">انتخاب تصویر پروفایل</label>
                                    <input type="file" class="form-control-file" name="avatar" id="avatar">
                                    <small id="avatarHelp" class="form-text text-muted">فیلد اختیاری می باشد.</small>
                                    @error('avatar')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">جنسیت</label>
                                    <select class="form-control form-control-sm" name="gender" id="gender">
                                        <option disabled selected>لطفاً جنسیت خود را انتخاب کنید</option>
                                        <option value="0" @if(old('gender')==0) selected @endif>مرد</option>
                                        <option value="1" @if(old('gender')==1) selected @endif>زن</option>
                                    </select>
                                    @error('gender')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-md-12" id="service_status_container" data-old="{{ old('service_status') }}">
                            </section>
                            <section class="col-md-12">
                                <div class="form-group">
                                    <label for="username">نام کاربری</label>
                                    <input type="text" class="form-control form-control-sm" name="username" id="username" value="{{ old('username') }}">
                                    @error('username')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                    <small id="usernameHelp" class="form-text text-muted">نام کاربری توصیه میشود از اعداد و حروف بزرگ و کوچک لاتین استفاده شود.</small>
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="password">رمز عبور</label>
                                    <input type="password" class="form-control form-control-sm" name="password" id="password">
                                    @error('password')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                    <small id="passwordHelp" class="form-text text-muted">

                                        برای تعریف رمز عبور استتاندراد از قوانین فوق پیروی نمایید :
                                        <ol style="direction: rtl;" class="pr-3">
                                            <li>از اعداد استفاده نمایید</li>
                                            <li>از حروف لاتین استفاده نمایید</li>
                                            <li>از حروف بزرگ و کوچک به صورت ترکیبی استفاده نمایید</li>
                                            <li>از کارکترهای معنا دار !,?,@,#,$,%,^ استفاده نمایید</li>
                                            <li>رمز عبور حداقل 8 کاراکتر باشد</li>
                                        </ol>
                                    </small>
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">تکرار رمز عبور</label>
                                    <input type="password" class="form-control form-control-sm" name="password_confirmation" id="password_confirmation">
                                    @error('password_confirmation')
                                    <small class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </small>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-md-3">
                                <div class="form-group">
                                    <label for="captcha">کد امنیتی</label>
                                    <br>
                                    <img src="{{ route('user.auth.register.captcha') }}" class="d-block mx-auto" alt="CAPTCHA">
                                    <input type="text" class="form-control form-control-sm mt-3" name="captcha" id="captcha" placeholder="کد امنیتی را وارد نمایید">
                                    @error('captcha')
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
                    <button type="submit" form="register-form" class="btn btn-sm btn-danger">ثبت نام</button>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
@section('script')
<script>
    let errorMessage = '';
</script>
@error('service_status')
<script>
    errorMessage = `
        <small class="text-danger">
            <strong>
                {{ $message }}
            </strong>
        </small>
      `;
</script>
@enderror
<script src="{{ asset('frontend/js/pages/register-form.js') }}"></script>
<script src="{{ asset('frontend/js/ajaxs/cities-ajax.js') }}"></script>
@endsection