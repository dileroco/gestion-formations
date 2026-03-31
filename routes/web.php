<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormationController as AdminFormationController;
use App\Http\Controllers\Admin\InscriptionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\TrainingSessionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\FormationController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::redirect('/', '/fr');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'active'])->name('dashboard');

Route::get('/locale/{locale}', function (string $locale) {
    if (! in_array($locale, ['fr', 'en'], true)) {
        abort(404);
    }

    session(['locale' => $locale]);
    app()->setLocale($locale);

    return redirect()->back();
})->name('locale.switch');

Route::prefix('fr')->name('fr.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/formations', [FormationController::class, 'index'])->name('formations.index');
    Route::get('/formations/{formation:slug_fr}', [FormationController::class, 'show'])->name('formations.show');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{post:slug_fr}', [BlogController::class, 'show'])->name('blog.show');

    Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/search', [\App\Http\Controllers\Public\SearchController::class, 'index'])->name('search');
});

Route::prefix('en')->name('en.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/trainings', [FormationController::class, 'index'])->name('formations.index');
    Route::get('/trainings/{formation:slug_en}', [FormationController::class, 'show'])->name('formations.show');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{post:slug_en}', [BlogController::class, 'show'])->name('blog.show');

    Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/search', [\App\Http\Controllers\Public\SearchController::class, 'index'])->name('search');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'active'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('formations', AdminFormationController::class);
        Route::resource('sessions', TrainingSessionController::class);
        Route::resource('inscriptions', InscriptionController::class);
        Route::resource('posts', PostController::class);
        Route::resource('users', UserController::class);

        Route::patch('inscriptions/{inscription}/status', [InscriptionController::class, 'updateStatus'])
            ->name('inscriptions.status');

        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])
            ->name('users.toggle-active');

        Route::get('search', [SearchController::class, 'index'])->name('search');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
