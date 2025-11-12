<?php

namespace App\Imports;

use App\Models\Offer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OfferTypeImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $key => $value){
               $saveOfferType = Offer::updateOrCreate(['id' =>  $collection[$key]['id']] , [
                    'id' => $collection[$key]['id'],
                    'top_offer' => $collection[$key]['top_offer'],
                    'bottom_offer' => $collection[$key]['bottom_offer'],
                    'created_at' => $collection[$key]['created_at'],
                    'updated_at' => $collection[$key]['updated_at'],
               ]);
        }
        return $saveOfferType;
    }
    public function rules() :array
    {
        return array(
            'id' => 'required',
            'top_offer' => 'required',
        );

    }
    public function customValidationMessages()
    {
    return [
        'id' => 'Offer id is required',
        'top_offer.required' => 'Top Offfer is required',
        ];
    }
}
