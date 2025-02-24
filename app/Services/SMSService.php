<?php

namespace App\Services;

use Twilio\Rest\Client;

// SMS
// class SMSService
// {
//     protected $twilio;

//     public function __construct()
//     {
//         $this->twilio = new Client(
//             config('services.twilio.sid'),
//             config('services.twilio.token')
//         );
//     }

//     public function sendVerificationCode($phone, $code)
//     {
//         return $this->twilio->messages->create(
//             $phone,
//             [
//                 'from' => config('services.twilio.phone_number'),
//                 'body' => "Your verification code is: $code",
//             ]
//         );
//     }
// }
// COLL
class SMSService
{
    protected $client;
    protected $twilioNumber;

    public function __construct()
    {
        $this->client = new Client(config('services.twilio.sid'), config('services.twilio.token'));
        $this->twilioNumber = config('services.twilio.phone_number'); // Twilio phone number
    }

    // Զանգի ուղարկման մեթոդը (coll-ի վերջում $code-ի 4թվերը ասում է)
    public function sendVerificationCall($phone, $code)
    {
        $twiml = "<Response><Say>Your verification code is $code. Please enter it to verify your phone number.</Say></Response>";

        $this->client->calls->create(
            $phone,               
            $this->twilioNumber,  
            ['twiml' => $twiml]    
        );
    }
}