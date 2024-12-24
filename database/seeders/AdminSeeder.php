<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::firstOrCreate(
            ['contact_email' => 'pashupatisah3@gmail.com'],
            [
                'name' => 'Pashupati Sah',
                'contact_person' => 9813318109,
                'contact_phone_number' => 9813318109,
                'contact_email' => 'pashupatisah35@gmail.com',
                'change_password' => Hash::make('123456789'),
                'terms_conditions_wc_partners' => 'this is WC partner__',
                'terms_conditions_wc_consolers' => 'this is partner__',
                'privacy_policy_for_all' => 'privacy policy__',
                'abn_number' => 123456,
                'banking_detail' => 'NIC Asia',
            ]
        );
    }
}
