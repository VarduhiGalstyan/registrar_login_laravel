<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneVerificationCode extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'phone',
        'code',
        'expires_at',
    ];

    public static function generateCode(string $phone)
    {
        $code = rand(1000, 9999);  
        
        $expiresAt = now()->addMinutes(10); 
        
        self::create([
            'phone' => $phone,
            'code' => $code,
            'expires_at' => $expiresAt,
        ]);

        return $code; 
    }
}
