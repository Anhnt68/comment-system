<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use JWTAuth;

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
            dump($request);
            // Lấy token từ request
            $token = $request->token;

            // Giải mã token để lấy dữ liệu
            $tokenData = JWTAuth::decode($token);
            $content = $tokenData['data'];

            // Tạo mới đối tượng Comment và lưu vào cơ sở dữ liệu
            $comment = new Comment();
            $comment->fill($request->all());
            $comment->content = $content; // Gán dữ liệu từ token vào comment
            $comment->save();

            // Trả về phản hồi thành công
            return response()->json(['success' => true, 'message' => 'Comment created successfully', 'token' => $token]);
        } catch (\Exception $exception) {
            // Ghi log nếu có lỗi
            Log::error($exception->getMessage());
            // Trả về thông báo lỗi
            return response()->json(['success' => false, 'message' => 'Failed to create comment']);
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
