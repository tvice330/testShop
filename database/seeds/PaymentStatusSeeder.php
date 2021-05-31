<?php

use App\Models\PaymentStatus;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentStatus::create([
            'alias' => 'buy',
            'name' => 'Оплачен'
        ]);

        PaymentStatus::create([
            'alias' => 'no_buy',
            'name' => 'Не оплачен',
            'default' => true
        ]);
    }
}
