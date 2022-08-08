<?php

namespace App\Services;

use App\Enums\PriceTypes;
use App\Exceptions\EmptyCadastreElements;
use App\Models\Cadastre;
use App\Models\ConstructionPrice;
use App\Models\ConstructionType;
use DateInterval;
use Illuminate\Support\Facades\Cache;

class GetPriceM2ByZipCodeService
{
    protected ConstructionType $constructionType;
    protected int $zipCode;
    protected PriceTypes $priceType;

    public function __construct(ConstructionType $constructionType, int $zipCode, PriceTypes $priceType)
    {
        $this->constructionType = $constructionType;
        $this->zipCode = $zipCode;
        $this->priceType = $priceType;
    }

    /**
     * @throws EmptyCadastreElements
     */
    public function execute(): ConstructionPrice{
        if($fromCache = $this->getFromCache()){
            return $fromCache;
        }

        $query = Cadastre::where('zip_code', $this->zipCode)
            ->where('contruction_type_id', $this->constructionType->id);

        $elements = $query->count();
        if($elements <= 0){
            throw new EmptyCadastreElements;
        }

        $unitPrice = 0;
        $constructionUnitPrice = 0;
        switch ($this->priceType){
            case PriceTypes::AVG:
                $unitPrice = $query->avg('unit_price') ?? 0;
                $constructionUnitPrice = $query->avg('construction_unit_price') ?? 0;
                break;

            case PriceTypes::MAX:
                $unitPrice = $query->max('unit_price');
                $constructionUnitPrice = $query->max('construction_unit_price') ?? 0;
                break;

            case PriceTypes::MIN:
                $unitPrice = $query->min('unit_price') ?? 0;
                $constructionUnitPrice = $query->min('construction_unit_price') ?? 0;
                break;
        }

        return $this->saveConstructionPrice($unitPrice, $constructionUnitPrice, $elements);
    }

    protected function saveConstructionPrice(float $unitPrice, float $constructionUnitPrice, int $elements): ConstructionPrice{
        $constructionPrice = new ConstructionPrice;
        $constructionPrice->zip_code = $this->zipCode;
        $constructionPrice->construction_type_id = $this->constructionType->id;
        $constructionPrice->price_type = $this->priceType->value;
        $constructionPrice->unit_price = round($unitPrice, 2);
        $constructionPrice->construction_unit_price = round($constructionUnitPrice, 2);
        $constructionPrice->elements = $elements;
        $constructionPrice->save();
        return $constructionPrice;
    }

    protected function getFromCache(): ?ConstructionPrice{
        return Cache::remember($this->cacheKey(), new DateInterval('PT5M'), function (){
            return ConstructionPrice::where('zip_code', $this->zipCode)
                ->where('construction_type_id', $this->constructionType->id)
                ->where('price_type', $this->priceType->value)
                ->first();
        });
    }

    protected function cacheKey(): string {
        return $this->constructionType->slug . $this->zipCode . $this->priceType->value;
    }
}
