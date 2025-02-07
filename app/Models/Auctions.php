<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auctions extends Model
{
    use HasFactory;
    protected $table = 'auctions';
    protected $fillable = [
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


    public static function totalcount()
    {
        return self::count();
    }
    protected $casts = [
        'hours' => 'integer',
    ];
    public function scopeFilter($query, $filters)
    {
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query->where($key, $value);
            }
        }
        return $query;
    }
    // public function getDeadlineAttribute()
    // {
    //     if (!$this->updated_at || !$this->hours) {
    //         return null;
    //     }
    
    //     // Calculate the deadline
    //     $updatedAt = Carbon::parse($this->updated_at);
    //     $deadline = $updatedAt->addHours($this->hours);
    
    //     return $deadline->format('y/m/d H:i:s'); // Format as YY/MM/DD HH:MM:SS
    // }
        /**
     * Boot method to calculate deadline during create/update
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($auction) {
            $auction->calculateDeadline();
        });

        static::updating(function ($auction) {
            $auction->calculateDeadline();
        });
    }

    /**
     * Calculate and set the deadline based on hours and updated_at
     */
    public function calculateDeadline()
    {
        if ($this->hours) {
            $this->deadline = $this->updated_at
                ? Carbon::parse($this->updated_at)->addHours($this->hours)
                : now()->addHours($this->hours);
        } else {
            $this->deadline = null; // No hours, set deadline as null
        }
    }

 
    public function getDeadlineAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('Y/m/d H:i:s');
        }
    
        return null;
    }
    



}
