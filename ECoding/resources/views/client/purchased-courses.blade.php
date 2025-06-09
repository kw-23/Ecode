@extends('layouts.client')

@section('title', 'My Purchased Courses')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --primary: #6366f1;
    --primary-hover: #4f46e5;
    --secondary: #f43f5e;
    --success: #10b981;
    --success-light: #34d399;
    --warning: #f59e0b;
    --dark: #0f172a;
    --light: #ffffff;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --gradient-card: linear-gradient(145deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
    --shadow-soft: 0 8px 32px rgba(0, 0, 0, 0.1);
    --shadow-medium: 0 16px 64px rgba(0, 0, 0, 0.15);
    --shadow-strong: 0 24px 96px rgba(0, 0, 0, 0.2);
    --blur-glass: blur(16px);
    --border-radius: 24px;
    --border-radius-sm: 16px;
    --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--gray-50);
    color: var(--gray-800);
    line-height: 1.6;
}

.courses-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.page-header {
    margin-bottom: 3rem;
    text-align: center;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--gray-900);
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-description {
    font-size: 1.1rem;
    color: var(--gray-600);
    max-width: 700px;
    margin: 0 auto;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: var(--light);
    padding: 1.5rem;
    border-radius: var(--border-radius-sm);
    box-shadow: var(--shadow-soft);
    text-align: center;
    border: 1px solid var(--gray-200);
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--gray-600);
    font-weight: 500;
}

.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
}

.course-card {
    background: var(--light);
    border-radius: var(--border-radius-sm);
    overflow: hidden;
    box-shadow: var(--shadow-soft);
    transition: var(--transition);
    border: 1px solid var(--gray-200);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.course-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-medium);
}

.course-image {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.course-card:hover .course-image img {
    transform: scale(1.05);
}

.course-category {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: rgba(99, 102, 241, 0.9);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    backdrop-filter: blur(4px);
}

.purchase-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--success);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.purchase-badge svg {
    width: 16px;
    height: 16px;
}

.course-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.course-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.course-instructor {
    font-size: 0.9rem;
    color: var(--gray-600);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.course-instructor svg {
    width: 16px;
    height: 16px;
}

.course-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    color: var(--gray-500);
    font-size: 0.9rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.meta-item svg {
    width: 16px;
    height: 16px;
}

.course-description {
    color: var(--gray-600);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex-grow: 1;
}

.course-footer {
    margin-top: auto;
    border-top: 1px solid var(--gray-200);
    padding-top: 1.25rem;
}

.purchase-info {
    margin-bottom: 1rem;
}

.purchase-date {
    font-size: 0.85rem;
    color: var(--gray-500);
    margin-bottom: 0.5rem;
}

.purchase-amount {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--primary);
}

.course-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius-sm);
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
    text-align: center;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-2px);
}

.btn-success {
    background: var(--success);
    color: white;
}

.btn-success:hover {
    background: #059669;
    transform: translateY(-2px);
}

.btn-outline {
    background: transparent;
    color: var(--gray-700);
    border: 2px solid var(--gray-300);
}

.btn-outline:hover {
    background: var(--gray-100);
    border-color: var(--gray-400);
}

.btn-full {
    width: 100%;
}

.btn svg {
    width: 18px;
    height: 18px;
}

.no-materials {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--gray-100);
    border: 1px dashed var(--gray-300);
    border-radius: var(--border-radius-sm);
    color: var(--gray-500);
    font-size: 0.9rem;
}

.no-materials svg {
    width: 18px;
    height: 18px;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--light);
    border-radius: var(--border-radius-sm);
    border: 1px dashed var(--gray-300);
    box-shadow: var(--shadow-soft);
}

.empty-state svg {
    width: 64px;
    height: 64px;
    color: var(--gray-400);
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 1rem;
}

.empty-state p {
    font-size: 1rem;
    color: var(--gray-600);
    max-width: 500px;
    margin: 0 auto 1.5rem;
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius-sm);
    margin-bottom: 2rem;
    font-weight: 500;
}

.alert-danger {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.alert-success {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}

@media (max-width: 768px) {
    .courses-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }
}

@media (max-width: 480px) {
    .courses-grid {
        grid-template-columns: 1fr;
    }
    
    .courses-container {
        padding: 1rem;
    }
}

/* Animation classes */
.fade-in {
    animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading .btn-success {
    background: var(--gray-400);
}
</style>
@endsection

@section('content')
<div class="courses-container">
    <div class="page-header">
        <h1 class="page-title">My Purchased Courses</h1>
        <p class="page-description">Access all your purchased courses and downloadable materials</p>
    </div>
    
    @if(session('error'))
        <div class="alert alert-danger">
            <strong>Error:</strong> {{ session('error') }}
        </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success">
            <strong>Success:</strong> {{ session('success') }}
        </div>
    @endif
    
    @if($purchases->count() > 0)
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $purchases->count() }}</div>
                <div class="stat-label">Total Courses</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">${{ number_format($purchases->sum('amount'), 2) }}</div>
                <div class="stat-label">Total Spent</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $purchases->sum(function($p) { return $p->course ? $p->course->estimated_hours : 0; }) }}</div>
                <div class="stat-label">Learning Hours</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $purchases->filter(function($p) { return $p->course && $p->course->pdf_file_path; })->count() }}</div>
                <div class="stat-label">Materials Available</div>
            </div>
        </div>

        <!-- Courses Grid -->
        <div class="courses-grid">
            @foreach($purchases as $purchase)
                @if($purchase->course)
                    <div class="course-card fade-in">
                        <div class="course-image">
                            @if($purchase->course->cover_image)
                                <img src="{{ asset($purchase->course->cover_image) }}" 
                                     alt="{{ $purchase->course->title }}" 
                                     onerror="this.onerror=null; this.src='/images/course-placeholder.jpg';">
                            @else
                                <img src="/images/course-placeholder.jpg" alt="{{ $purchase->course->title }}">
                            @endif
                            
                            @if($purchase->course->category)
                                <div class="course-category">
                                    {{ $purchase->course->category->name }}
                                </div>
                            @endif
                            
                            <div class="purchase-badge">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Purchased
                            </div>
                        </div>
                        
                        <div class="course-content">
                            <h2 class="course-title">{{ $purchase->course->title }}</h2>
                            
                            @if($purchase->course->instructor)
                                <div class="course-instructor">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $purchase->course->instructor->name }}
                                </div>
                            @endif
                            
                            <div class="course-meta">
                                <div class="meta-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $purchase->course->estimated_hours ?? 'N/A' }} hours
                                </div>
                                
                                <div class="meta-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ ucfirst($purchase->course->difficulty_level) }}
                                </div>
                                
                                @if($purchase->course->rating > 0)
                                    <div class="meta-item">
                                        <svg fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        {{ number_format($purchase->course->rating, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <p class="course-description">
                                {{ Str::limit($purchase->course->short_description ?? $purchase->course->description, 120) }}
                            </p>
                            
                            <div class="course-footer">
                                <div class="purchase-info">
                                    <div class="purchase-date">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; display: inline; margin-right: 4px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Purchased on {{ $purchase->purchased_at ? $purchase->purchased_at->format('M d, Y') : 'N/A' }}
                                    </div>
                                    <div class="purchase-amount">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; display: inline; margin-right: 4px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Amount: ${{ number_format($purchase->amount, 2) }}
                                    </div>
                                </div>
                                
                                <div class="course-actions">
                                    <!-- View Course Details -->
                                    <a href="{{ route('client.purchased-course-detail', $purchase->course->id) }}" 
                                       class="btn btn-primary btn-full">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Course Details
                                    </a>
                                    
                                    <!-- Download Materials -->
                                    @if($purchase->course->pdf_file_path)
                                        <a href="{{ route('client.download-course', $purchase->course->id) }}" 
                                           class="btn btn-success btn-full download-btn">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 8h8a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Download Course Materials
                                        </a>
                                    @else
                                        <div class="no-materials">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>Course materials coming soon</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3>No Purchased Courses</h3>
            <p>You haven't purchased any courses yet. Browse our catalog to find courses that interest you and start your learning journey today!</p>
            <a href="{{ route('client.courses') }}" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Browse Courses
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add download button click tracking with loading state
    document.querySelectorAll('.download-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            // Add loading state
            const originalContent = this.innerHTML;
            const card = this.closest('.course-card');
            
            this.innerHTML = `
                <svg class="animate-spin" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Preparing Download...
            `;
            
            this.classList.add('loading');
            card.classList.add('loading');
            
            // Reset after 3 seconds (in case download doesn't trigger page reload)
            setTimeout(() => {
                this.innerHTML = originalContent;
                this.classList.remove('loading');
                card.classList.remove('loading');
            }, 3000);
        });
    });
    
    // Add staggered animation for course cards
    const courseCards = document.querySelectorAll('.course-card');
    courseCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 + (index * 100));
    });
    
    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        });
    }, 5000);
});

// Add CSS for spinning animation
const style = document.createElement('style');
style.textContent = `
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection