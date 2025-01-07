<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consoler extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'console_name',
        'contact_person',
        'contact_phone_number',
        'abn_number',
        'building',
        'city',
        'state',
        'country',
        'post_code',
        'your_agreement',
        'billing_commencement_period',
        'currency',
        'establishment_fee',
        'establishment_fee_date',
        'monthly_subscription_fee',
        'monthly_subscription_fee_date',
        'admin_fee',
        'admin_fee_date',
        'comm_charge',
        'comm_charge_date',
    ];
}
