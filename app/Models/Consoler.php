<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consoler extends Model
{
    use HasFactory;

    protected $fillable = [
        'wc_consolers_name',
        'contact_person',
        'contact_phone_number',
        'contact_email',
        'password',
        'your_agreement',
        'abn_number',
        'operational_location',
        'comm_charge_for_buyers_connect',
        'last_changed_comm_charge_for_buyers_connect',
        'billing_commencement_period',
        'last_changed_billing_commencement_period',
        'admin_fee_for_buyers_connect',
        'establishment_fee',
        'last_changed_establishment_fee',
        'ongoing_monthly_subs_fee',
        'last_changed_ongoing_monthly_subs_fee',
    ];

    protected $casts = [
        'your_agreement' => 'boolean',
        'last_changed_comm_charge_for_buyers_connect' => 'datetime',
        'last_changed_billing_commencement_period' => 'datetime',
        'last_changed_establishment_fee' => 'datetime',
        'last_changed_ongoing_monthly_subs_fee' => 'datetime',
    ];
}
