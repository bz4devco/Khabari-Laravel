<!-- Modal -->
<div class="modal fade text-right" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">ورود به حساب کاربری</h5>
            </div>
            <div class="modal-body">
                <form id="loginForm" method="post" data-url="{{ route('user.auth.login') }}">
                    <div class="form-group">
                        <label for="username">نام کاربری</label>
                        <input type="text" class="form-control form-control-sm" id="username">
                        <small class="text-danger" id="email-error"></small>
                        <small class="text-danger" id="email-incorrectLoginInfo"></small>
                    </div>
                    <div class="form-group">
                        <label for="password">رمز عبور</label>
                        <input type="password" class="form-control form-control-sm" id="password">
                        <small class="text-danger" id="password-error"></small>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">مرا به خاطر بسپار!</label>
                    </div>
                </form>
                <div class="form-check text-center my-3">
                    <a href="{{ route('user.auth.password.forget.form') }}" class="text-decoration-none text-info">فراموشی رمز عبور</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">بستن</button>
                <a href="{{ route('user.auth.register-form') }}" class="btn btn-sm btn-dark">ثبت نام</a>
                <button type="submit" form="loginForm" class="btn btn-sm btn-danger">ورود</button>
            </div>
        </div>
    </div>
</div>