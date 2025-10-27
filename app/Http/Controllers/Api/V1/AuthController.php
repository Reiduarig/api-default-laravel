<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\ApiLoginRequest;


class AuthController extends Controller
{
    use ApiResponses;

    public function login(ApiLoginRequest $request)
    {
        return $this->success($request->get('email'));
    }

    public function register()
    {
        return $this->success('register');
    }
}
