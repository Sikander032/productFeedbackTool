<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\UserComment;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbackItems = Feedback::with(['user', 'category'])
            ->paginate(1000); // Adjust the pagination as needed.

        return response()->json($feedbackItems);
    }
    public function getFeedbackCategories()
    {
        $categories = FeedbackCategory::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|exists:feedback_categories,id',
        ]);

        // Create feedback
        $feedback = new Feedback($validated);
        $request->user()->feedback()->save($feedback);

        return response()->json(['message' => 'Feedback submitted successfully!'], 200);
    }

    public function addComment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
            'itemId' => 'required|integer|exists:feedback,id'
        ]);

        try {
            $feedback = Feedback::findOrFail($request->itemId);

            $comment = new UserComment();
            $comment->user_id = auth()->user()->id;
            $comment->feedback_id = $feedback->id;
            $comment->comment = $request->comment;
            $comment->save();

            return response()->json(['message' => 'Comment added successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add comment', 'error' => $e->getMessage()], 500);
        }
    }


    public function getCommentsByFeedbackId(Request $request)
    {
        // Retrieve the feedbackId from the query parameters
        $feedbackId = $request->query('feedbackId');

        // Query the comments based on the feedbackId
        $comments = UserComment::with('user')
            ->where('feedback_id', $feedbackId)
            ->get();

        return response()->json(['comments' => $comments]);
    }



}
