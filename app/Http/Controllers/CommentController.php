<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Http;

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
            $comment->save();
            $user = auth()->user();
            return response()->json([
                'success' => true,
                'message' => 'Done',
                'comment' => $comment,
                'user' => $user
            ]);

//            $content = $request->content;
//
//            $payload = [
//                'data' => $content
//            ];
//            $token = JWTAuth::fromUser($user, $payload);
//            $response = $this->sendDataToOtherAPI($comment, $token);
//            return $response;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create comment'
            ]);
        }
    }

    public function sendDataToOtherAPI($comment, $token)
    {
        try {

            $response = Http::post('http://127.0.0.1:6600/comment/store', [
                'token' => $token,
                'comment' => $comment->toArray(),
            ]);

            $data = $response->json();
            var_dump($data);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send data to other application: ' . $e->getMessage()
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
