<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            "title" => Status::LINE_MAN_APPR,
        ]);

        Status::create([
            "title" => Status::REJECTED,
        ]);

        Status::create([
            "title" => Status::WIP,
        ]);

        Status::create([
            "title" => Status::CORR_NEEDED,
        ]);

        Status::create([
            "title" => Status::HEAD_APPR,
        ]);

        Status::create([
            "title" => Status::SUPPORT_TEAM_ASSESSMENT,
        ]);

        Status::create([
            "title" => Status::MT_APPROVAL,
        ]);

        Status::create([
            "title" => Status::CHG_BOARD_PRIORIT,
        ]);

        Status::create([
            "title" => Status::REWORK_NEEDED,
        ]);

        Status::create([
            "title" => Status::IMPLEMENTED,
        ]);
    }
}
