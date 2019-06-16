<?php

namespace App\Api\Auth\Controllers;

use App\Api\Auth\Requests\LoginRequest;
use App\Api\User\Repositories\UserRepository;
use App\Base\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * @Resource("Auth", uri="/auth")
 */
class AuthController extends Controller
{
    /**
     * Login
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * Register a new token with a `email` and `password`.
     *
     * @Post("/login")
     * @Versions({"v1"})
     * @Request({"email": "user@user.com", "password": "xpto"})
     * @Attributes({
     *      @Attribute("email", type="string", description="The email of the user", sample="user@user.com", required=true),
     *      @Attribute("password", type="string", description="The password of the user", sample="xpto", required=true)
     * })
     * @Transaction({
     *      @Response(200, body="json:auth/auth-login-response-200"),
     *      @Response(422, body="json:auth/auth-login-response-422"),
     *      @Response(401, body="json:auth/auth-login-response-401")
     * })
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            abort(401, trans(ResponseEnum::FAILED_CREDENTIALS));
        }

        return $this->responseData($this->resourceToken($token));
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * Destroy token.
     *
     * @Get("/logout")
     * @Versions({"v1"})
     * @Request(headers={"Authorization": "Bearer <token>"})
     * @Transaction({
     *      @Response(200, body="json:auth/auth-logout-response-200"),
     *      @Response(401, body="json:auth/auth-logout-response-401")
     * })
     */
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(true);

            return $this->responseMessage(ResponseEnum::SUCCESSFULLY_LOGGED_OUT);
        } catch (Exception $e) {
            abort(500, trans(ResponseEnum::FAILED_LOGOUT));
        }
    }

    /**
     * @param string $token
     *
     * @return array
     */
    private final function resourceToken(string $token): array
    {
        $objectToken  = JWTAuth::setToken($token);
        $decodedToken = JWTAuth::decode($objectToken->getToken());
        $expiration   = $decodedToken->get('exp');
        $createdAt    = $decodedToken->get('iat');

        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $expiration,
            'created_at'   => $createdAt
        ];
    }

    /**
     * @param string $token
     *
     * @return JsonResponse
     */
    public function getUserInfoByToken(string $token): JsonResponse
    {
        $user = JWTAuth::toUser($token);

        if (!$user) {
            abort(404, trans(ResponseEnum::RESOURCE_NOT_FOUND));
        }

        if (isset($user->roles) && $user->roles->first() !== null) {
            $user->roles->first()->permissions;
        }

        if (isset($user->group)) {
            $user->group->first();
        }

        return $this->responseData($user->toArray());
    }

    /**
     * @return JsonResponse
     */
    public final function refreshToken(): JsonResponse
    {
        try {
            return $this->responseData($this->resourceToken(JWTAuth::parseToken()->refresh()));
        } catch (JWTException $e) {
            abort(500, trans(ResponseEnum::FAILED_REFRESH_TOKEN));
        }
    }
}
