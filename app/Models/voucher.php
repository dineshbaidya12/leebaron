<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'voucher_name', 'voucher_code', 'voucher_amount', 'min_applicable', 'discount_type', 'status', 'start_date', 'end_date'
    ];
}
