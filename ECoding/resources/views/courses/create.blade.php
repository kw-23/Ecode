<x-app-layout>
    <div class="py-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Animated Breadcrumbs -->
            <nav class="flex mb-8 overflow-x-auto hide-scrollbar" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-white relative group">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('courses.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600 md:ml-2 dark:text-gray-300 dark:hover:text-white relative group">
                                Courses
                                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300"></span>
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Create Course</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Create Course Form with animated header -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 h-32 flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-20">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            @for ($i = 0; $i < 20; $i++)
                                <line x1="{{ rand(0, 100) }}" y1="0" x2="{{ rand(0, 100) }}" y2="100" stroke="white" stroke-width="0.5" />
                            @endfor
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white relative z-10 flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create New Course
                    </h1>
                </div>
                
                <div class="p-8">
                    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-8">
                                <!-- Basic Information -->
                                <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                        <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Basic Information
                                    </h2>
                                    
                                    <div class="space-y-6">
                                        <div class="group">
                                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition-colors duration-200">Course Title</label>
                                            <input type="text" name="title" id="title" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200" required placeholder="Enter course title">
                                        </div>
                                        
                                        <div class="group">
                                            <label for="short_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition-colors duration-200">Short Description</label>
                                            <textarea name="short_description" id="short_description" rows="2" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200" placeholder="Brief overview of the course (150 characters max)"></textarea>
                                        </div>
                                        
                                        <div class="group">
                                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition-colors duration-200">Full Description</label>
                                            <textarea name="description" id="description" rows="6" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200" placeholder="Detailed description of the course content and objectives"></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Course Details -->
                                <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                        <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        Course Details
                                    </h2>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div class="group">
                                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition-colors duration-200">Category</label>
                                            <select name="category_id" id="category_id" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200">
                                                <option value="">Select Category</option>
                                                @foreach($categories ?? [] as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="group">
                                            <label for="difficulty_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition-colors duration-200">Difficulty Level</label>
                                            <select name="difficulty_level" id="difficulty_level" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200">
                                                <option value="beginner">Beginner</option>
                                                <option value="intermediate">Intermediate</option>
                                                <option value="advanced">Advanced</option>
                                            </select>
                                        </div>
                                        
                                        <div class="group">
                                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition-colors duration-200">Price ($)</label>
                                            <div class="relative rounded-lg shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                                </div>
                                                <input type="number" name="price" id="price" step="0.01" min="0" class="block w-full pl-7 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200" placeholder="0.00">
                                            </div>
                                        </div>
                                        
                                        <div class="group">
                                            <label for="original_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition-colors duration-200">Original Price ($)</label>
                                            <div class="relative rounded-lg shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                                </div>
                                                <input type="number" name="original_price" id="original_price" step="0.01" min="0" class="block w-full pl-7 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200" placeholder="0.00">
                                            </div>
                                        </div>
                                        
                                        <div class="group">
                                            <label for="estimated_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition-colors duration-200">Estimated Hours</label>
                                            <input type="number" name="estimated_hours" id="estimated_hours" min="0" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200" placeholder="e.g. 10">
                                        </div>
                                        
                                        <div class="group">
                                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition-colors duration-200">Status</label>
                                            <select name="status" id="status" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200">
                                                <option value="draft">Draft</option>
                                                <option value="published">Published</option>
                                                <option value="archived">Archived</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Tags -->
                                <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                        <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Tags
                                    </h2>
                                    <div class="group">
                                        <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 group-focus-within:text-indigo-500 dark:group-focus-within:text-indigo-400 transition-colors duration-200">Tags (comma separated)</label>
                                        <input type="text" name="tags" id="tags" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200" placeholder="e.g. programming, web development, javascript">
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Add relevant tags to help students find your course</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="space-y-8">
                                <!-- Cover Image Upload -->
                                <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                        <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Cover Image
                                    </h2>
                                    
                                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl group hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors duration-300">
                                        <div class="space-y-1 text-center">
                                            <div id="cover-image-preview" class="hidden mb-4">
                                                <img id="cover-preview" src="#" alt="Cover preview" class="mx-auto h-48 object-cover rounded-lg shadow-md">
                                            </div>
                                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                <label for="cover_image" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-500 hover:text-indigo-500 dark:hover:text-indigo-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Upload a file</span>
                                                    <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*" onchange="previewCoverImage()">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                PNG, JPG, GIF up to 10MB
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Recommended size: 1280x720 pixels (16:9 ratio)</p>
                                </div>
                                
                                <!-- PDF Upload -->
                                <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                        <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        Course PDF
                                    </h2>
                                    
                                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl group hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors duration-300">
                                        <div class="space-y-1 text-center">
                                            <div id="pdf-preview" class="hidden mb-4">
                                                <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg inline-flex items-center">
                                                    <svg class="w-10 h-10 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <div class="text-left">
                                                        <p id="pdf-name" class="text-sm font-medium text-gray-900 dark:text-white"></p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Click to change</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                <label for="pdf_file" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-500 hover:text-indigo-500 dark:hover:text-indigo-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Upload PDF</span>
                                                    <input id="pdf_file" name="pdf_file" type="file" class="sr-only" accept="application/pdf" onchange="previewPDF()">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                PDF up to 50MB
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Upload the main course material in PDF format</p>
                                </div>
                                
                                <!-- Additional Images -->
                                <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-6">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                        <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Additional Images
                                    </h2>
                                    
                                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl group hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors duration-300">
                                        <div class="space-y-1 text-center">
                                            <div id="additional-images-preview" class="hidden mb-4">
                                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                                    <!-- Preview images will be inserted here -->
                                                </div>
                                            </div>
                                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                <label for="additional_images" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-500 hover:text-indigo-500 dark:hover:text-indigo-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Upload files</span>
                                                    <input id="additional_images" name="additional_images[]" type="file" class="sr-only" accept="image/*" multiple onchange="previewAdditionalImages()">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                PNG, JPG, GIF up to 10MB each (max 5 images)
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Add screenshots, diagrams, or other visual content for your course</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="flex flex-wrap justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-5 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" name="save_draft" class="inline-flex items-center px-5 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Save as Draft
                            </button>
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewCoverImage() {
            const file = document.getElementById('cover_image').files[0];
            const preview = document.getElementById('cover-preview');
            const previewContainer = document.getElementById('cover-image-preview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
        
        function previewPDF() {
            const file = document.getElementById('pdf_file').files[0];
            const previewContainer = document.getElementById('pdf-preview');
            const pdfName = document.getElementById('pdf-name');
            
            if (file) {
                pdfName.textContent = file.name;
                previewContainer.classList.remove('hidden');
            }
        }
        
        function previewAdditionalImages() {
            const files = document.getElementById('additional_images').files;
            const previewContainer = document.getElementById('additional-images-preview');
            
            if (files.length > 0) {
                previewContainer.innerHTML = '';
                previewContainer.classList.remove('hidden');
                
                for (let i = 0; i < Math.min(files.length, 5); i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'relative group';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'h-24 w-full object-cover rounded-lg shadow-sm group-hover:shadow-md transition-all duration-300';
                        
                        imgContainer.appendChild(img);
                        previewContainer.appendChild(imgContainer);
                    }
                    
                    reader.readAsDataURL(file);
                }
            }
        }

        // Drag and drop functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropZones = document.querySelectorAll('.border-dashed');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZones.forEach(zone => {
                    zone.addEventListener(eventName, preventDefaults, false);
                });
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZones.forEach(zone => {
                    zone.addEventListener(eventName, highlight, false);
                });
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropZones.forEach(zone => {
                    zone.addEventListener(eventName, unhighlight, false);
                });
            });
            
            function highlight(e) {
                this.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
            }
            
            function unhighlight(e) {
                this.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
            }
            
            // Handle file drops
            document.querySelector('.border-dashed:nth-child(1)').addEventListener('drop', handleCoverDrop, false);
            document.querySelector('.border-dashed:nth-child(2)').addEventListener('drop', handlePDFDrop, false);
            document.querySelector('.border-dashed:nth-child(3)').addEventListener('drop', handleImagesDrop, false);
            
            function handleCoverDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0 && files[0].type.match('image.*')) {
                    document.getElementById('cover_image').files = files;
                    previewCoverImage();
                }
            }
            
            function handlePDFDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0 && files[0].type === 'application/pdf') {
                    document.getElementById('pdf_file').files = files;
                    previewPDF();
                }
            }
            
            function handleImagesDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    document.getElementById('additional_images').files = files;
                    previewAdditionalImages();
                }
            }
        });
    </script>
    @endpush
</x-app-layout>