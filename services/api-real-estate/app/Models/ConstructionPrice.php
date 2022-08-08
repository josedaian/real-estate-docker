<?php

namespace App\Models;

use App\Enums\PriceTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'zip_code',
        'construction_type_id',
        'price_type',
        'unit_price',
        'construction_unit_price',
        'elements',
    ];

    protected $casts = [
        'price_type' => PriceTypes::class
    ];
}
