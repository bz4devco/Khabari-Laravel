@extends('frontend.layouts.master')

@section('haed-tag')
<meta name="robots" content="index, follow">
<title>ویرایش اطلاعات پروفایل | {{$setting->title}}</title>
@endsection

@section('content')
<section class="content max-width m-auto">
    <div class="row container-fluid mx-auto my-3">
        @include('frontend.layouts.partials.profile.sidebar')
        <section class="col-md-9 my-2">
            <div class="modal-content text-right">
                <div class="modal-header textt-right">
                    <h5 class="modal-title" id="exampleModalLabel">ویرایش اطلاعات</h5>
                </div>
                <div class="modal-body">
                    <form id="register-form" action="{{ route('user.profile.update', auth()->user()->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-md-12">
                                <div class="form-group">
                                    <section class="text-center">
                                        <label for="avatar">
                                            <img style="cursor: pointer;" class="rounded-pill d-block mx-auto" width="100" height="100" src="{{ $user->profile_photo_path ? asset($user->profile_photo_path) : asset('frontend/images/img_avatar3.png')}}" alt="avatar">
                                        </label>
                                        <input type="file" class="form-control-file d-none" name="avatar" id="avatar">
                                        <small id="avatarHelp" class="form-text text-muted">فیلد اختیاری می باشد.</small>
                                    </section>
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
                                    <label for="first_name">نام</label>
                                    <input type="text" class="form-control form-control-sm" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}">
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
                                    <label for="username">نام خانوادگی</label>
                                    <input type="text" class="form-control form-control-sm" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}">
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
                                    <input type="text" class="form-control text-left form-control-sm" name="mobile" id="mobile" value="{{ old('mobile', $user->mobile) }}">
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
                                    <input type="email" class="form-control form-control-sm" name="email" id="email" value="{{ old('email', $user->email) }}">
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
                                    <input type="text" class="form-control form-control-sm" name="national_code" id="national_code" value="{{ old('national_code', $user->national_code) }}">
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
                                        <option value="{{$province->id}}" data-url="{{ route('user.auth.get-cities', $province->id)}}" @if(old('province', $user->address['province'])==$province->id) selected @endif > {{$province->name}} </option>
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
                                    <select class="form-control form-control-sm" id="city" name="city" data-old="{{old('city', $user->address['city'])}}">
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
                        </section>
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="submit" form="register-form" class="btn btn-sm btn-danger">ثبت ویرایش</button>
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