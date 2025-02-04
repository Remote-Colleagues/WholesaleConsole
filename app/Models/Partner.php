<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Partner extends Model
{
    use HasFactory;
    protected $table = 'partners';
    protected $fillable = [
        'partner_name',
        'contact_person',
        'contact_phone_number',
        'your_agreement',
        'abn_number',
        'operation_location',
        'latitude',
        'longitude',
        'billing_commencement_date',
        'premium_charged',
        'establishment_fee',
        'monthly_subscription_fee',
        'csvusernumber',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    protected static function boot()
    {
        parent::boot();

        // Generate invoices when a new partner is created
        static::created(function ($partner) {
            $partner->generateOrUpdateInvoice();
        });

        // Generate invoices when relevant fields are updated
        static::updated(function ($partner) {
            if ($partner->isDirty(['billing_commencement_date', 'establishment_fee', 'monthly_subscription_fee'])) {
                $partner->generateOrUpdateInvoice();
            }
        });
    }

    /**
     * Generate or update invoices based on the partner's details.
     */
    public function generateOrUpdateInvoice()
    {
        Log::info("Generating invoices for Partner ID: {$this->id}");

        if (!$this->billing_commencement_date) {
            Log::warning("Billing commencement date is not set for Partner ID: {$this->id}. Skipping.");
            return;
        }

        $startDate = Carbon::parse($this->billing_commencement_date);
        $currentDate = Carbon::now();
        $lastInvoice = $this->invoices()->latest('date_created')->first();
        $lastDate = $lastInvoice ? Carbon::parse($lastInvoice->date_created) : $startDate;
        $isFirstInvoice = !$lastInvoice;

        Log::info("Last invoice date: " . ($lastInvoice ? $lastInvoice->date_created : 'None'));

        while ($lastDate->lte($currentDate)) {
            $amount = $isFirstInvoice
                ? $this->establishment_fee + $this->monthly_subscription_fee // First invoice includes establishment fee
                : $this->monthly_subscription_fee; // Subsequent invoices

            Log::info("Generating invoice for date: {$lastDate->toDateString()}, Amount: {$amount}");

            Invoice::firstOrCreate(
                [
                    'date_created' => $lastDate->toDateString(),
                    'partner_id' => $this->id, // Ensure partner_id is set correctly
                ],
                [
                    'invoice_number' => 'wc-' . rand(190225, 999999) . '-' . rand(0, 9999),
                    'consoler_name' => $this->partner_name,
                    'amount' => $amount,
                    'status' => 'pending',
                    'user_id' => $this->user_id,
                ]
            );

            $isFirstInvoice = false;
            $lastDate->addMonth();
        }

        Log::info("Invoices generated for Partner ID: {$this->id}");
    }

}
