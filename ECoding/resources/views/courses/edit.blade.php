<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('courses.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Courses</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('courses.show', $course) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ $course->title }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Edit Course Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Course</h1>
                    
                    <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Basic Information -->
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h2>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                            <input type="text" name="title" id="title" value="{{ $course->title }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        </div>
                                        
                                        <div>
                                            <label for="short_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Short Description</label>
                                            <textarea name="short_description" id="short_description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $course->short_description }}</textarea>
                                        </div>
                                        
                                        <div>
                                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Description</label>
                                            <textarea name="description" id="description" rows="6" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $course->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Course Details -->
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Course Details</h2>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="">Select Category</option>
                                                @foreach($categories ?? [] as $category)
                                                    <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="difficulty_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Difficulty Level</label>
                                            <select name="difficulty_level" id="difficulty_level" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="beginner" {{ $course->difficulty_level == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                                <option value="intermediate" {{ $course->difficulty_level == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                <option value="advanced" {{ $course->difficulty_level == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price ($)</label>
                                            <input type="number" name="price" id="price" step="0.01" min="0" value="{{ $course->price }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label for="original_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Original Price ($)</label>
                                            <input type="number" name="original_price" id="original_price" step="0.01" min="0" value="{{ $course->original_price }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label for="estimated_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estimated Hours</label>
                                            <input type="number" name="estimated_hours" id="estimated_hours" min="0" value="{{ $course->estimated_hours }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="draft" {{ $course->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ $course->status == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="archived" {{ $course->status == 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Tags -->
                                <div>
                                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tags (comma separated)</label>
                                    <input type="text" name="tags" id="tags" value="{{ is_array($course->tags) ? implode(', ', $course->tags) : $course->tags }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. programming, web development, javascript">
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Cover Image Upload -->
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Cover Image</h2>
                                    
                                    @if($course->cover_image)
                                        <div class="mb-4">
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Cover Image:</p>
                                            <div class="relative">
                                                <img src="{{ asset($course->cover_image) }}" alt="{{ $course->title }}" class="h-40 object-cover rounded-md">
                                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                                    <label for="remove_cover_image" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 cursor-pointer">
                                                        <input type="checkbox" id="remove_cover_image" name="remove_cover_image" class="mr-2">
                                                        Remove Image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <div id="cover-image-preview" class="hidden mb-4">
                                                <img id="cover-preview" src="#" alt="Cover preview" class="mx-auto h-40 object-cover">
                                            </div>
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                <label for="cover_image" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-500 hover:text-blue-500 dark:hover:text-blue-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Upload a new file</span>
                                                    <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*" onchange="previewCoverImage()">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                PNG, JPG, GIF up to 10MB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- PDF Upload -->
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Course PDF</h2>
                                    
                                    @if($course->pdf_file_path)
                                        <div class="mb-4">
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current PDF:</p>
                                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-8 h-8 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ basename($course->pdf_file_path) }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ asset($course->pdf_file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        View
                                                    </a>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <div id="pdf-preview" class="hidden mb-4">
                                                <svg class="mx-auto h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                                <p id="pdf-name" class="text-sm font-medium text-gray-900 dark:text-white mt-2"></p>
                                            </div>
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                <label for="pdf_file" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-500 hover:text-blue-500 dark:hover:text-blue-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Upload new PDF</span>
                                                    <input id="pdf_file" name="pdf_file" type="file" class="sr-only" accept="application/pdf" onchange="previewPDF()">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                PDF up to 50MB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Additional Images -->
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Images</h2>
                                    
                                    @if($course->images && count($course->images) > 0)
                                        <div class="mb-4">
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Images:</p>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                                @foreach($course->images as $index => $image)
                                                    <div class="relative group">
                                                        <img src="{{ asset($image) }}" alt="Course image {{ $index + 1 }}" class="h-24 w-full object-cover rounded">
                                                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <label class="flex items-center justify-center px-2 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 cursor-pointer">
                                                                <input type="checkbox" name="remove_images[]" value="{{ $index }}" class="mr-1">
                                                                Remove
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <div id="additional-images-preview" class="hidden mb-4 grid grid-cols-2 sm:grid-cols-3 gap-2">
                                                <!-- Preview images will be inserted here -->
                                            </div>
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                <label for="additional_images" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-500 hover:text-blue-500 dark:hover:text-blue-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
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
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="mt-8 flex justify-end space-x-3">
                            <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit" name="save_draft" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Save as Draft
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Course
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
                        imgContainer.className = 'relative';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'h-24 w-full object-cover rounded';
                        
                        imgContainer.appendChild(img);
                        previewContainer.appendChild(imgContainer);
                    }
                    
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
    @endpush
</x-app-layout>