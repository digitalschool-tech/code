<?php

namespace Database\Seeders;

use App\Models\lesson;
use Illuminate\Database\Seeder;
use App\Models\level;
use Illuminate\Support\Facades\Storage;
class LevelSeeder extends Seeder
{
    private $lessons = [
        "Hartat e lumtura" => [
            [
                "player" => [3, 4],
                "goal" => [5, 4],
                "route" => [[4,4]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [2, 5],
                "goal" => [5, 5],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [4, 6],
                "goal" => [5, 4],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [3, 4],
                "goal" => [5, 5],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [5, 6],
                "goal" => [3, 4],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [5, 6],
                "goal" => [3, 4],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [3, 2],
                "goal" => [5, 6],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [5, 7],
                "goal" => [5, 3],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [2, 2],
                "goal" => [8, 5],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [2, 2],
                "goal" => [5, 5],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [6, 3],
                "goal" => [6, 5],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ]
        ]
    ];

    public function run()
    {
        foreach ($this->lessons as $lesson_title => $lesson){
            $lesson_relation = lesson::where('name', $lesson_title)->get()->first();
            foreach($lesson as $level){
                level::create([
                    "lesson_id" => $lesson_relation->id,
                    "description" => $level["description"],
                    "player" => json_encode($level["player"]),
                    "goal" => json_encode($level["goal"]),
                    "route" => json_encode($level["route"] ?? [])
                ]);
            }
        }
    }
}
