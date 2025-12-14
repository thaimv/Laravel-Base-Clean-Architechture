<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\VerifyTokenRequest;
use App\Http\Resources\JwtAuthResource;
use App\Http\Resources\UserResource;
use App\Domain\Services\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseController
{
    public function __construct(
        protected AuthServiceInterface $authService,
    ) {
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="User login",
     *     description="Authenticate user and return JWT token",
     *     operationId="login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", ref="#/components/schemas/JwtAuth")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function login(LoginRequest $request)
    {
        try {
            $params = $request->validated();
            $data = $this->authService->login($params);

            return $this->responseSuccess(JwtAuthResource::make($data));
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * @OA\Post(
     *     path="/refresh-token",
     *     summary="Refresh JWT token",
     *     description="Get a new JWT token using current valid token",
     *     operationId="refreshToken",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", ref="#/components/schemas/JwtAuth")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function refreshToken()
    {
        try {
            $data = $this->authService->refreshToken();

            return $this->responseSuccess(JwtAuthResource::make($data));
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * @OA\Get(
     *     path="/get-me",
     *     summary="Get current user",
     *     description="Get authenticated user information",
     *     operationId="getMe",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function getMe()
    {
        try {
            return $this->responseSuccess(UserResource::make(Auth::user()));
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Logout user",
     *     description="Invalidate current JWT token",
     *     operationId="logout",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function logout()
    {
        try {
            $this->authService->logout();

            return $this->responseSuccess([]);
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * @OA\Post(
     *     path="/forgot-password",
     *     summary="Forgot password",
     *     description="Send password reset email to user",
     *     operationId="forgotPassword",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset email sent",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            $this->authService->forgotPassword($params['email']);
            DB::commit();

            return $this->responseSuccess([]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->handleException($exception);
        }
    }

    /**
     * @OA\Post(
     *     path="/verify-token",
     *     summary="Verify reset token",
     *     description="Verify if password reset token is valid",
     *     operationId="verifyToken",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "token"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="token", type="string", example="abc123token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token is valid",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid or expired token"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function verifyToken(VerifyTokenRequest $request)
    {
        try {
            return $this->responseSuccess([]);
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }
    }

    /**
     * @OA\Post(
     *     path="/reset-password",
     *     summary="Reset password",
     *     description="Reset user password using valid token",
     *     operationId="resetPassword",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "token", "password", "password_confirmation"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="token", type="string", example="abc123token"),
     *             @OA\Property(property="password", type="string", format="password", example="newpassword123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid or expired token"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            $params = $request->validated();
            $this->authService->resetPassword($params);
            DB::commit();

            return $this->responseSuccess([]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->handleException($exception);
        }
    }
}
