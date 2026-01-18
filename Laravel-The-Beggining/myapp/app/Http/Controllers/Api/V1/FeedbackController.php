<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Feedback::with(['user', 'category', 'tags', 'comments']);

        // Применяем query scopes
        if ($request->has('published') && $request->boolean('published')) {
            $query->published();
        }

        if ($request->has('min_rating')) {
            $query->highRating($request->integer('min_rating'));
        }

        if ($request->has('recent') && $request->boolean('recent')) {
            $query->recent();
        }

        $feedbacks = $query->paginate(15);

        return response()->json([
            'data' => FeedbackResource::collection($feedbacks),
            'meta' => [
                'current_page' => $feedbacks->currentPage(),
                'last_page' => $feedbacks->lastPage(),
                'per_page' => $feedbacks->perPage(),
                'total' => $feedbacks->total(),
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
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'nullable|integer|min:0|max:5',
            'is_published' => 'nullable|boolean',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ]);

        $feedback = Feedback::create($validated);

        if ($request->has('tag_ids')) {
            $feedback->tags()->attach($request->tag_ids);
        }

        return response()->json([
            'data' => new FeedbackResource($feedback->load(['user', 'category', 'tags'])),
            'message' => 'Feedback created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback): JsonResponse
    {
        return response()->json([
            'data' => new FeedbackResource($feedback->load(['user', 'category', 'tags', 'comments.user'])),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'category_id' => 'sometimes|exists:categories,id',
            'title' => 'sometimes|string|max:255',
            'message' => 'sometimes|string',
            'rating' => 'nullable|integer|min:0|max:5',
            'is_published' => 'nullable|boolean',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ]);

        $feedback->update($validated);

        if ($request->has('tag_ids')) {
            $feedback->tags()->sync($request->tag_ids);
        }

        return response()->json([
            'data' => new FeedbackResource($feedback->load(['user', 'category', 'tags'])),
            'message' => 'Feedback updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback): JsonResponse
    {
        $feedback->delete(); // Мягкое удаление

        return response()->json([
            'message' => 'Feedback deleted successfully',
        ]);
    }

    /**
     * Get comments for a specific feedback.
     */
    public function comments(Feedback $feedback): JsonResponse
    {
        $comments = $feedback->comments()->with('user')->recent()->get();

        return response()->json([
            'data' => \App\Http\Resources\CommentResource::collection($comments),
        ]);
    }

    /**
     * Attach tags to feedback.
     */
    public function attachTags(Request $request, Feedback $feedback): JsonResponse
    {
        $validated = $request->validate([
            'tag_ids' => 'required|array',
            'tag_ids.*' => 'exists:tags,id',
        ]);

        $feedback->tags()->syncWithoutDetaching($validated['tag_ids']);

        return response()->json([
            'data' => new FeedbackResource($feedback->load('tags')),
            'message' => 'Tags attached successfully',
        ]);
    }
}
