<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Consoler extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'console_name',
        'contact_person',
        'contact_phone_number',
        'abn_number',
        'building',
        'city',
        'state',
        'country',
        'post_code',
        'latitude',
        'longitude',
        'your_agreement',
        'billing_commencement_period',
        'currency',
        'establishment_fee',
        'establishment_fee_date',
        'monthly_subscription_fee',
        'monthly_subscription_fee_date',
        'admin_fee',
        'admin_fee_date',
        'comm_charge',
        'comm_charge_date',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Automatically handle invoices when Consoler is created or updated.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate invoices when a new consoler is created
        static::created(function ($consoler) {
            $consoler->generateOrUpdateInvoice();
        });

        // Generate invoices when relevant fields are updated
        static::updated(function ($consoler) {
            if ($consoler->isDirty(['billing_commencement_period', 'establishment_fee', 'monthly_subscription_fee'])) {
                $consoler->generateOrUpdateInvoice();
            }
        });
    }

    /**
     * Generate or update invoices based on the consoler's details.
     */
    public function generateOrUpdateInvoice()
    {
        Log::info("Generating invoices for Consoler ID: {$this->id}");

        // Check if billing commencement period is set; if not, skip this consoler and continue
        if (!$this->billing_commencement_period) {
            Log::warning("Billing commencement period is not set for Consoler ID: {$this->id}. Skipping.");
            return; // Skip if no billing commencement period
        }

        // Get the first billing date
        $startDate = Carbon::parse($this->billing_commencement_period);
        $currentDate = Carbon::now();

        // Fetch the last invoice created for this consoler
        $lastInvoice = $this->invoices()->latest('date_created')->first();
        $lastDate = $lastInvoice ? Carbon::parse($lastInvoice->date_created) : $startDate;

        // Flag to track if the establishment fee is already applied
        $isFirstInvoice = !$lastInvoice;

        // Loop through 30-day intervals from lastDate to currentDate
        while ($lastDate->lte($currentDate)) {
            // Calculate the amount
            $amount = $isFirstInvoice
                ? $this->establishment_fee + $this->monthly_subscription_fee
                : $this->monthly_subscription_fee;

            // Create or update the invoice
            Invoice::firstOrCreate([
                'date_created' => $lastDate->toDateString(),
                'consoler_id' => $this->id,
            ], [
                'invoice_number' => 'wc-' . rand(190225, 999999) . '-' . rand(0, 9999),
                'consoler_name' => $this->console_name,
                'amount' => $amount,
                'status' => 'pending',
                'user_id' => $this->user_id,
            ]);

            // Set flag to false after the first invoice
            $isFirstInvoice = false;

            // Add 30 days for the next invoice
            $lastDate->addDays(30);
        }

        Log::info("Invoices generated for Consoler ID: {$this->id}");
    }

}
