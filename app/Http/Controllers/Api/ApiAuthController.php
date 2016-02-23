<?php

namespace BiboBlog\Http\Controllers\Api;

use BiboBlog\Http\Controllers\Api\ApiBaseController;
use BiboBlog\Http\Requests\ApiSigninRequest;
use BiboBlog\Repository\UserRepository;
use Illuminate\Http\Request;
use BiboBlog\Http\Requests;
use JWTAuth;


class ApiAuthController extends ApiBaseController
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }

    /**
     * Handles the login request.
     * @param SigninRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(ApiSigninRequest $request)
    {
        $code = 422;
        $response['data'][] = 'Invalid Credentials';
        try {

            // Grab credentials from the request.
            $credentials = $request->only('username', 'password');


            // Attempt to verify the credentials and create a token for the user.
            $response = JWTAuth::attempt($credentials);
            $code = 200;

        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token.
            $code = 500;
            $response = $e->getMessage();
        } catch (Exception $e) {
            // Server Error
            $code = 500;
            $response = $e->getMessage();
        }

        return $this->xhr($response, $code);
    }

}
