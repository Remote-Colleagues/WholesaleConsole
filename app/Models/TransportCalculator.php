<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportCalculator extends Model
{
    use HasFactory;

    protected $table = 'transport_calculator';

    protected $fillable = [
        'per_km_charge',
        'same_state_charge',
        'cross_state_charge',
        'additional_charges',
        'additional_charge_for_size',
        'body_type',
        'categories',
        'user_id', // Make sure to include the foreign key
    ];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
