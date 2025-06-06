<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::orderBy('name')->paginate(10);
        return view('course-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('course-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        CourseCategory::create($validated);

        return redirect()->route('course-categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(CourseCategory $courseCategory)
    {
        return view('course-categories.show', compact('courseCategory'));
    }

    public function edit(CourseCategory $courseCategory)
    {
        return view('course-categories.edit', compact('courseCategory'));
    }

    public function update(Request $request, CourseCategory $courseCategory)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('course_categories')->ignore($courseCategory->id)],
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $courseCategory->update($validated);

        return redirect()->route('course-categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(CourseCategory $courseCategory)
    {
        $courseCategory->delete();

        return redirect()->route('course-categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}