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
            "description" => "Hyrje në shkencën kompjuterike për lexuesit e hershëm",
            "group" => 1
        ],
        "Imazhet" => [
            "description" => "Hyrje në shkenca kompjuterike për studentët që dinë të lexojnë",
            "group" => 1
        ],
        "Ngjarjet" => [
            "description" => "Zhytuni edhe më thellë në programim ndërsa ndërtoni lojëra dhe histori interaktive",
            "group" => 1
        ],
        "Ciklet" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 1
        ],
        "Kushtet" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 1
        ],
        "Funksione" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 1
        ],
        "Variablat" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 1
        ],
        "Ciklet të avancuara" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 1
        ],
        "Variablat" => [
            "description" => "Hyrje në shkencën kompjuterike për lexuesit e hershëm",
            "group" => 2
        ],
        "Operatorët e Krahasimit" => [
            "description" => "Hyrje në shkenca kompjuterike për studentët që dinë të lexojnë",
            "group" => 2
        ],
        "Operatorët Logjikë" => [
            "description" => "Zhytuni edhe më thellë në programim ndërsa ndërtoni lojëra dhe histori interaktive",
            "group" => 2
        ],
        "Booleans" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 2
        ],
        "Kushtet" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 2
        ],
        "Llojet e Ciklev" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 2
        ],
        "Funksionet" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 2
        ],
        "Funksionet e integruara" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 2
        ],
        "Kthehimet, nderprerjet dhe vazhdimet" => [
            "description" => 'Ndërtoni programe më komplekse me koncepte si "për sythe" dhe "funksione me parametra"',
            "group" => 2
        ],
    ];

    public function run()
    {
        foreach ($this->courses as $course_title => $course){
            course::create([
                "name" => $course_title,
                "description" => $course["description"],
                "group" => $course["group"]
            ]);
        }
    }
}
