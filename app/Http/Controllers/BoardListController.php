<?php

namespace App\Http\Controllers;

use App\Models\BoardList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BoardListController extends Controller
{

    public function index(): JsonResponse
    {
        $boardLists = BoardList::all();

        return $this->_apiResponse(true, 200, $boardLists, 'Retrieved successfully');
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
            'board_id' => ['required', 'integer', 'exists:boards,id'],
            'position' => ['required', 'integer'],
        ]);

        $boardList = BoardList::query()->create($validator->validated());

        return $this->_apiResponse(true, 201, $boardList, 'Created successfully');
    }

    /**
     * @param BoardList $boardList
     * @return JsonResponse
     */
    public function show(BoardList $boardList): JsonResponse
    {
        return $this->_apiResponse(true, 200, $boardList->toArray(), 'retrieved successfully');
    }

    /**
     * @param Request $request
     * @param BoardList $boardList
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, BoardList $boardList): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'board_id' => ['required', 'integer', 'exists:boards,id'],
            'position' => ['required', 'integer'],
        ]);

        $boardList->update($validator->validated());

        return $this->_apiResponse(true, 200, $boardList->toArray(), 'updated successfully');
    }

    /**
     * @param BoardList $boardList
     * @return JsonResponse
     */
    public function destroy(BoardList $boardList): JsonResponse
    {
        $boardList->delete();
        return $this->_apiResponse(true, 200, $boardList->toArray(), 'deleted successfully');
    }
}
