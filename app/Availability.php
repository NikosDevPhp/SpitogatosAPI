<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'listing_id', 'availability','price'
    ];


    /**
     * Listing availabilities relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listing()
    {
        return $this->belongsTo('App\Listing', 'listing_id');
    }
}
