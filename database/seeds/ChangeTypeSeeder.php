<?php

use App\ChangeType;
use Illuminate\Database\Seeder;

class ChangeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChangeType::create([
            "name" => "Just Do It"
        ]);

        ChangeType::create([
            "name" => "Business and Organizational"
        ]);

        ChangeType::create([
            "name" => "RPA / IT / COSMOS"
        ]);
    }
}
