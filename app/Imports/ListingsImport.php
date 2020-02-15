<?php
declare(strict_types =  1);

namespace App\Imports;

use App\Type;
use App\Listing;
use App\Availability;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\withStartRow;

class ListingsImport implements ToCollection, withStartRow
{
    /**
     * Implements ToCollection Interface
     * @param \Illuminate\Support\Collection $rows
     */
    public function collection(Collection $rows): void
    {
        $this->isValidCollection($rows);

        foreach($rows as $row) {

            $types = array_map('trim',
                explode(',', $row[1])
            );
            $this->isValidType($types);

            Listing::updateOrCreate([
                'listing_id' => $row[0]
                ],
                [
                'listing_id' => $row[0],
                'location' => $row[3],
                'square_meters' => $row[4]
            ]);

            foreach ($types as $type) {
                Type::updateOrCreate(
                    [
                    'listing_id' => $row[0],
                    'type' => $type
                ]);
            }

            // listing_id + availability MUST be unique i.e. should update price for Rent or Sale in specific building
            // and also create new availability for Rent even if availability for Sale already specified
            Availability::updateOrCreate([
                'listing_id' => $row[0],
                'availability' => $row[2]
                ],
                [
                'listing_id' => $row[0],
                'availability' => $row[2],
                'price' => $row[5]
            ]);
        }
    }

    /**
     * Custom Validation method
     * Could not use package validation, later versions must implement this
     * @link https://docs.laravel-excel.com/3.1/imports/validation.html#row-validation-without-tomodel
     * @param Collection $rows
     */
    public function isValidCollection(Collection $rows): void
    {
        Validator::make($rows->toArray(), [
            '0' => 'present|array',
            '*.0' => 'required|numeric|distinct',
            '*.2' => 'required|string|in:Sale,Rent',
            '*.3' => 'required|string',
            '*.4' => 'required|numeric',
            '*.5' => 'required|numeric',
        ])->validate();
    }

    /**
     * Custom Validation for the type
     * Could not use package validation, later versions must implement this
     * @link https://docs.laravel-excel.com/3.1/imports/validation.html#row-validation-without-tomodel
     * @param array $types
     */
    public function isValidType(array $types): void
    {
        Validator::make($types, [
            '0' => 'string|in:Apartment,Studio,Loft,Maisonette',
            '1' => 'string|in:Apartment,Studio,Loft,Maisonette',
            '2' => 'string|in:Apartment,Studio,Loft,Maisonette',
            '3' => 'string|in:Apartment,Studio,Loft,Maisonette',
        ])->validate();
    }

    /**
     * Implements WithStartRow Interface
     * @return int The row number to start reading
     */
    public function startRow(): int
    {
        return 2;
    }
}
