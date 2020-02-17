<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


class ListingsController extends Controller
{
    /**
     * Results Search controller from cached response
     * Preferred "raw" query because eloquent models were creating subqueries that can have performance penalties for large data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearchResults(Request $request)
    {
        $input = $request->all();

        // return cached response if available and log response
        $key = 'response_' . Str::slug($request->fullUrl() . implode(',', $input));
        if (Cache::has($key)) {
            Log::channel('queries')->info(
                implode(',', $input)
            );
            return response()->json(
                json_decode(Cache::get($key), true)
            );
        }

        // validate request and respond error message
        $validator = Validator::make($request->all(), [
            'availability' => 'required|string',
            'location' => 'required|string',
            'type' => 'sometimes|string',
            'min_price' => 'sometimes|numeric',
            'max_price' => 'sometimes|numeric',
            'min_square_meters' => 'sometimes|numeric',
            'max_square_meters' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors, 400);
        }

        // retrieve data if request is valid
        $listings = DB::table('listings')
            ->join('availabilities', 'listings.listing_id', '=', 'availabilities.listing_id')
            ->join('types', 'listings.listing_id', '=', 'types.listing_id');

        if ($request->filled('location')) {
            $listings->where('listings.location', '=', $input['location']);
        }
        if ($request->filled('availability')) {
            $listings->where('availabilities.availability', '=', $input['availability']);
        }
        if ($request->filled('type')) {
            $listings->where('types.type', '=', $input['type']);
        }
        if ($request->filled('min_price')) {
            $listings->where('availabilities.price', '>=', $input['min_price']);
        }
        if ($request->filled('max_price')) {
            $listings->where('availabilities.price', '<=', $input['max_price']);
        }
        if ($request->filled('min_square_meters')) {
            $listings->where('listings.square_meters', '>=', $input['min_square_meters']);
        }
        if ($request->filled('max_square_meters')) {
            $listings->where('listings.square_meters', '<=', $input['max_square_meters']);
        }
        $listings->groupBy(['listings.listing_id', 'availabilities.price']);

        $data = $listings->select('listings.*', 'availabilities.availability','availabilities.price', DB::raw('group_concat(types.type) as type_concat'))
                ->get();


        return response()->json([
            'data' => $data
        ]);
    }
}
