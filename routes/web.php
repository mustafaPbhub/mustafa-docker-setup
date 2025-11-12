<?php


use App\Http\Controllers\Admin\BannerPageSettingController;
use App\Http\Controllers\ImpressumController;
use App\Http\Controllers\Api\Apicontroller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TinyMCEController;
use App\Http\Controllers\SiteMapController;
use App\Http\Controllers\{PagesController, NewsletterController, SearchController, BlogCommentsController, CommentsReplyController};
use App\Models\Impressum;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::middleware(['redirection', 'firewall.all', 'metatags'])->group(function () {
    Route::get('/', [PagesController::class, 'home'])->name('home');
    Route::get('/blog/{name?}', [PagesController::class, 'blog_details'])->name('blog_details');
    Route::get('/blogs', [PagesController::class, 'blogs'])->name('blogs');
    // Route::permanentRedirect('/blog', '/blogs');
    Route::get('/stores', [PagesController::class, 'stores'])->name('stores');
    Route::get('/aboutus', [PagesController::class, 'aboutus'])->name('aboutus');
    Route::get('/terms_and_conditions', [PagesController::class, 'termsandconditions'])->name('termsandconditions');
    Route::get('/privacy_and_policy', [PagesController::class, 'privacy_and_policy'])->name('privacyandpolicy');
    Route::get('/categories', [PagesController::class, 'categories'])->name('categories');
    Route::get('/get_stores', [PagesController::class, 'get_stores'])->name('get_stores');
    Route::get('/blogs/categories/all', [PagesController::class, 'blog_categories'])->name('blog_categories');
    Route::get('/blog/category/{name?}', [PagesController::class, 'blog_category'])->name('blog_category');
    Route::get('/store/{name?}', [PagesController::class, 'store_details'])->name('store_details');
    Route::get('/category/{name?}', [PagesController::class, 'category_details'])->name('category_details');
    Route::post('subcribe', [NewsletterController::class, 'subscribe'])->name('subscribe');
    Route::post('contact_us', [ImpressumController::class, 'contact_us'])->name('contact_us');
    Route::post('comment', [BlogCommentsController::class, 'blogsComment'])->name('comment');
    Route::post('reply', [CommentsReplyController::class, 'commentsReply'])->name('reply');
    Route::get('imprint', [PagesController::class, 'impressum'])->name('impressum');
    Route::get('search', [SearchController::class, 'search'])->name('search');
    Route::get('coupon_details/{id?}', [PagesController::class, 'coupon_details'])->name('coupon_details');
    Route::get('blog/draftpreview/{slug?}', [PagesController::class, 'draft_preview'])->name('blogs.preview');
    Route::redirect('/blogs/categories/all', '/blogs', 301); // 301 for permanent redirection

});
