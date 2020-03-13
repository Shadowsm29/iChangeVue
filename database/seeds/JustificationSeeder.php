<?php

use App\Justification;
use Illuminate\Database\Seeder;

class JustificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Justification::create([
            "name" => "Speed / Efficiency"
        ]);

        Justification::create([
            "name" => "Quality"
        ]);

        Justification::create([
            "name" => "Cost"
        ]);
    }
}
