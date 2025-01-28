<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date_created',
        'invoice_number',
        'consoler_name',
        'amount',
        'status',
        'consoler_id',
        'user_id',
    ];

    /**
     * The relationships to the Consoler and User models.
     */
    public function consoler()
    {
        return $this->belongsTo(Consoler::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
