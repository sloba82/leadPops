<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateJwtRequest;
use Illuminate\Http\Response;
use Jwt;
use Session;
use App\Model\User;
use Exception;


use App\Services\UserService;


class JwtController extends Controller
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CreateJwtRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateJwtRequest $request)
    {
        $input = $request->validated();
        $response = [];
        try {
            $response = $this->userService->generateUserToken($input);
        } catch (Exception $e) {
            $response['message'] = 'Something went wrong.';
        }

        return response()->json($response);
    }
}
