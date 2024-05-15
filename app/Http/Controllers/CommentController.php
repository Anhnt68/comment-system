<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
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
            $comments = $request->all();
            $urlHash = md5(url()->to('/'));
            $comments['url'] = $urlHash;
            $domain = $comments['url'];
            $urlModel = \App\Models\Url::firstOrCreate(['url' => $domain]);
            $comment = new \App\Models\Comment();
            $comment->url_id = $urlModel->id;
            $comment->fill($comments);
            $comment->save();

            return response()->json([
                'success' => true,
                'message' => 'Comment created successfully',
                'comment' => $comment
            ]);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create comment'
            ], 500);
        }
    }


    public function sendDataToOtherAPI($comment, $user, $username, $password)
    {
        try {
            $response = Http::withBasicAuth('anhnt683@gmail.com', 'anhnt683@gmail.com')->post('http://127.0.0.1:8000/api/comment/', [
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

//    public function store(Request $request)
//    {
//        try {
//            $comments = $request->comment;
//            $domain = $comments['url'];
//            $urlModel = \App\Models\Url::where('url', $domain)->first();
//
//            if (!$urlModel) {
//                $newUrlModel = new \App\Models\Url();
//                $newUrlModel->url = $domain;
//                $newUrlModel->save();
//                $urlId = $newUrlModel->id;
//            } else {
//                $urlId = $urlModel->id;
//            }
//            $comment = new Comment();
//            $comment->url_id = $urlId;
//            $comment->fill($comments);
//            $comment->save();
//            return response()->json(['success' => true, 'message' => 'Comment created successfully','comment'=>$comment]);
//        } catch (\Exception $exception) {
//            Log::error($exception->getMessage());
//            return response()->json(['success' => false, 'message' => 'Failed to create comment']);
//        }
//    }
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
