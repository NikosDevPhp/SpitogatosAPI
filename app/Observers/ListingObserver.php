<?php

namespace App\Observers;

use App\Listing;
use Illuminate\Support\Facades\Artisan;

class ListingObserver
{

    /**
     * The observer is called when Listing base model is changed by console command or anywhere in the application,
     * If there is any manual change to the database then we have to run clear:cache manually
     * @param Listing $listing
     */
    public function saved(Listing $listing)
    {
        Artisan::call('cache:clear');
    }
}
