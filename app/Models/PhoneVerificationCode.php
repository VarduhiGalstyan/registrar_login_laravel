<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneVerificationCode extends Model
{
    use HasFactory;

    // Եթե ցանկանում եք կատարել ներքին մուտքագրում և աշխատել առանց `timestamps`
    public $timestamps = false;

    // Ըստ անհրաժեշտության ֆիլտրում ենք այն դաշտերը, որոնք կարող են բեռնել
    protected $fillable = [
        'phone',
        'code',
        'expires_at',
    ];

    /**
     * Դիտարկելու համար հեռախոսահամարի վերիֆիկացիայի կոդի գործառույթները
     */
    public static function generateCode(string $phone)
    {
        // Ստեղծում ենք վериֆիկացիայի կոդը
        $code = rand(1000, 9999);  // Դրա համար պետք է վերիֆիկացիայի կոդը լինի 4 մաքուր թվեր
        
        // Հիմնվում ենք հիմա
        $expiresAt = now()->addMinutes(10); // Կոդը պահվում է 10 րոպե
        
        self::create([
            'phone' => $phone,
            'code' => $code,
            'expires_at' => $expiresAt,
        ]);

        return $code; // վերադարձնում ենք ստեղծված կոդը
    }
}
