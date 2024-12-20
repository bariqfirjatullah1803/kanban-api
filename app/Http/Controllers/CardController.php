<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CardController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $cards = Card::all();

        return $this->_apiResponse(true, 200, $cards, 'Retrieved successfully');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'position' => ['required', 'numeric'],
            'due_date' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'assign_user_id' => ['required', 'numeric', 'exists:users,id'],
            'card_id' => ['required', 'numeric', 'exists:cards,id'],
        ]);

        $card = Card::query()->create($validator->validated());

        return $this->_apiResponse(true, 200, $card, 'Created successfully');
    }

    /**
     * @param Card $card
     * @return JsonResponse
     */
    public function show(Card $card): JsonResponse
    {
        return $this->_apiResponse(true, 200, $card->toArray(), 'Retrieved successfully');
    }

    /**
     * @param Request $request
     * @param Card $card
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Card $card): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'position' => ['required', 'numeric'],
            'due_date' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'assign_user_id' => ['required', 'numeric', 'exists:users,id'],
            'card_id' => ['required', 'numeric', 'exists:cards,id'],
        ]);

        $card->update($validator->validated());
        return $this->_apiResponse(true, 200, $card->toArray(), 'Updated successfully');
    }

    /**
     * @param Card $card
     * @return JsonResponse
     */
    public function destroy(Card $card): JsonResponse
    {
        $card->delete();
        return $this->_apiResponse(true, 200, $card->toArray(), 'Deleted successfully');
    }
}
