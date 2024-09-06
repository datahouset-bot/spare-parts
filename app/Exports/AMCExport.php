<?php

namespace App\Exports;

use App\Models\Amc;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class AMCExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Retrieve the data you want to export with related models loaded
        $amcs = Amc::with('item', 'account')->get();

        // Format the data into a collection suitable for export
        $formattedData = $amcs->map(function($amc) {
            return [
                'Sr. No.' => $amc->id, // Assuming 'id' is the primary key of the Amc model
                'ID' => $amc->id,
                'Item Name' => $amc->item->item_name,
                'Account Name' => $amc->account->account_name,
                'Mobile' => $amc->account->mobile,
                'Phone' => $amc->account->phone,
                'city' => $amc->account->city,
                'person_name' => $amc->account->person_name,



                'AMC Amount' => $amc->amc_amount,
                'AMC Start Date' => $amc->amc_start_date,
                'AMC End Date' => $amc->amc_end_date,
                'Payment Status' => $amc->payment_status,
                'AMC Status' => $amc->amc_status,
                'Priority' => $amc->priority,
            ];
        });

        return $formattedData;
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        // Define the headings for the exported file
        return [
            'Sr. No.',
            'ID',
            'Item Name',
            'Account Name',
            'Mobile',
            'phone',
            'city',
            'person_name',
            'AMC Amount',
            'AMC Start Date',
            'AMC End Date',
            'Payment Status',
            'AMC Status',
            'Priority',
        ];
    }
}
