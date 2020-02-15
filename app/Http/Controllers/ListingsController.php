<?php

namespace App\Http\Controllers;

use App\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListingsController extends Controller
{
    //

    public function getSearchResults(Request $request)
    {
        $input = $request->all();
//        $data = Listing::with(['types' => function($query, $input) {
//            $query->where('type', $input['type']);
//        }, 'availabilities' => function($query, $input) {
//            $query->where('availability', $input['availability']);
//        }])->get();

        $data = DB::table('listings')
                ->join('availabilities', 'listings.listing_id', '=', 'availabilities.listing_id')
                ->join('types', 'listings.listing_id', '=', 'types.listing_id')
                ->where([
                        ['listings.location', '=', $input['location']],
                        ['availabilities.availability', '=', $input['availability']],
                    ])
                ->whereBetween('availabilities.price', [$input['min_price'], $input['max_price']])
                ->whereBetween('listings.square_meters', [$input['min_square_meters'], $input['max_square_meters']])
                ->select('listings.*', 'availabilities.*', 'types.*')
                ->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
