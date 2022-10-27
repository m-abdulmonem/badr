<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActiveAccount;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | Register Controller
     |--------------------------------------------------------------------------
     |
     | This controller handles the registration of new users as well as their
     | validation and creation. By default this controller uses a trait to
     | provide this functionality without requiring any additional code.
     |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'f_name' => ['required', 'string'],
            'm_name' => ['nullable', 'string'],
            'l_name' => ['required', 'string'],
            'phone' => ['required', 'numeric', 'regex:/^01[0125][0-9]{8}$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     *
     */
    protected function create(array $data)
    {
        $otp =rand(100000,999999);

        User::create([
            'phone' => $data['phone'],
            'f_name' => $data['f_name'],
            'l_name' => $data['l_name'],
            'm_name' => $data['m_name'],
            'full_name' => $this->fullName($data),
            'email' => $data['email'],
            'otp_code' => $otp,
            'password' => Hash::make($data['password']),
        ]);

        Mail::to($data['email'])->send(new ActiveAccount($otp));
    }



    private function fullName($data)
    {
        return $data['f_name'] . " " . $data['m_name'] . " " . $data['l_name'];
    }
}
