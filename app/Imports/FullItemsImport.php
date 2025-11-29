<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Company;
use App\Models\ItemGroup;
use App\Models\Unit;
use App\Models\GstMaster;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FullItemsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Step 1: Create or find related records
        $company = Company::firstOrCreate(['name' => $row['company_name']]);
        $group   = ItemGroup::firstOrCreate(['name' => $row['group_name']]);
        $unit    = Unit::firstOrCreate(['name' => $row['unit_name']]);
        $gst     = GstMaster::firstOrCreate(['percent' => $row['gst_percent']]);

        // Step 2: Create the item
        return new Item([
            'firm_id'        => $row['firm_id'],
            'item_name'      => $row['item_name'],
            'item_company'   => $row['company_name'],
            'item_group'     => $row['group_name'],
            'item_unit'      => $row['unit_name'],
            'mrp'            => $row['mrp'],
            'sale_rate'      => $row['sale_rate'],
            'purchase_rate'  => $row['purchase_rate'],
            'item_barcode'   => $row['item_barcode'],
            'short_name'     => $row['short_name'],

            // Foreign keys
            'company_id'     => $company->id,
            'group_id'       => $group->id,
            'unit_id'        => $unit->id,
            'item_gst_id'    => $gst->id,

            // Optional extra fields
            'item_af1'       => $row['item_af1'],
            'item_af2'       => $row['item_af2'],
            'item_af3'       => $row['item_af3'],
            // ... up to item_af10
        ]);
    }
}
