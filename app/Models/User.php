<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'status',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    /**
     * Check if the user is a partner.
     *
     * @return bool
     */
    public function isPartner()
    {
        return $this->user_type === 'partner';
    }

    /**
     * Check if the user is a consoler.
     *
     * @return bool
     */
    public function isConsoler()
    {
        return $this->user_type === 'consoler';
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
public function consoler()
{
    return $this->hasOne(Consoler::class);
}
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function shortlists()
    {
        return $this->hasMany(Shortlist::class);
    }
    public function partner()
    {
        return $this->hasOne(Partner::class);
    }
    public function transportCalculators()
    {
        return $this->hasMany(TransportCalculator::class);
    }
}
