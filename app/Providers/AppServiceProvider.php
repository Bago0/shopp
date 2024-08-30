<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\ReportService;
use App\services\ReportServiceInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReportServiceInterface::class, ReportService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        View::composer('layouts.navigation', function ($view) {

            $categories = Category::all();

            $view->with('categories', $categories);
        });
    }
}
