<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $comment = new Comment();
            $comment->fill($request->all());
            $user = auth()->user();
            $content =  $request->content;

            $payload =[
                'data' => $content
            ];

            $token = JWTAuth::fromUser($user, $payload);
            return response()->json([
                'success' => true,
                'message' => 'Comment created successfully',
                'comment' => $comment,
                'token' => $token
            ]);
        } catch (\Exception $exception) {
            // Ghi log nếu có lỗi
            Log::error($exception->getMessage());
            // Trả về thông báo lỗi
            return response()->json([
                'success' => false,
                'message' => 'Failed to create comment'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
