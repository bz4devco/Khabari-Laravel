<?php

namespace App\Http\Controllers\Auth\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showForgetForm()
    {
        return view('frontend.auth.forget-password');
    }


    public function sendResetLink(Request $request)
    {
        $this->validateForm($request);

        $userType = User::where('email', $request->email)
            ->where('user_type', 0)->first();

        if (!$userType) {
            return $this->sendForgetFailedResponse();
        }

        $response = Password::broker()->sendResetLink($request->only('email'));

        if($response === Password::RESET_LINK_SENT){
            return back()->with('swal-success', 'لینک بازیابی رمزعبور با موفقیت به ایمیل شما ارسال شد');
        }

        return back()->with('emailError', 'ایمیلی که وارد کرده اید در سیستم وجود ندارد');
    }


    protected function validateForm($request)
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);
    }

    protected function sendForgetFailedResponse()
    {
        return back()->with('emailError', 'ایمیلی که وارد کرده اید در سیستم وجود ندارد');
    }}
