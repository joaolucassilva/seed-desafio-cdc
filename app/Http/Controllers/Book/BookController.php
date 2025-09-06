<?php

declare(strict_types=1);

namespace App\Http\Controllers\Book;

use App\Actions\Book\StoreBookAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BookController extends Controller
{
    public function __construct(
        private readonly StoreBookAction $storeBookAction,
    ) {}

    public function store(StoreBookRequest $request): JsonResponse
    {
        try {
            $this->storeBookAction->__invoke($request->toDto());

            return response()->json();
        } catch (Exception $e) {
            report($e);

            return response()->json(['message' => 'Erro ao criar livro'], Response::HTTP_BAD_REQUEST);
        } catch (Throwable $th) {
            report($th);

            return response()->json(['message' => 'Erro ao criar livro'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
