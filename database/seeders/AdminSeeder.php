<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::firstOrCreate(
            ['email' => 'pashupati@gmail.com'],
            [
                'name' => 'Pashupati Sah',
                'password' => bcrypt('123456789'),
                'user_type' => 'admin',
            ]
        );

        Admin::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'name' => 'Pashupati Sah',
                'contact_person' => '9813318109',
                'contact_phone_number' => '9813318109',
                'terms_conditions_wc_partners' => 'this is WC partner__',
                'terms_conditions_wc_consolers' => 'this is partner__',
                'privacy_policy_for_all' => 'privacy policy__',
                'abn_number' => '123456',
                'banking_detail' => 'NIC Asia',
                'master_agreement_for_wconsoler' => 'This is the master agreement for WConsoler__',
                'master_agreement_for_partners' => 'This is the master agreement for Partners__',
                'bsb_number' => '987654',
            ]
        );
    }
}
