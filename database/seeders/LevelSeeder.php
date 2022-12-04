<?php

namespace Database\Seeders;

use App\Models\lesson;
use Illuminate\Database\Seeder;
use App\Models\level;

class LevelSeeder extends Seeder
{
    private $lessons = [
        "Hartat e lumtura" => [
            "1",
        ]
    ];

    public function run()
    {
        foreach ($this->lessons as $lesson_title => $lesson){
            $lesson_relation = lesson::where('name', $lesson_title)->get()->first();
            foreach($lesson as $level){
                level::create(["lesson_id" => $lesson_relation->id]);
            }
        }
    }
}
