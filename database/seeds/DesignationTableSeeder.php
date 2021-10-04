<?php

use Illuminate\Database\Seeder;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PromotionalDesignation::query()->forceCreate([
            'name' => 'New Member',
            'required_designation' => 2,
            'stage' => 21,
            'created_by' => \App\Models\User::first()->id
        ]);
    }
}
