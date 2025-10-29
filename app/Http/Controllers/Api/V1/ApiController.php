<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\Controller;
use App\Services\API\V1\ApiResponseService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends Controller
{

    use AuthorizesRequests;

    protected $policyClass;

    /**
     * Verifica si el usuario actual tiene autorización para realizar una acción específica
     * Utiliza las políticas definidas para cada controlador
     */
    public function isAble($ability, $targetModel)
    {
        return $this->authorize($ability, [$targetModel, $this->policyClass]);
    }
}
