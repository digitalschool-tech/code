<?php

namespace Database\Seeders;

use App\Models\course;
use App\Models\lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $courses = [
        "Lëndë 1" => [
            "Hartat e lumtura",
            "Lëvize, lëvize",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
            "Sekuencat",
            "Korrigjimet",
            "Algoritmet në përditshmëri: Mbillni një farë",
            "Bleta: Sekuenca",
            "Artisti: Sekuenca",
            "Ndërtimi i një fondacioni",
            "Artisti: Format",
            "Drejtshkrim",
            "Getting Loopy",
            "Maze: Loops",
            "Bee: Loops",
            "The Big Event",
            "Play Lab: Create a Story",
            "Going Places Safely",
            "Artist: Loops"
        ]
    ];

    public function run()
    {
        foreach ($this->courses as $course_title => $course){
            $course_relation = course::where('name', $course_title)->get()->first();
            foreach($course as $lesson){
                lesson::create(['name' => $lesson, "course_id" => $course_relation->id]);
            }
        }
    }
}
