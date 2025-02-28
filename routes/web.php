<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\PhoneVerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\AdminController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/', 'App\Http\Controllers\StripeController@index')->name('index');// stripe
Route::post('/checkout', 'App\Http\Controllers\StripeController@checkout')->name('checkout');// stripe
Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');// stripe



Auth::routes(); //SMS //Coll
// Auth::routes(['verify' => true]); //email verifiatim

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');//SMS //Coll

// email verifiatim
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('home');


Route::get('/verify-phone', function () {
    return view('auth.verify');
})->name('verify-phone');

Route::post('/verify-phone', function (Request $request) {
    $verification = PhoneVerificationCode::where('phone', $request->phone)
        ->where('code', $request->code)
        ->where('expires_at', '>', now())
        ->first();

    if (!$verification) {
        return back()->withErrors(['code' => 'Invalid or expired verification code']);
    }

    $user = User::where('phone', $request->phone)->first();
    if (!$user) {
        $user = User::create([
            'name' => session('name'),
            'email' => session('email'),
            'password' => Hash::make(session('password')),
            'phone' => $request->phone,
            'gender' => session('gender'),
        ]);
    }

    auth()->login($user);

    return redirect('/home');
});

// admin middleware
Route::middleware([ 'admin'])->group(function () {
    Route::get('/admin-page', [AdminController::class, 'index'])->name('admin.page');
});
