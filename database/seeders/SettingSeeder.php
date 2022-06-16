<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('global_settings')->insert([
            'site_name' => 'Amalorpavam Food Ordering System',
            'site_email' => 'test@mail.com',
            'site_mobile_no' => '0987654321',
            'enable_mail' => 0,
            'enable_sms' => 0,
            'payment_mode' => 'test',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
