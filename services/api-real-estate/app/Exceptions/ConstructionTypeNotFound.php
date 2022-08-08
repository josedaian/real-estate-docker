<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ConstructionTypeNotFound extends ApiException
{
    protected $message = 'Construction Type (%s) not found';
    protected $customCode = 'construction_type.not_found';
    protected $code = Response::HTTP_NOT_FOUND;

    public function __construct(?int $constructionType)
    {
        parent::__construct(sprintf($this->getMessage(), $constructionType), $this->code);
    }
}
