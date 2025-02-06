<?php

namespace App\Http\Controllers\V1;

use App\Actions\CreateUserAction;
use App\Actions\VerifyUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserVerifyRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;
use Throwable;

final class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}


    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="List Users",
     *     tags={"User"},
     *     @OA\Response(response=200, description="Users listed successfully.")
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection($this->userService->getAll())->additional(['message' => 'Success']);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Create a User",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                 @OA\Property(property="password", type="string", example="123456789"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=202, description="User created successfully.")
     * )
     * @throws Exception
     * @throws Throwable
     */
    public function store(UserCreateRequest $request, CreateUserAction $action): JsonResponse
    {
        $action->execute($request->toDTO());
        return $this->successResponse(__('messages.user_created'));
    }


    /**
     * @OA\Post(
     *     path="/api/v1/users/verify",
     *     summary="Verify User Credentials",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                 @OA\Property(property="password", type="string", example="123456789"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="User successfully verified.")
     * )
     * @throws Throwable
     */
    public function verifyCredentials(UserVerifyRequest $request, VerifyUserAction $action): JsonResponse
    {
        return $this->successResponse(__('messages.user_verified'), $action->execute($request->payload()));
    }

}
