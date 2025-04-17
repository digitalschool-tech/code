<?php

namespace App\Helpers;

class CourseStyleHelper
{
    /**
     * Get course styling based on course ID or name
     *
     * @param int $courseId
     * @param string|null $courseName
     * @return array
     */
    public static function getCourseStyle(int $courseId, ?string $courseName = null): array
    {
        $styles = [
            1 => [
                'bg' => 'bg-[#00417A]',
                'border' => 'border-[#00417A]',
                'text' => 'text-[#00A0FF]',
                'icon' => 'shadows.png',
                'outline' => 'shadows-outline',
                'hex' => '#00417A',
                'rgb' => '0, 65, 122',
                'house' => 'shadow'
            ],
            2 => [
                'bg' => 'bg-[#124C00]',
                'border' => 'border-[#124C00]',
                'text' => 'text-[#7BFF00]',
                'icon' => 'engineer.png',
                'outline' => 'engineers-outline',
                'hex' => '#124C00',
                'rgb' => '18, 76, 0',
                'house' => 'engineer'
            ],
            3 => [
                'bg' => 'bg-[#3A005A]',
                'border' => 'border-[#3A005A]',
                'text' => 'text-[#A034D9]',
                'icon' => 'hipsters.png',
                'outline' => 'hipsters-outline',
                'hex' => '#3A005A',
                'rgb' => '58, 0, 90',
                'house' => 'hipster'
            ],
            4 => [
                'bg' => 'bg-[#7A0025]',
                'border' => 'border-[#7A0025]',
                'text' => 'text-[#FF5252]',
                'icon' => 'speedsters.png',
                'outline' => 'speedsters-outline',
                'hex' => '#7A0025',
                'rgb' => '122, 0, 37',
                'house' => 'speedster'
            ],
        ];

        // Use name-based matching if available
        if ($courseName) {
            if (stripos($courseName, 'hipster') !== false) {
                return $styles[3];
            } elseif (stripos($courseName, 'speed') !== false) {
                return $styles[4];
            } elseif (stripos($courseName, 'engin') !== false) {
                return $styles[2];
            } elseif (stripos($courseName, 'shadow') !== false) {
                return $styles[1];
            }
        }

        // Default: Use ID with modulo
        $colorIndex = ($courseId % 4) ?: 4;
        return $styles[$colorIndex];
    }

    /**
     * Get house styling based on house name
     *
     * @param string $house
     * @return array
     */
    public static function getHouseStyle(string $house): array
    {
        $styles = [
            'engineer' => [
                'bg' => 'bg-[#124C00]',
                'text' => 'text-[#7BFF00]',
                'border' => 'border-[#124C00]',
                'icon' => 'engineer.png',
                'title' => 'Engineer House Courses',
                'desc' => 'Focus on building robust solutions and strong technical foundations',
                'hex' => '#124C00',
            ],
            'speedster' => [
                'bg' => 'bg-[#7A0025]',
                'text' => 'text-[#FF5252]',
                'border' => 'border-[#7A0025]',
                'icon' => 'speedsters.png',
                'title' => 'Speedster House Courses',
                'desc' => 'Accelerated learning paths for fast and efficient coders',
                'hex' => '#7A0025',
            ],
            'hipster' => [
                'bg' => 'bg-[#3A005A]',
                'text' => 'text-[#A034D9]',
                'border' => 'border-[#3A005A]',
                'icon' => 'hipsters.png',
                'title' => 'Hipster House Courses',
                'desc' => 'Creative approaches to coding and innovative solutions',
                'hex' => '#3A005A',
            ],
            'shadow' => [
                'bg' => 'bg-[#00417A]',
                'text' => 'text-[#00A0FF]',
                'border' => 'border-[#00417A]',
                'icon' => 'shadows.png',
                'title' => 'Shadow House Courses',
                'desc' => 'Deep dives into complex problems and algorithmic thinking',
                'hex' => '#00417A',
            ]
        ];

        return $styles[$house] ?? $styles['engineer'];
    }
} 