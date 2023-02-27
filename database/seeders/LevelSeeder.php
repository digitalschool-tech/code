<?php

namespace Database\Seeders;

use App\Models\lesson;
use Illuminate\Database\Seeder;
use App\Models\level;
use Illuminate\Support\Facades\Storage;
class LevelSeeder extends Seeder
{
    private $lessons = [
        "Gjeni portalin" => [
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
        ],
        "Labirintet" => [
            [
                "player" => [2, 4],
                "goal" => [5, 4],
                "route" => [
                    [3, 4], [4, 4], [2, 5], [3, 7], [1, 6], [3, 2], [3, 2], [6, 2],
                ],
                "blocks" => [
                    "loop_1",
                    "math_1"
                ],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [5, 4],
                "goal" => [3, 2],
                "route" => [[2,4], [3,4], [4,4], [3, 3], [3, 1]],
                "blocks" => [],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [1,5],
                "goal" => [2,4],
                "route" => [[1,5],[2,5],[3,5],[4,5],[5,5],[2,4],[2,3]],
                "blocks" => [
                    "loop_1",
                    "math_1"
                ],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [4, 3],
                "goal" => [2, 4],
                "route" => [[3,2],[3,3],[3,4],[3,5],[3,6],[4,3],[2,4],[0,4],[4,5],[5,5],[5,6]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [2, 3],
                "goal" => [6, 5],
                "route" => [[7,0],[7,1],[7,2],[7,3],[6,1],[6,2],[6,3],[2,2],[3,2],[4,2],[4,2],[3,2],[2,2],[2,3],[3,3],[4,3],[2,2],[2,2],[4,4],[4,5],[4,6],[0,7],[1,7],[2,7],[3,7],[1,6],[2,6],[3,6],[2,5],[3,5],[5,5],[6,5],[6,6],[6,7],[7,7],[7,6],[7,5]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [2, 4],
                "goal" => [5, 4],
                "route" => [[0,7],[0,6],[0,5],[0,4],[1,4],[1,5],[1,6],[1,7],[2,7],[3,7],[3,6],[2,6],[2,5],[3,5],[3,4],[2,4],[3,3],[4,3],[5,3],[5,4],[5,5],[6,6],[7,7],[6,2],[7,2],[6,3],[7,3],[6,4],[7,4],[6,5],[7,5],[7,6]],
                "blocks" => [
                    "loop_1",
                    "math_1"
                ],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [6, 2],
                "goal" => [7, 7],
                "route" => [[5,2],[4,2],[4,3],[4,4],[5,4],[5,5],[6,6],[5,6],[6,7],[7,7],[7,6]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],            [
                "player" => [6, 3],
                "goal" => [3, 3],
                "route" => [[1,1],[2,1],[3,1],[1,2],[1,3],[1,4],[2,4],[2,3],[2,2],[3,2],[3,3],[3,4],[3,5],[4,5],[5,5],[5,4],[5,3],[5,6],[5,7],[6,7]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ],
            [
                "player" => [5, 4],
                "goal" => [2, 3],
                "route" => [[4,0],[4,2],[4,3],[4,4],[5,4],[3,4],[3,5],[3,6],[2,4],[2,3],[2,2],[0,4],[6,5],[7,5],[7,6]],
                "description" => "Për këtë enigmë, tërhiqni të gjitha blloqet së bashku dhe klikoni 'Run' për ta parë atë të shkojë!"
            ]
        ],

    ];

    public function run()
    {
        foreach ($this->lessons as $lesson_title => $lesson){
            $lesson_relation = lesson::where('name', $lesson_title)->get()->first();
            foreach($lesson as $index => $level){
                level::create([
                    "index" => $index + 1,
                    "lesson_id" => $lesson_relation->id,
                    "description" => $level["description"],
                    "player" => json_encode($level["player"]),
                    "goal" => json_encode($level["goal"]),
                    "route" => json_encode($level["route"] ?? []),
                    "blocks" => json_encode($level["blocks"] ?? [])
                ]);
            }
        }
    }
}
