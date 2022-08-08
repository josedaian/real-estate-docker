<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class EmptyCadastreElements extends ApiException
{
    protected $message = 'Empty cadastre elements';
    protected $customCode = 'cadastre.empty_elements';
    protected $code = Response::HTTP_NOT_FOUND;
}
