<?php

namespace App\Providers;

use App\Listing;
use App\Observers\ListingObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Listing::observe(ListingObserver::class);
//        DB::listen(function ($query) {
//            Log::channel('queries')->info(
//                implode(',', $query->bindings)
//            );
//        });
    }
}
