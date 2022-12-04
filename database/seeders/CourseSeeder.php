<?php

namespace Database\Seeders;

use App\Models\course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $courses = [
        "Lëndë 1" => [
            "description" => "Hyrje në shkencën kompjuterike për lexuesit e hershëm"
        ],
        "Lëndë 2" => [
            "description" => "Hyrje në shkenca kompjuterike për studentët që dinë të lexojnë"
        ],
        "Lëndë 3" => [
            "description" => "Zhytuni edhe më thellë në programim ndërsa ndërtoni lojëra dhe histori interaktive"
        ],
        "Lëndë 4" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"'
        ],
    ];

    public function run()
    {
        foreach ($this->courses as $course_title => $course){
            course::create(['name' => $course_title, "description" => $course["description"]]);
        }
    }
}
