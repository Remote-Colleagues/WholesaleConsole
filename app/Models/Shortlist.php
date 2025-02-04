<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortlist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'auction_id',
        'name',
        'make',
        'model',
        'build_date',
        'odometer',
        'body_type',
        'fuel',
        'transmission',
        'seats',
        'auctioneer',
        'link_to_auction',
        'other_specs',
        'unique_identifier',
        'state',
        'vin',
        'hours',
        'deadline',
    ];


    /**
     * Get the user that owns the shortlist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the auction that is shortlisted.
     */
    public function auction()
    {
        return $this->belongsTo(Auctions::class);
    }
}
