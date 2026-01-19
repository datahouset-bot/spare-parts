<?php

namespace App\Models;

use App\Traits\HasFinancialYear;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    use HasFinancialYear;
}
