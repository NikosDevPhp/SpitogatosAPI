<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Tests\TestCase;
use App\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ListingTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /**
     * assert that a new listing can be created
     */
    public function testCreateListing()
    {
        $listing = factory(Listing::class)->make();
        $listing->save();

        $this->assertInstanceOf(Listing::class, $listing);
        $this->assertDatabaseHas('listings', $listing->attributesToArray());

    }

}
