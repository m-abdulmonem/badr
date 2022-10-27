<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ActivateAccountController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request,$code)
    {
        if($code && ($user = User::where("otp_code",$code)->first())){
            $user->update(['status' => 1]);
        }

        abort(404);
    }
}
