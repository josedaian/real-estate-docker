<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastre extends Model
{
    use HasFactory;

    protected $table = 'cadastre';

    protected $fillable = [
        'fid',
        'geo_shape',
        'address',
        'zip_code',
        'suburb',
        'grouynd_surface',
        'construction_surface',
        'contruction_type_id',
        'level_range_key',
        'construction_year',
        'special_facilities',
        'land_unit_value',
        'land_value',
        'land_unit_value_key',
        'compliance_index_colony',
        'mayors_compliance_index',
        'grant_amount',
        'unit_price',
        'construction_unit_price',
    ];

    protected $casts = [
        'geo_shape' => 'array'
    ];

    public function constructionType(){
        return $this->belongsTo(ConstructionType::class);
    }
}
