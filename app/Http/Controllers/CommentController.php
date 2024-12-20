<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $comments = Comment::all();

        return $this->_apiResponse(true, 200, $comments, 'Retrieved successfully');
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'card_id' => ['required', 'integer', 'exists:cards,id'],
            'content' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id']
        ]);

        $comment = Comment::query()->create($validator->validated());

        return $this->_apiResponse(true, 201, $comment, 'Created successfully');
    }


    /**
     * @param Comment $comment
     * @return JsonResponse
     */
    public function show(Comment $comment): JsonResponse
    {
        return $this->_apiResponse(true, 200, $comment->toArray(), 'Retrieved successfully');
    }


    /**
     * @param Request $request
     * @param Comment $comment
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'card_id' => ['required', 'integer', 'exists:cards,id'],
            'content' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id']
        ]);

        $comment->update($validator->validated());
        return $this->_apiResponse(true, 201, $comment->toArray(), 'Updated successfully');
    }


    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();
        return $this->_apiResponse(true, 200, $comment->toArray(), 'Deleted successfully');
    }
}
