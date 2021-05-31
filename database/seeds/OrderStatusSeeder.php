<?php

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
            'alias' => 'new',
            'name' => 'Новый',
            'default' => true
        ]);

        OrderStatus::create([
            'alias' => 'in_progress',
            'name' => 'В обработке'
        ]);

        OrderStatus::create([
            'alias' => 'end',
            'name' => 'Завершен'
        ]);
    }
}
