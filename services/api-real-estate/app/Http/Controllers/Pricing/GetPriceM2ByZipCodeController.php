<?php

namespace App\Http\Controllers\Pricing;

use App\Enums\PriceTypes;
use App\Exceptions\ConstructionTypeNotFound;
use App\Exceptions\EmptyCadastreElements;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConstructionPriceResource;
use App\Models\ConstructionType;
use App\Services\GetPriceM2ByZipCodeService;
use Illuminate\Http\Request;

class GetPriceM2ByZipCodeController extends Controller
{
    /**
     * @throws EmptyCadastreElements
     * @throws ConstructionTypeNotFound
     */
    public function __invoke(Request $request, string $zipCode, string $priceType)
    {
        $constructionType = ConstructionType::find($request->get('construction_type'));
        if(!$constructionType){
            throw new ConstructionTypeNotFound($request->get('construction_type'));
        }
        $service = new GetPriceM2ByZipCodeService($constructionType, $zipCode, PriceTypes::from($priceType));

        return $this->apiResponse(new ConstructionPriceResource($service->execute()));
    }
}
