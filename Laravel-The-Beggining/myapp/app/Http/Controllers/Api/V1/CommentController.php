<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Comment::with('user');

        if ($request->has('recent') && $request->boolean('recent')) {
            $query->recent();
        }

        if ($request->has('active') && $request->boolean('active')) {
            $query->active();
        }

        // Фильтрация по типу комментариев (полиморфная связь)
        if ($request->has('commentable_type')) {
            $query->where('commentable_type', $request->commentable_type);
        }

        if ($request->has('commentable_id')) {
            $query->where('commentable_id', $request->commentable_id);
        }

        $comments = $query->paginate(15);

        return response()->json([
            'data' => CommentResource::collection($comments),
            'meta' => [
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'per_page' => $comments->perPage(),
                'total' => $comments->total(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer',
        ]);

        // Проверяем существование модели
        $modelClass = $validated['commentable_type'];
        
        // Если передан короткий класс, добавляем пространство имен
        if (!str_contains($modelClass, '\\')) {
            $modelClass = 'App\\Models\\' . $modelClass;
        }
        
        if (!class_exists($modelClass)) {
            return response()->json([
                'message' => 'Invalid commentable type',
            ], 422);
        }

        $model = $modelClass::findOrFail($validated['commentable_id']);

        $comment = $model->comments()->create([
            'user_id' => $validated['user_id'],
            'content' => $validated['content'],
        ]);

        return response()->json([
            'data' => new CommentResource($comment->load('user')),
            'message' => 'Comment created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): JsonResponse
    {
        return response()->json([
            'data' => new CommentResource($comment->load(['user', 'commentable'])),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'sometimes|string',
        ]);

        $comment->update($validated);

        return response()->json([
            'data' => new CommentResource($comment->load('user')),
            'message' => 'Comment updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete(); // Мягкое удаление

        return response()->json([
            'message' => 'Comment deleted successfully',
        ]);
    }
}
