<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $courses = [
        "Course 1" => [
            "Gjeni portalin",
            "Labirintet",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
            "Sekuencat"
        ],
        "Course 2" => [
            "Renditja e veprimeve",
            "Imazhe",
        ],
        "Course 3" => [
            "Renditja e veprimeve",
            "Imazhe",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
        ],
        "Course 4" => [
            "Renditja e veprimeve",
            "Imazhe",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
            "Sekuencat"
        ],
    ];

    public function run()
    {
        foreach ($this->courses as $course_title => $course){
            $course_relation = Course::where('name', $course_title)->get()->first();
            foreach($course as $lesson){
                Lesson::create(['name' => $lesson, "course_id" => $course_relation->id]);
            }
        }
    }
}
