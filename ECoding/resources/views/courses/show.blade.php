<x-app-layout>
    <div class="py-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs with animated underline effect -->
            <nav class="flex mb-8 overflow-x-auto hide-scrollbar" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white relative group">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('courses.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-300 dark:hover:text-white relative group">
                                Gestion des cours
                                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400 truncate max-w-xs">{{ $course->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Admin Action Bar -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl mb-6 p-4">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white mr-4">ID: #{{ $course->id }}</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            @if($course->status === 'published') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                            @elseif($course->status === 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif
                        ">
                            {{ ucfirst($course->status) }}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('courses.edit', $course) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 ease-in-out">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Modifier
                        </a>
                       
                        
                        <button 
                            onclick="confirmDelete('{{ $course->id }}')" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-300 ease-in-out"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Course Header with parallax effect -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 mb-8 transform transition-all duration-300 hover:shadow-xl">
                <div class="relative">
                    @if($course->cover_image)
                        <div class="h-64 w-full overflow-hidden">
                            <img class="h-full w-full object-cover transform transition-transform duration-700 hover:scale-105" src="{{ asset($course->cover_image) }}" alt="{{ $course->title }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                        </div>
                    @else
                        <div class="h-64 w-full bg-gradient-to-r from-blue-500 to-indigo-600 overflow-hidden">
                            <div class="absolute inset-0 opacity-20">
                                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                    @for ($i = 0; $i < 20; $i++)
                                        <line x1="{{ rand(0, 100) }}" y1="0" x2="{{ rand(0, 100) }}" y2="100" stroke="white" stroke-width="0.5" />
                                    @endfor
                                </svg>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                        </div>
                    @endif
                    
                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full 
                                @if($course->status === 'published') bg-green-500/90 text-white
                                @elseif($course->status === 'draft') bg-yellow-500/90 text-white
                                @else bg-gray-500/90 text-white @endif
                                backdrop-blur-sm shadow-sm
                            ">
                                {{ ucfirst($course->status) }}
                            </span>
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-blue-500/90 text-white backdrop-blur-sm shadow-sm">
                                {{ $course->category->name ?? 'Non catégorisé' }}
                            </span>
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-purple-500/90 text-white backdrop-blur-sm shadow-sm">
                                {{ ucfirst($course->difficulty_level) }}
                            </span>
                        </div>
                        <h1 class="text-4xl font-bold leading-tight mb-2 text-shadow">{{ $course->title }}</h1>
                        <p class="mt-2 text-gray-200 text-lg max-w-3xl text-shadow">{{ $course->short_description }}</p>
                    </div>
                </div>
                
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/80 backdrop-blur-sm">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Durée estimée</p>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $course->estimated_hours ?? 'N/A' }} heures</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Inscrits</p>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $course->enrollments->count() }} étudiants</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Date</p>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    @if($course->published_at)
                                        Publié le {{ \Carbon\Carbon::parse($course->published_at)->format('d/m/Y') }}
                                    @else
                                        Créé le {{ \Carbon\Carbon::parse($course->created_at)->format('d/m/Y') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Admin Tabs -->
            <div class="mb-8">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button id="tab-details" class="tab-button border-blue-500 text-blue-600 dark:text-blue-500 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Détails du cours
                        </button>
                        
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="content-details">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Course Details -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Course Description -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                            <div class="p-8">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                    <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Description du cours
                                </h2>
                                <div class="text-white prose max-w-none dark:prose-invert prose-blue prose-lg">
                                    {!! nl2br(e($course->description)) !!}
                                </div>
                                
                                @if($course->tags && count($course->tags) > 0)
                                    <div class="mt-8">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Tags
                                        </h3>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($course->tags as $tag)
                                                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 transition-all duration-300 hover:bg-blue-200 dark:hover:bg-blue-900/70 cursor-default">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Course Files -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                            <div class="p-8">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                        <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                        Fichiers du cours
                                    </h2>
                                    
                                </div>
                                
                                @if($course->pdf_file_path)
                                    <div class="mb-8">
                                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 flex items-center justify-between group hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-all duration-300">
                                            <div class="flex items-center">
                                                <div class="bg-blue-500/10 dark:bg-blue-500/20 p-4 rounded-lg mr-4 group-hover:bg-blue-500/20 dark:group-hover:bg-blue-500/30 transition-all duration-300">
                                                    <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-base font-semibold text-gray-900 dark:text-white">PDF du cours</p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ basename($course->pdf_file_path) }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Matériel complet du cours en format PDF</p>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ asset($course->pdf_file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-5 font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Voir
                                                </a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-400 p-6 rounded-lg mb-8">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-6 w-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-amber-700 dark:text-amber-300">
                                                    Aucun fichier PDF n'a été téléchargé pour ce cours. <a href="{{ route('courses.edit', $course) }}" class="font-semibold underline hover:text-amber-800 dark:hover:text-amber-200 transition-colors">Télécharger maintenant</a>.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Additional Images -->
                                @if($course->images && count($course->images) > 0)
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Images supplémentaires
                                    </h3>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                                        @foreach($course->images as $index => $image)
                                            <div class="relative group">
                                                <img src="{{ asset($image) }}" alt="Image du cours {{ $index + 1 }}" class="h-40 w-full object-cover rounded-lg shadow-md">
                                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                                    <div class="flex space-x-2">
                                                        <button class="p-2 bg-white rounded-full text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                        </button>
                                                        <button class="p-2 bg-red-600 rounded-full text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    
                                @endif
                            </div>
                        </div>

                        <!-- Course Modules -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                            <div class="p-8">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                        <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                        </svg>
                                        Modules du cours
                                    </h2>
                                    
                                </div>
                                
                                <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                            </svg>
                                            Structure du cours
                                        </h3>
                                    </div>
                                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <div class="p-5 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg mr-3">
                                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-900 dark:text-white font-medium">1. Introduction</span>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Aperçu du cours et objectifs d'apprentissage</p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="p-5 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg mr-3">
                                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-900 dark:text-white font-medium">2. Premiers pas</span>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configuration de votre environnement</p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="p-5 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg mr-3">
                                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-900 dark:text-white font-medium">3. Concepts fondamentaux</span>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Principes et techniques fondamentaux</p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Admin Info -->
                    <div class="space-y-8">
                        <!-- Course Status Card -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Statut du cours
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 dark:text-gray-300">Statut actuel</span>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                            @if($course->status === 'published') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @elseif($course->status === 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif
                                        ">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 dark:text-gray-300">Visibilité</span>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                            @if($course->status === 'published') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif
                                        ">
                                            {{ $course->status === 'published' ? 'Public' : 'Privé' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 dark:text-gray-300">Date de création</span>
                                        <span class="text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($course->created_at)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 dark:text-gray-300">Dernière modification</span>
                                        <span class="text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($course->updated_at)->format('d/m/Y') }}</span>
                                    </div>
                                    @if($course->published_at)
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700 dark:text-gray-300">Date de publication</span>
                                            <span class="text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($course->published_at)->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Instructor Info -->
                        

                        <!-- Course Statistics -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Statistiques
                                </h3>
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4">
                                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $course->enrollments->count() }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 uppercase tracking-wider">Inscrits</p>
                                    </div>
                                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4">
                                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $course->reviews_count ?? 0 }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 uppercase tracking-wider">Avis</p>
                                    </div>
                                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4">
                                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($course->average_rating ?? 0, 1) }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 uppercase tracking-wider">Note moyenne</p>
                                    </div>
                                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4">
                                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $course->completion_rate ?? 0 }}%</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 uppercase tracking-wider">Taux d'achèvement</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="#tab-analytics" class="text-blue-600 dark:text-blue-400 text-sm font-medium hover:underline">Voir toutes les statistiques</a>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-xl">
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Actions rapides
                                </h3>
                                <div class="space-y-3">
                                    <a href="{{ route('courses.edit', $course) }}" class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors duration-200">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">Modifier le cours</span>
                                    </a>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden Tab Content -->
            <div class="tab-content hidden" id="content-content">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Contenu du cours</h2>
                        <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 ease-in-out">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Ajouter un module
                        </button>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">Gérez le contenu de votre cours, organisez les modules et les leçons, et téléchargez des ressources pédagogiques.</p>
                    
                    <!-- Content management interface would go here -->
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Commencez à ajouter du contenu</h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-6">
                            Créez des modules et des leçons pour structurer votre cours. Vous pouvez ajouter des vidéos, des textes, des quiz et d'autres ressources.
                        </p>
                        <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 ease-in-out">
                            Créer votre premier module
                        </button>
                    </div>
                </div>
            </div>

            <div class="tab-content hidden" id="content-students">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Étudiants inscrits</h2>
                        <div class="flex space-x-3">
                            <div class="relative">
                                <input type="text" placeholder="Rechercher un étudiant..." class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Ajouter un étudiant
                            </button>
                        </div>
                    </div>
                    
                    <!-- Students table would go here -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Étudiant</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date d'inscription</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Progression</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($course->enrollments ?? [] as $enrollment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                                    {{ substr($enrollment->user->name ?? 'U', 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $enrollment->user->name ?? 'Utilisateur inconnu' }}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $enrollment->user->email ?? 'Email inconnu' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($enrollment->created_at)->format('d/m/Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $enrollment->progress ?? 0 }}% complété</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                Actif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-3">Voir</a>
                                            <a href="#" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Retirer</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center">
                                            <p class="text-gray-500 dark:text-gray-400">Aucun étudiant inscrit à ce cours pour le moment.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-content hidden" id="content-analytics">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Statistiques et analyses</h2>
                    
                    <!-- Analytics dashboard would go here -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Inscrits totaux</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $course->enrollments->count() }}</p>
                                </div>
                                <div class="bg-blue-100 dark:bg-blue-800/50 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center text-sm">
                                <span class="text-green-600 dark:text-green-400 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    12%
                                </span>
                                <span class="text-gray-500 dark:text-gray-400 ml-2">depuis le mois dernier</span>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Taux d'achèvement</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $course->completion_rate ?? 0 }}%</p>
                                </div>
                                <div class="bg-blue-100 dark:bg-blue-800/50 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center text-sm">
                                <span class="text-red-600 dark:text-red-400 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                    3%
                                </span>
                                <span class="text-gray-500 dark:text-gray-400 ml-2">depuis le mois dernier</span>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Note moyenne</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($course->average_rating ?? 0, 1) }}</p>
                                </div>
                                <div class="bg-blue-100 dark:bg-blue-800/50 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center text-sm">
                                <span class="text-green-600 dark:text-green-400 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    0.2
                                </span>
                                <span class="text-gray-500 dark:text-gray-400 ml-2">depuis le mois dernier</span>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Revenus</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">${{ number_format($course->revenue ?? 0, 2) }}</p>
                                </div>
                                <div class="bg-blue-100 dark:bg-blue-800/50 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center text-sm">
                                <span class="text-green-600 dark:text-green-400 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    23%
                                </span>
                                <span class="text-gray-500 dark:text-gray-400 ml-2">depuis le mois dernier</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Graphiques détaillés à venir</h3>
                        <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                            Des graphiques et analyses plus détaillés seront disponibles lorsque votre cours aura plus d'étudiants et de données.
                        </p>
                    </div>
                </div>
            </div>

            <div class="tab-content hidden" id="content-settings">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Paramètres du cours</h2>
                    
                    <!-- Settings form would go here -->
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Paramètres généraux</h3>
                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-700 dark:text-gray-300 font-medium">Visibilité du cours</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Contrôlez qui peut voir ce cours</p>
                                    </div>
                                    <div>
                                        <select class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option>Public</option>
                                            <option>Privé</option>
                                            <option>Protégé par mot de passe</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-700 dark:text-gray-300 font-medium">Commentaires</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Autoriser les commentaires sur ce cours</p>
                                    </div>
                                    <div>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="" class="sr-only peer" checked>
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-700 dark:text-gray-300 font-medium">Auto-inscription</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Permettre aux utilisateurs de s'inscrire eux-mêmes</p>
                                    </div>
                                    <div>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="" class="sr-only peer" checked>
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Paramètres avancés</h3>
                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-700 dark:text-gray-300 font-medium">Certificat de fin de cours</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Délivrer un certificat à la fin du cours</p>
                                    </div>
                                    <div>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="" class="sr-only peer">
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-700 dark:text-gray-300 font-medium">Progression requise</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Pourcentage requis pour compléter le cours</p>
                                    </div>
                                    <div>
                                        <select class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option>80%</option>
                                            <option>90%</option>
                                            <option>100%</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-700 dark:text-gray-300 font-medium">Archiver automatiquement</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Archiver le cours après une période d'inactivité</p>
                                    </div>
                                    <div>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="" class="sr-only peer">
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 ease-in-out">
                                Enregistrer les paramètres
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal with backdrop blur -->
    <div id="delete-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div id="modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                                Supprimer le cours
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Êtes-vous sûr de vouloir supprimer ce cours ? Toutes les données seront définitivement supprimées. Cette action ne peut pas être annulée.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="delete-form" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 transform hover:-translate-y-0.5">
                            Supprimer
                        </button>
                    </form>
                    <script>
                        // Ensure confirmDelete sets the form action correctly
                        function confirmDelete(courseId) {
                            const modal = document.getElementById('delete-modal');
                            const form = document.getElementById('delete-form');
                            const cancelButton = document.getElementById('cancel-delete');
                            const backdrop = document.getElementById('modal-backdrop');
                            form.action = `/courses/${courseId}`;
                            modal.classList.remove('hidden');
                            cancelButton.onclick = () => modal.classList.add('hidden');
                            backdrop.onclick = () => modal.classList.add('hidden');
                        }
                        window.confirmDelete = confirmDelete;
                    </script>
                    <button type="button" id="cancel-delete" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 transform hover:-translate-y-0.5">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-blue-500', 'text-blue-600', 'dark:text-blue-500');
                        btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300');
                    });
                    
                    // Add active class to clicked button
                    button.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300');
                    button.classList.add('border-blue-500', 'text-blue-600', 'dark:text-blue-500');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    // Show the corresponding tab content
                    const tabId = button.id.replace('tab-', 'content-');
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });
            
            // Status dropdown
            const statusDropdownButton = document.getElementById('status-dropdown-button');
            const statusDropdown = document.getElementById('status-dropdown');
            
            if (statusDropdownButton && statusDropdown) {
                statusDropdownButton.addEventListener('click', () => {
                    statusDropdown.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', (event) => {
                    if (!statusDropdownButton.contains(event.target) && !statusDropdown.contains(event.target)) {
                        statusDropdown.classList.add('hidden');
                    }
                });
            }
            
            // Delete confirmation modal
            function confirmDelete(courseId) {
                const modal = document.getElementById('delete-modal');
                const form = document.getElementById('delete-form');
                const cancelButton = document.getElementById('cancel-delete');
                const backdrop = document.getElementById('modal-backdrop');
                
                form.action = `/courses/${courseId}`;
                modal.classList.remove('hidden');
                
                cancelButton.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
                
                backdrop.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            }
            
            // Make confirmDelete available globally
            window.confirmDelete = confirmDelete;
        });
    </script>
    @endpush
</x-app-layout>