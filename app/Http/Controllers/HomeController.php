<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user(); // Ստանում ենք մուտք գործած օգտատիրոջը
        
        if (!$user) {
            return redirect('/login')->withErrors('You need to log in first.');
        }

        return view('home', compact('user')); // Ուղարկում ենք `user` փոփոխականը `home` էջին
    }
}
