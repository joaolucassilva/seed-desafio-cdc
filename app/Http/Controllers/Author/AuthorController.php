<?php

declare(strict_types=1);

namespace App\Http\Controllers\Author;

use App\Actions\Author\StoreAuthorAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreAuthorRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthorController extends Controller
{
    public function __construct(
        private readonly StoreAuthorAction $storeAuthorAction,
    ) {}

    public function store(StoreAuthorRequest $request): JsonResponse
    {
        try {
            $this->storeAuthorAction->__invoke($request->toDto());

            return response()->json();
        } catch (Throwable $e) {
            report($e);

            return response()->json(['message' => 'erro ao criar autor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
