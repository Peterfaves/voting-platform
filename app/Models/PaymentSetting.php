<?php

// app/Models/PaymentSetting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'provider', 'public_key', 'secret_key', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $hidden = ['secret_key'];
}