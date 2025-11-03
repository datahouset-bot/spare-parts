<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappSms extends Model
{
    
    protected $fillable = [
        'firm_id',
        'transection_type',
        'wp_message',
        'text_message',
        'wp_active',
        'sms_active',
        'sms_template_id',
        'af1',
        'af2',
        'af3',
        'af4',
        'af5',
        'af6',
        'af7',
        'af8',
        'af9',
        'af10',
    ];
    use HasFactory;
}
