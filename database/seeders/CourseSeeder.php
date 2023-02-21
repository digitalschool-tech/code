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
        "Renditja e veprimeve" => [
            "description" => "Hyrje në shkencën kompjuterike për lexuesit e hershëm"
        ],
        "Imazhet" => [
            "description" => "Hyrje në shkenca kompjuterike për studentët që dinë të lexojnë"
        ],
        "Ngjarjet" => [
            "description" => "Zhytuni edhe më thellë në programim ndërsa ndërtoni lojëra dhe histori interaktive"
        ],
        "Ciklet" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"'
        ],
        "Kushtet" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"'
        ],
        "Funksione" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"'
        ],
        "Variablat" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"'
        ],
        "Ciklet të avancuara" => [
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
