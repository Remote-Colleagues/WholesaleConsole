<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Auctions extends Model
{
    use HasFactory;
    protected $table = 'auctions';protected $fillable = [
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
    ];
    

    public static function totalcount()
    {
        return self::count();
    }
}
