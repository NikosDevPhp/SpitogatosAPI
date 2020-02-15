<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'listing_id', 'location', 'square_meters'
    ];

    /**
     * A listing can be mulitple types
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function types()
    {
        return $this->hasMany('App\Type', 'listing_id', 'listing_id');
    }

    /**
     * Availability cannot be both for sale and rent
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function availabilities()
    {
        return $this->hasOne('App\Availability', 'listing_id', 'listing_id');
    }
}
