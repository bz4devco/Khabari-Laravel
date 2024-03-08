@extends('frontend.layouts.master')

@section('haed-tag')
<meta name="robots" content="index, follow">
<title>بازیابی رمزعبور | {{$setting->title}}</title>
@endsection


@section('content')
<section class="content max-width m-auto">
    <div class="row container-fluid m-auto">
        <section class="container my-5">
            <div class="modal-content text-right">
                <div class="modal-header textt-right">
                    <h5 class="modal-title" id="exampleModalLabel">بازیابی رمزعبور</h5>
                </div>
                <div class="modal-body">
                    <form id="register-form" action="{{route('user.auth.password.forget')}}" method="post">
                        @csrf
                        <section class="row">
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
                        <section class="col-md-6">
                            <div class="form-group">
                                <label for="password">رمزعبور</label>
                                <input type="password" class="form-control form-control-sm" name="password" id="password">
                                @error('password')
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
                                <label for="password_confirmation">تکرار رمزعبور</label>
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
                    </form>
                </div>
                <div class="modal-footer ">
                    <button type="submit" form="register-form" class="btn btn-sm btn-danger">بازیابی رمزعبور</button>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection