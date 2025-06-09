<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Auth\ClientRegisterController;
use App\Http\Controllers\Auth\ClientLoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StuClientController;
use App\Http\Controllers\CourseReviewController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/




Route::middleware(['auth:client'])->group(function () {
    // Main purchased courses page
    Route::get('/my-courses', [ClientController::class, 'purchasedCourses'])
        ->name('client.purchased-courses');
    
    // Alternative methods (for testing different approaches)
    Route::get('/my-courses-alt', [ClientController::class, 'purchasedCoursesAlternative'])
        ->name('client.purchased-courses-alt');
    
    Route::get('/my-courses-join', [ClientController::class, 'purchasedCoursesWithJoin'])
        ->name('client.purchased-courses-join');
    
    // Show specific purchased course
    Route::get('/my-course/{courseId}', [ClientController::class, 'showPurchasedCourse'])
        ->name('client.purchased-course-detail');
    
    // Download course materials
    Route::get('/download-course/{courseId}', [ClientController::class, 'downloadCourse'])
        ->name('client.download-course');
    
    // Get purchase statistics (API endpoint)
    Route::get('/api/purchase-stats', [ClientController::class, 'getPurchasedCourseStats'])
        ->name('client.purchase-stats');
});
Route::middleware(['auth:client'])->group(function () {
    Route::get('/courses/{course}/download', [CourseController::class, 'download'])
        ->name('client.download-course');
});
// In your routes/web.php file
Route::get('/client/download-course/{course}', [ClientController::class, 'downloadCourse'])
    ->name('client.download-course')
    ->middleware('auth:client');
Route::get('/client/cart', [CartController::class, 'index'])->name('client.cart.index');
// Route for creating a course (admin)
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::get('/courses/{courses}/show', [CourseController::class, 'show'])->name('courses.show');

// Route for showing a course (admin)
// (This route is not needed because Route::resource('courses', CourseController::class) already defines it.)
// If you want to restrict admin viewing to only the resource route, you can remove this    line entirely.

// Welcome page
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

// Public course viewing
Route::get('/courses', [CourseController::class, 'publicIndex'])->name('courses.public.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'publicShow'])->name('courses.public.show');

// Course categories public view
Route::get('/categories', [CourseCategoryController::class, 'publicIndex'])->name('categories.public.index');
Route::get('/categories/{category:slug}', [CourseCategoryController::class, 'publicShow'])->name('categories.public.show');

// Search and filtering
Route::get('/search', [CourseController::class, 'search'])->name('courses.search');

/*
|--------------------------------------------------------------------------
| Admin Routes (Regular User Authentication)
|--------------------------------------------------------------------------
*/

// Admin Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Course management (admin)
    Route::resource('courses', CourseController::class);
    // Allow clients to create courses (admin panel)
    
    // Additional course management routes
    Route::prefix('courses')->name('courses.')->group(function () {
        Route::post('/{course}/toggle-status', [CourseController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{course}/duplicate', [CourseController::class, 'duplicate'])->name('duplicate');
        Route::get('/bulk-actions', [CourseController::class, 'bulkActions'])->name('bulk-actions');
        Route::post('/bulk-delete', [CourseController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/export', [CourseController::class, 'export'])->name('export');
        Route::post('/import', [CourseController::class, 'import'])->name('import');
    });

    // Course categories management
    Route::resource('course-categories', CourseCategoryController::class, [
        'names' => [
            'index' => 'course-categories.index',
            'create' => 'course-categories.create',
            'store' => 'course-categories.store',
            'show' => 'course-categories.show',
            'edit' => 'course-categories.edit',
            'update' => 'course-categories.update',
            'destroy' => 'course-categories.destroy',
        ]
    ]);

    // Student/Client management (admin)
    Route::resource('clients', StuClientController::class);

    // Additional client management routes
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::post('/{client}/change-password', [StuClientController::class, 'changePassword'])->name('change-password');
        Route::patch('/{client}/suspend', [StuClientController::class, 'suspend'])->name('suspend');
        Route::patch('/{client}/activate', [StuClientController::class, 'activate'])->name('activate');
        Route::patch('/{client}/deactivate', [StuClientController::class, 'deactivate'])->name('deactivate');
        Route::get('/search', [StuClientController::class, 'search'])->name('search');
        Route::get('/export', [StuClientController::class, 'export'])->name('export');
        Route::post('/bulk-delete', [StuClientController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/import', [StuClientController::class, 'import'])->name('import');
        Route::get('/template', [StuClientController::class, 'downloadTemplate'])->name('template');
    });

    // Reports and statistics
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'reports'])->name('dashboard');
        Route::get('/clients', [StuClientController::class, 'clientsReport'])->name('clients');
        Route::get('/courses', [CourseController::class, 'coursesReport'])->name('courses');
        Route::get('/enrollments', [CourseController::class, 'enrollmentsReport'])->name('enrollments');
        Route::get('/sales', [PaymentController::class, 'salesReport'])->name('sales');
        Route::get('/revenue', [PaymentController::class, 'revenueReport'])->name('revenue');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/general', function () { return view('admin.settings.general'); })->name('general');
        Route::get('/payment', function () { return view('admin.settings.payment'); })->name('payment');
        Route::get('/email', function () { return view('admin.settings.email'); })->name('email');
    });
});

/*
|--------------------------------------------------------------------------
| Client Authentication Routes
|--------------------------------------------------------------------------
*/

// Guest routes for clients (not logged in)
Route::middleware('guest:client')->group(function () {
    // Registration routes
    Route::get('/client/register', [ClientRegisterController::class, 'showRegistrationForm'])->name('client.register');
    Route::post('/client/register', [ClientRegisterController::class, 'register']);

    // Login routes
    Route::get('/client/login', [ClientLoginController::class, 'showLoginForm'])->name('client.login');
    Route::post('/client/login', [ClientLoginController::class, 'login']);

    // Password reset routes
    Route::get('/client/forgot-password', [ClientLoginController::class, 'showForgotPasswordForm'])->name('client.password.request');
    Route::post('/client/forgot-password', [ClientLoginController::class, 'sendResetLinkEmail'])->name('client.password.email');
    Route::get('/client/reset-password/{token}', [ClientLoginController::class, 'showResetPasswordForm'])->name('client.password.reset');
    Route::post('/client/reset-password', [ClientLoginController::class, 'resetPassword'])->name('client.password.update');
});

/*
|--------------------------------------------------------------------------
| Client Protected Routes
|--------------------------------------------------------------------------
*/

// Authenticated client routes
Route::middleware('auth:client')->group(function () {
    // Authentication
    Route::post('/client/logout', [ClientLoginController::class, 'logout'])->name('client.logout');
    Route::get('/course/{course}/download', [CourseController::class, 'download'])
        ->name('client.download-course');
    
    Route::get('/ajax/courses/{course}/check-enrollment', [CourseController::class, 'checkEnrollment'])
        ->name('ajax.courses.check-enrollment');
    // Client dashboard and profile
    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/client/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::put('/client/profile', [ClientController::class, 'updateProfile'])->name('client.profile.update');
    Route::post('/client/profile/avatar', [ClientController::class, 'updateAvatar'])->name('client.profile.avatar');
    Route::post('/client/profile/image', [ProfileController::class, 'updateClientImage'])->name('client.profile.image.update');
    Route::post('/client/profile/image/delete', [ProfileController::class, 'deleteClientImage'])->name('client.profile.image.delete');
    // Password management
    Route::get('/client/change-password', [ClientController::class, 'changePassword'])->name('client.password');
    Route::put('/client/change-password', [ClientController::class, 'updatePassword'])->name('client.password.update');

    // Course browsing and enrollment
    Route::get('/client/courses', [ClientController::class, 'courses'])->name('client.courses');
    Route::get('/client/courses/{course:slug}', [ClientController::class, 'showCourse'])->name('client.course.show');
    Route::get('/client/courses/{course:slug}/detail', [ClientController::class, 'showCourse'])->name('client.course-detail');
    Route::post('/client/courses/{course}/enroll', [ClientController::class, 'enrollCourse'])->name('client.enroll-course');
    Route::get('/client/download-course/{course}', [ClientController::class, 'downloadCourse'])->name('client.download-course');

    // Course management for clients
    Route::get('/client/enrolled-courses', [ClientController::class, 'enrolledCourses'])->name('client.enrolled-courses');
    Route::get('/client/download-history', [ClientController::class, 'downloadHistory'])->name('client.download-history');
    Route::get('/client/recommended-courses', [ClientController::class, 'recommendedCourses'])->name('client.recommended-courses');
    Route::get('/client/wishlist', [ClientController::class, 'wishlist'])->name('client.wishlist');
    Route::post('/client/wishlist/{course}', [ClientController::class, 'addToWishlist'])->name('client.wishlist.add');
    Route::delete('/client/wishlist/{course}', [ClientController::class, 'removeFromWishlist'])->name('client.wishlist.remove');

    // Course reviews
    Route::prefix('courses/{course}')->name('course.reviews.')->group(function () {
        Route::post('/reviews', [CourseReviewController::class, 'store'])->name('store');
        Route::put('/reviews/{review}', [CourseReviewController::class, 'update'])->name('update');
        Route::delete('/reviews/{review}', [CourseReviewController::class, 'destroy'])->name('destroy');
        Route::post('/reviews/{review}/like', [CourseReviewController::class, 'like'])->name('like');
        Route::post('/reviews/{review}/report', [CourseReviewController::class, 'report'])->name('report');
    });

    /*
    |--------------------------------------------------------------------------
    | Payment Routes
    |--------------------------------------------------------------------------
    */
    
    // Single course payment
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/course/{course}/checkout', [PaymentController::class, 'checkout'])->name('checkout');
        Route::post('/process', [PaymentController::class, 'process'])->name('process');
        Route::post('/confirm', [PaymentController::class, 'confirmPayment'])->name('confirm');
        Route::get('/course/{course}/success', [PaymentController::class, 'success'])->name('success');
        Route::get('/course/{course}/cancel', [PaymentController::class, 'cancel'])->name('cancel');
        Route::get('/history', [PaymentController::class, 'history'])->name('history');
        Route::get('/invoice/{purchase}', [PaymentController::class, 'invoice'])->name('invoice');
        Route::post('/refund/{purchase}', [PaymentController::class, 'refund'])->name('refund');
    });

    /*
    |--------------------------------------------------------------------------
    | Shopping Cart Routes
    |--------------------------------------------------------------------------
    */
    
    Route::prefix('cart')->name('cart.')->group(function () {
        // Cart management
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{course}', [CartController::class, 'add'])->name('add');
        Route::delete('/remove/{course}', [CartController::class, 'remove'])->name('remove');
        Route::patch('/update/{course}', [CartController::class, 'update'])->name('update');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
        
        // Cart checkout and payment
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/process-payment', [CartController::class, 'processCartPayment'])->name('process-payment');
        Route::get('/payment-success', [CartController::class, 'cartPaymentSuccess'])->name('payment-success');
        Route::get('/payment-cancel', [CartController::class, 'cartPaymentCancel'])->name('payment-cancel');
        
        // Quick actions
        Route::post('/quick-add/{course}', [CartController::class, 'quickAdd'])->name('quick-add');
        Route::post('/save-for-later/{course}', [CartController::class, 'saveForLater'])->name('save-for-later');
        Route::post('/move-to-cart/{course}', [CartController::class, 'moveToCart'])->name('move-to-cart');
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [ClientController::class, 'notifications'])->name('index');
        Route::post('/{notification}/mark-read', [ClientController::class, 'markNotificationRead'])->name('mark-read');
        Route::post('/mark-all-read', [ClientController::class, 'markAllNotificationsRead'])->name('mark-all-read');
        Route::delete('/{notification}', [ClientController::class, 'deleteNotification'])->name('delete');
    });

    // Support and help
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [ClientController::class, 'support'])->name('index');
        Route::post('/ticket', [ClientController::class, 'createSupportTicket'])->name('ticket.create');
        Route::get('/faq', [ClientController::class, 'faq'])->name('faq');
        Route::get('/contact', [ClientController::class, 'contact'])->name('contact');
        Route::post('/contact', [ClientController::class, 'sendContactMessage'])->name('contact.send');
    });
});

