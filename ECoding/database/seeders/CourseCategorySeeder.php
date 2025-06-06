<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Frontend and backend web development courses',
                'icon' => 'fas fa-code',
                'color' => '#3B82F6',
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'description' => 'Data analysis, machine learning, and AI courses',
                'icon' => 'fas fa-chart-bar',
                'color' => '#10B981',
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'iOS and Android app development',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#8B5CF6',
            ],
            [
                'name' => 'Database',
                'slug' => 'database',
                'description' => 'Database design and management',
                'icon' => 'fas fa-database',
                'color' => '#F59E0B',
            ],
            [
                'name' => 'DevOps',
                'slug' => 'devops',
                'description' => 'Development operations and deployment',
                'icon' => 'fas fa-server',
                'color' => '#EF4444',
            ],
        ];

        foreach ($categories as $category) {
            CourseCategory::create($category);
        }
    }
}