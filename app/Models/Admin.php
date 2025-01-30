<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'contact_person',
        'contact_phone_number',
        'contact_email',
        'change_password',
        'terms_conditions_wc_partners',
        'terms_conditions_wc_consolers',
        'privacy_policy_for_all',
        'abn_number',
        'banking_detail',
        'master_agreement_for_wconsoler',
        'master_agreement_for_partners',
        'bsb_number',
    ];

    public function admin()
{
    return $this->hasOne(Admin::class);
}
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
