<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $comments = Comment::with('replies')->whereNull('parent_id')->orderBy('created_at', 'DESC')->get();
        return view('home', compact('comments'));

    }


    public function store(Request $request)
    {
        dd($request);
        try {
            $model = new Comment();
            $model->fill($request->all());
            $model->save();
            return response()->json(['success' => true, 'message' => 'Comment created successfully', 'comment' => $model]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to create comment']);
        }
    }
}
