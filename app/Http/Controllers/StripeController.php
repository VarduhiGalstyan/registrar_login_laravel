<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class StripeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function checkout()
    {
        
        Stripe::setApiKey(config('stripe.sk'));

        $session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => 'Send me mony!!!',
                        ],
                        'unit_amount' => 500,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('index'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        return view('success');
    }
}
