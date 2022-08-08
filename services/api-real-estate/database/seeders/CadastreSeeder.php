<?php

namespace Database\Seeders;

use App\Models\Cadastre;
use App\Models\ConstructionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

class CadastreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!App::environment('REQUIRE_CSV')){
            return true;
        }

        LazyCollection::make(function () {
            $handle = fopen(public_path("gustavo-madero.csv"), 'r');

            while (($line = fgetcsv($handle, 4096)) !== false) {
                if(count($line) < 13 || $this->ensureHasValidValues($line)){
                    continue;
                }
                yield $line;
            }

            fclose($handle);
        })
        ->skip(1)
        ->chunk(10)
        ->each(function (LazyCollection $chunk) {
            $records = $chunk->map(function ($row) {
                \Log::info(__METHOD__, ['currentRow' => $row]);
                $contructionType = ConstructionType::whereSlug(Str::slug($row[7]))->first();
                if(!$contructionType){
                    return null;
                }

                $landValue = floatval(!empty($row[12]) ? $row[12] : 0);
                $grantAmount = floatval(@$row[16] ?? 0);
                return [
                    'fid' => $row[0],
                    'geo_shape' => $row[1],
                    'address' => $row[2],
                    'zip_code' => $row[3],
                    'suburb' => $row[4],
                    'ground_surface' => $row[5],
                    'construction_surface' => $row[6],
                    'contruction_type_id' => $contructionType->id,
                    'level_range_key' => $row[8],
                    'construction_year' => empty($row[9]) ? null : $row[9],
                    'special_facilities' => $row[10] === 'Sí',
                    'land_unit_value' => empty($row[11]) ? 0 : $row[11],
                    'land_value' => $landValue,
                    'land_unit_value_key' => $row[13],
                    'compliance_index_colony' => $row[14],
                    'mayors_compliance_index' => @$row[15] ?? 0,
                    'grant_amount' => $grantAmount,
                    'unit_price' => $row[5] > 0 ? ($landValue - $grantAmount) / $row[5] : 0,
                    'construction_unit_price' => ($row[6] > 0) ? ($landValue - $grantAmount) / $row[6] : 0
                ];
            })->toArray();

            $records = array_filter($records, function($row){
                return null !== $row;
            });

            \DB::table('cadastre')->insert($records);
        });
    }

    public function ensureHasValidValues(array $row): bool{
        return Cadastre::whereFid($row[0])->whereAddress($row[2])->exists()
            || empty($row[0])
            || empty($row[3])
            || empty($row[7]);
    }
}
