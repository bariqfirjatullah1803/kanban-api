<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BoardController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $boards = Board::all();

        return $this->_apiResponse(true, 200, $boards, 'retrieved successfully');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'visibility' => ['required', 'boolean'],
        ]);

        $board = Board::query()->create($validator->validated());

        return $this->_apiResponse(true, 201, $board, 'created successfully');
    }

    /**
     * @param Board $board
     * @return JsonResponse
     */
    public function show(Board $board): JsonResponse
    {
        return $this->_apiResponse(true, 200, $board->toArray(), 'retrieved successfully');
    }

    /**
     * @param Request $request
     * @param Board $board
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Board $board): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'visibility' => ['required', 'boolean'],
        ]);

        $board->update($validator->validated());

        return $this->_apiResponse(true, 201, $board->toArray(), 'updated successfully');
    }

    /**
     * @param Board $board
     * @return JsonResponse
     */
    public function destroy(Board $board): JsonResponse
    {
        $board->delete();
        return $this->_apiResponse(true, 200, $board->toArray(), 'deleted successfully');
    }
}
