<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\{UserCreateRequest,UserVerifyRequest};
use App\Actions\{CreateUserAction,VerifyUserAction};
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;
use OpenApi\Attributes as OA;

final class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    #[OA\Get(
        path: "/api/v1/users",
        summary: "List Users",
        tags: ["User"],
        responses: [
            new OA\Response(response: 200, description: "Users listed successfully.")
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection($this->userService->getAll())->additional(['message' => 'Success']);
    }

    #[OA\Post(
        path: "/api/v1/users",
        summary: "Create a User",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "John"),
                    new OA\Property(property: "last_name", type: "string", example: "Doe"),
                    new OA\Property(property: "email", type: "string", example: "johndoe@example.com"),
                    new OA\Property(property: "password", type: "string", example: "123456789")
                ],
                type: "object"
            )
        ),
        tags: ["User"],
        responses: [
            new OA\Response(response: 202, description: "User created successfully.")
        ]
    )]
    public function store(UserCreateRequest $request, CreateUserAction $action): JsonResponse
    {
        $action->execute($request->toDTO());
        return $this->successResponse(__('messages.user_created'));
    }

    #[OA\Post(
        path: "/api/v1/users/verify",
        summary: "Verify User Credentials",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "email", type: "string", example: "johndoe@example.com"),
                    new OA\Property(property: "password", type: "string", example: "123456789")
                ],
                type: "object"
            )
        ),
        tags: ["User"],
        responses: [
            new OA\Response(response: 200, description: "User successfully verified.")
        ]
    )]
    public function verifyCredentials(UserVerifyRequest $request, VerifyUserAction $action): JsonResponse
    {
        return $this->successResponse(__('messages.user_verified'), $action->execute($request->payload()));
    }
}
