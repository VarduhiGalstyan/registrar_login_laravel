<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

use App\Services\SMSService;
use App\Models\PhoneVerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

// use Illuminate\Auth\Events\Registered;//email verification

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
    protected $redirectTo = '/home';

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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^(\+374|0)[1-9]\d{7}$/'],
            // 'phone' => 'required|regex:/^\+?\d{10,15}$/|unique:users,phone',
            'gender' => ['required', 'in:male,female'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    // SMS //Coll
    public function register(Request $request, SMSService $smsService)
    {
        $this->validator($request->all())->validate();
        session([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'gender' => $request->gender,
        ]);

        $verificationCode = rand(1000, 9999);

        PhoneVerificationCode::updateOrCreate(
            ['phone' => $request->phone],
            ['code' => $verificationCode, 'expires_at' => Carbon::now()->addMinutes(5)]
        );

        // Ուղարկում ենք SMS
        $smsService->sendVerificationCode($request->phone, $verificationCode);
        // Զանգ ուղարկենք
        // $smsService->sendVerificationCall($request->phone, $verificationCode);


        return redirect()->route('verify-phone')->with('phone', $request->phone);
    }
    // email verifiatim
    // public function register(Request $request)
    // {
    //     $this->validator($request->all())->validate();

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'phone' => $request->phone,
    //         'gender' => $request->gender,
    //     ]);

    //     event(new Registered($user)); 

    //     return redirect()->route('verification.notice'); 
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'], 
            'gender' => $data['gender'], 
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
