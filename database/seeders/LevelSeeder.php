<?php

namespace Database\Seeders;

use App\Models\lesson;
use Illuminate\Database\Seeder;
use App\Models\level;
use Illuminate\Support\Facades\Storage;
class LevelSeeder extends Seeder
{
    private $lessons = [
        "Renditja e veprimeve" => [
            [
                "player" => [3, 4],
                "goal" => [5, 4],
                "route" => [[4,4]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [1, 4],
                "goal" => [4, 4],
                "route" => [[2,4],[3,4]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [3, 5],
                "goal" => [4, 3],
                "route" => [[4,5],[4,4]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [2, 3],
                "goal" => [4, 4],
                "route" => [[3,3],[3,4]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [4, 5],
                "goal" => [2, 3],
                "route" => [[4,4], [4,3], [3,3]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [2, 3],
                "goal" => [5, 3],
                "route" => [[2,2], [3,2], [4,2], [5,2], [2,4], [3,4], [4,4], [5,4]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [2, 1],
                "goal" => [4, 5],
                "route" => [[3,1], [4,1], [4,2], [5,2], [5,4], [5,3], [5,5]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [4, 6],
                "goal" => [4, 2],
                "route" => [[3, 2], [3, 3], [3, 4], [3, 5], [3, 6]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [4, 6],
                "goal" => [5, 3],
                "route" => [[3, 2], [3, 3], [3, 4], [3, 5], [3, 6], [5, 2], [5, 3], [5, 4], [5, 5], [5, 6], [4, 2]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [1, 1],
                "goal" => [7, 4],
                "route" => [
                    [2, 1], [3, 1], [4, 1], [6, 1],
                    [1, 2], [2, 2], [4, 2], [5, 2], [6, 2],
                    [1, 3], [2, 3], [3, 3], [4, 3], [5, 3], [6, 3],
                    [2, 4], [3, 4], [4, 4], [5, 4], [6, 4],
                    [1, 5], [2, 5], [3, 5], [4, 5], [5, 5], [6, 5],
                    [1, 6], [3, 6], [4, 6], [5, 6],
                ],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [1, 1],
                "goal" => [4, 4],
                "route" => [
                    [2, 1], [3, 1], [4, 1], [6, 1],
                    [1, 2], [2, 2], [4, 2], [5, 2], [6, 2],
                    [2, 3], [6, 3],
                    [2, 4], [4, 4], [5, 4], [6, 4], [7, 4],
                    [1, 5], [2, 5], [4, 5], [5, 5], [6, 5],
                    [1, 6], [2, 6], [3, 6], [4, 6], [5, 6],
                ],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [5, 2],
                "goal" => [5, 4],
                "route" => [
                    [1, 1], [2, 1], [3, 1], [4, 1], [5, 1], [6, 1], [7, 1],
                    [1, 2], [2, 2], [3, 2], [4, 2], [6, 2], [7, 2],
                    [1, 3], [7, 3],
                    [1, 4], [2, 4], [3, 4], [4, 4], [6, 4], [7, 4],
                    [1, 5], [2, 5], [3, 5], [4, 5], [5, 5], [6, 5], [7, 5],
                    [1, 6], [2, 6], [3, 6], [4, 6], [5, 6], [6, 6], [7, 6],
                ],
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
