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
        "Renditja e veprimeve" => [
            "Renditja e veprimeve",
            "Imazhe",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
            "Sekuencat"
        ],
        "Imazhet" => [
            "Renditja e veprimeve",
            "Imazhe",
        ],
        "Ngjarjet" => [
            "Renditja e veprimeve",
            "Imazhe",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
        ],
        "Ciklet" => [
            "Renditja e veprimeve",
            "Imazhe",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
            "Sekuencat"
        ],
        "Kushtet" => [
            "Renditja e veprimeve",
            "Imazhe",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
            "Sekuencat",
            "Imazhe",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
            "Sekuencat"
        ],
        "Funksione" => [
            "Renditja e veprimeve",
            "Imazhe",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
        ],
        "Variablat" => [
            "Renditja e veprimeve",
            "Imazhe",
            "Jigsaw: Mësoni të tërhiqni dhe të lëshoni",
            "Sekuencat"
        ],
        "Ciklet të avancuara" => [
            "Renditja e veprimeve",
            "Imazhe"
        ],
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
