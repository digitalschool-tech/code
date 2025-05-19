<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Level;
use Illuminate\Support\Str; // Import Str

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Level::truncate();
        Lesson::truncate();
        Course::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $jsonPath = base_path('structured_courses_data.json'); // Adjust path if needed

        if (!File::exists($jsonPath)) {
            $this->command->error('JSON data file not found: ' . $jsonPath);
            return;
        }

        $jsonData = File::get($jsonPath);
        $coursesData = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Error decoding JSON: ' . json_last_error_msg());
            return;
        }

        if (empty($coursesData)) {
            $this->command->info('No course data found in JSON file.');
            return;
        }

        foreach ($coursesData as $courseData) {
            try {
                $course = Course::create([
                    'name' => $courseData['name'],
                    'description' => $courseData['description'] ?? '',
                    // Generate a slug, ensure it's unique if necessary
                    'slug' => Str::slug($courseData['name']),
                    // 'image' => null, // Add image path if available
                ]);

                if (empty($courseData['lessons'])) {
                     $this->command->warn("No lessons found for course: {$courseData['name']}");
                     continue;
                }

                $lessonOrder = 1;
                foreach ($courseData['lessons'] as $lessonData) {
                    $lesson = $course->lessons()->create([
                        'name' => $lessonData['name'],
                        'description' => $lessonData['description'] ?? '',
                        'order' => $lessonOrder++,
                    ]);

                    if (empty($lessonData['levels'])) {
                         $this->command->warn("No levels found for lesson: {$lessonData['name']} in course: {$courseData['name']}");
                        continue;
                    }

                    foreach ($lessonData['levels'] as $levelData) {
                        // Basic cleaning for index, ensure it's numeric or handle gracefully
                        $index = filter_var($levelData['index'], FILTER_SANITIZE_NUMBER_INT);
                        if ($index === false || $index === '') {
                            $this->command->warn("Invalid index '{$levelData['index']}' for level '{$levelData['name']}'. Setting to 0.");
                            $index = 0; // Default or skip
                        }


                        $lesson->levels()->create([
                            'name' => $levelData['name'], // e.g., "Stage 1"
                            'description' => $levelData['description'], // Mapped from Goal
                            'index' => (int)$index, // e.g., 1
                            // Only include these if you added the columns
                            'video_url' => $levelData['video'] ?? null,
                            'required_blocks' => $levelData['required_blocks'] ?? null,
                            // 'content' => null, // Set if you have data for it
                        ]);
                    }
                }
                 $this->command->info("Seeded Course: {$course->name}");

            } catch (\Exception $e) {
                $this->command->error("Error seeding course '{$courseData['name']}': " . $e->getMessage());
                // Decide if you want to continue or stop on error
                 continue; // Continue with the next course
            }
        }
         $this->command->info('Course, Lesson, and Level seeding completed.');
    }
}