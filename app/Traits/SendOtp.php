<?php

namespace App\Traits;
use App\Mail\ActiveAccount;
use Illuminate\Support\Facades\Mail;


trait SendOtp{





    public function send(String $email)
    {
        $otp = rand(100000,999999);

        Mail::to($email)->send(new ActiveAccount($otp));

        return $otp;

    }



}

