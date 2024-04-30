<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
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
            $comment = $request->all();
            $user = auth()->user();
            $users = $user->only(['id', 'name', 'email', 'password']);
            $username = $user->name;
            $password = $user->password;
            $response = $this->sendDataToOtherAPI($comment, $users, $username, $password);
            if ($response['success']) {
                $commentData = $response['comment'];
                $commentData['user'] = $username;
                return response()->json([
                    'success' => true,
                    'comment' => $commentData,
                ]);
            } else {
                dump(2);
                throw new \Exception('Failed to send data to other application');
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create comment'
            ]);
        }
    }

    public function sendDataToOtherAPI($comment, $user, $username, $password)
    {
        try {
            $response = Http::withBasicAuth($username, $password)->post('http://127.0.0.1:8000/api/comment/', [
                'comment' => $comment,
                'user' => $user
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception('Failed to send data to other application');
            }
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