/*
|--------------------------------------------------------------------------
| AJAX Routes (Public and Protected)
|--------------------------------------------------------------------------
*/

// Public AJAX routes
Route::prefix('ajax')->name('ajax.')->group(function () {
    // Course search and filtering
    Route::get('/courses/search', [CourseController::class, 'ajaxSearch'])->name('courses.search');
    Route::get('/courses/filter', [CourseController::class, 'ajaxFilter'])->name('courses.filter');
    Route::get('/categories', [CourseCategoryController::class, 'ajaxIndex'])->name('categories');
});

// Protected AJAX routes
Route::middleware('auth:client')->prefix('ajax')->name('ajax.')->group(function () {
    // Cart operations
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    Route::get('/cart/items', [CartController::class, 'getCartItems'])->name('cart.items');
    Route::get('/cart/total', [CartController::class, 'getCartTotal'])->name('cart.total');
    
    // Course operations
    Route::post('/courses/{course}/toggle-wishlist', [ClientController::class, 'toggleWishlist'])->name('courses.toggle-wishlist');
    Route::get('/courses/{course}/check-enrollment', [ClientController::class, 'checkEnrollment'])->name('courses.check-enrollment');
    
    // Notifications
    Route::get('/notifications/unread-count', [ClientController::class, 'getUnreadNotificationsCount'])->name('notifications.unread-count');
});

/*
|--------------------------------------------------------------------------
| API Routes for Mobile App (Optional)
|--------------------------------------------------------------------------
*/

Route::prefix('api/v1')->name('api.')->group(function () {
    // Public API routes
    Route::get('/courses', [CourseController::class, 'apiIndex'])->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'apiShow'])->name('courses.show');
    Route::get('/categories', [CourseCategoryController::class, 'apiIndex'])->name('categories.index');
    
    // Protected API routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [ClientController::class, 'apiUser'])->name('user');
        Route::get('/user/courses', [ClientController::class, 'apiUserCourses'])->name('user.courses');
        Route::get('/user/cart', [CartController::class, 'apiCart'])->name('user.cart');
    });
});

/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
*/

// Payment webhooks (no auth middleware needed)
Route::prefix('webhooks')->name('webhooks.')->group(function () {
    Route::post('/stripe', [PaymentController::class, 'webhook'])->name('stripe');
    Route::post('/payment', [PaymentController::class, 'webhook'])->name('payment');
});

/*
|--------------------------------------------------------------------------
| Redirects and Fallbacks
|--------------------------------------------------------------------------
*/

// Client redirect
Route::redirect('/client', '/client/login');

// Admin redirect
Route::redirect('/admin', '/dashboard');

/*
|--------------------------------------------------------------------------
| Laravel's Default Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
