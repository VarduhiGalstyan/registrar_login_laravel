<?php

namespace App\Services;

use Twilio\Rest\Client;

class SMSService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function sendVerificationCode($phone, $code)
    {
        return $this->twilio->messages->create(
            $phone,
            [
                'from' => config('services.twilio.phone_number'),
                'body' => "Your verification code is: $code",
            ]
        );
    }
}
