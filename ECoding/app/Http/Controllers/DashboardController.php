<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques générales des cours
        $totalCourses = Course::count();

        $publishedCourses = Course::where('instructor_id', $user->id)
            ->where('status', 'published')
            ->count();
        $draftCourses = Course::where('instructor_id', $user->id)
            ->where('status', 'draft')
            ->count();
        
        // Statistiques des clients/étudiants
        $totalClients = Client::count();
        $newThisMonth = Client::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $newThisWeek = Client::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        
        // Cours récents
        $recentCourses = Course::where('instructor_id', $user->id)
            ->with(['category'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
        
        // Étudiants récents
        $recentStudents = Client::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Cours les plus récents (par création)
        $latestCourses = Course::where('instructor_id', $user->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Données pour les graphiques - Nouveaux clients des 30 derniers jours
        $dailyClientGrowth = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $newClients = Client::whereDate('created_at', $date->toDateString())
                ->count();
            
            $dailyClientGrowth[] = [
                'date' => $date->format('M d'),
                'clients' => $newClients
            ];
        }
        
        // Données pour les graphiques - Nouveaux cours des 12 derniers mois
        $monthlyCourseData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $courses = Course::where('instructor_id', $user->id)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            
            $monthlyCourseData[] = [
                'month' => $date->format('M Y'),
                'courses' => $courses
            ];
        }
        
        // Répartition par catégorie
        $categoryStats = Course::where('instructor_id', $user->id)
            ->join('course_categories', 'courses.category_id', '=', 'course_categories.id')
            ->select('course_categories.name', 'course_categories.color', DB::raw('count(*) as total'))
            ->groupBy('course_categories.id', 'course_categories.name', 'course_categories.color')
            ->get();
        
        // Activités récentes
        $recentActivities = collect();
        
        // Ajouter les cours récemment créés
        $recentCourses->each(function($course) use ($recentActivities) {
            $recentActivities->push([
                'type' => 'course_created',
                'title' => 'Course Created',
                'description' => "Created course: {$course->title}",
                'date' => $course->created_at,
                'icon' => 'book',
                'color' => 'blue'
            ]);
        });
        
        // Ajouter les nouveaux clients
        $recentStudents->each(function($client) use ($recentActivities) {
            $recentActivities->push([
                'type' => 'client_registered',
                'title' => 'New Student',
                'description' => "{$client->name} joined as a new student",
                'date' => $client->created_at,
                'icon' => 'user-plus',
                'color' => 'green'
            ]);
        });
        
        // Trier les activités par date
        $recentActivities = $recentActivities->sortByDesc('date')->take(10);
        
        // Objectifs et métriques de performance
        $coursesGoal = 10; // Objectif de cours publiés
        $coursesProgress = $coursesGoal > 0 ? ($publishedCourses / $coursesGoal) * 100 : 0;
        
        $clientsGoal = 100; // Objectif de clients
        $clientsProgress = $clientsGoal > 0 ? ($totalClients / $clientsGoal) * 100 : 0;
        
        // Métriques simples
        $averageCoursesPerMonth = $totalCourses > 0 ? $totalCourses / 12 : 0;
        $averageClientsPerMonth = $totalClients > 0 ? $totalClients / 12 : 0;
        
        return view('dashboard', compact(
            'totalCourses',
            'publishedCourses',
            'draftCourses',
            'totalClients',
            'newThisMonth',
            'newThisWeek',
            'recentCourses',
            'recentStudents',
            'latestCourses',
            'monthlyCourseData',
            'dailyClientGrowth',
            'categoryStats',
            'recentActivities',
            'coursesGoal',
            'coursesProgress',
            'clientsGoal',
            'clientsProgress',
            'averageCoursesPerMonth',
            'averageClientsPerMonth'
        ));
    }
}
