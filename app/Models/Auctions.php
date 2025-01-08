<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Auctions extends Model
{
    use HasFactory;
    protected $table = 'auctions';
    protected $fillable = [
        'name', 'make', 'model', 'build_date', 'odometer', 'body_type', 'fuel',
        'transmission', 'seats', 'auctioneer', 'deadline', 'link_to_auction',
        'link_to_condition_report', 'other_specs', 'unique_identifier', 'hours',
        'state', 'redbook_code', 'redbook_average_wholesale', 'current_market_retail',
        'auction_registration_link', 'vin', 'date_listed', 'name_of_auction'
    ];

    public static function totalcount()
    {
        return self::count();
    }
}
