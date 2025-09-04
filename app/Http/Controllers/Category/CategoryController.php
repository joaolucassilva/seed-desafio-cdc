<?php

declare(strict_types=1);

namespace App\Http\Controllers\Category;

use App\Actions\Category\StoreCategoryAction;
use App\Exceptions\CategoryException;
use App\Exceptions\CategoryNameInvalid;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct(
        private readonly StoreCategoryAction $storeCategoryAction,
    ) {
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $this->storeCategoryAction->__invoke($request->validated('name'));

            return response()->json();
        } catch (CategoryNameInvalid) {
            return response()->json([
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                ],
                'message' => 'The name field is required.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (CategoryException) {
            return response()->json([
                'errors' => [
                    'name' => [
                        'Category already exists'
                    ],
                ],
                'message' => 'Category already exists'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
