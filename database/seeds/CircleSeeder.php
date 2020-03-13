<?php

use App\Circle;
use App\SuperCircle;
use Illuminate\Database\Seeder;

class CircleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sc1 = SuperCircle::create([
            "name" => "Super Circle 1"
        ]);

        $sc2 = SuperCircle::create([
            "name" => "Super Circle 2"
        ]);

        $sc3 = SuperCircle::create([
            "name" => "Super Circle 3"
        ]);

        Circle::create([
            "name" => "Circle 1",
            "super_circle_id" => $sc1->id
        ]);

        Circle::create([
            "name" => "Circle 2",
            "super_circle_id" => $sc1->id
        ]);

        Circle::create([
            "name" => "Circle 3",
            "super_circle_id" => $sc2->id
        ]);

        Circle::create([
            "name" => "Circle 4",
            "super_circle_id" => $sc2->id
        ]);

        Circle::create([
            "name" => "Circle 5",
            "super_circle_id" => $sc3->id
        ]);

        Circle::create([
            "name" => "Circle 6",
            "super_circle_id" => $sc3->id
        ]);
    }
}
