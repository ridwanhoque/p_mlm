<?php

use App\Models\DeliveryMode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DeliveryModeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['Hand', 'Courier Delivery'] as $mode){
            DeliveryMode::query()->forceCreate([
                'name' => $mode,
                'type' => Str::slug($mode)
            ]);
        }
    }
}
