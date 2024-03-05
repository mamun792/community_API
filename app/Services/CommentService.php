<?php
namespace App\Services;

use App\Models\Comment;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;


class CommentService
{
    public function index()
    {
        try{
            $comments = Comment::with('user')->paginate(5);

            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'message' => 'Comments retrieved successfully',
                'data' => $comments->items(),
                'meta' => [
                    'total' => $comments->total(),
                    'currentPage' => $comments->currentPage(),
                    'perPage' => $comments->perPage(),
                    'lastPage' => $comments->lastPage(),
                    'from' => $comments->firstItem(),
                    'to' => $comments->lastItem(),
                ]
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'status_code' => 500,
                'message' => 'An error occurred',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function store(CommentRequest $request)
    {
        try{
            $validated = $request->validated();

            $comment = new Comment;
            $comment->content = $request->content;
            $comment->user_id = auth()->user()->id;
            $comment->post_id = $request->post_id;
            $comment->save();

            return response()->json([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Comment created successfully',
                'data' => $comment
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'status_code' => 500,
                'message' => 'An error occurred',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try{
            $comment = Comment::with('user')->find($id);

            if(!$comment){
                return response()->json([
                    'status' => 'error',
                    'status_code' => 404,
                    'message' => 'Comment not found',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'message' => 'Comment retrieved successfully',
                'data' => new CommentResource($comment)
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'status_code' => 500,
                'message' => 'An error occurred',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function update(CommentRequest $request, string $id)
    {
        try{
            $validated = $request->validated();

            $comment = Comment::findOrFail($id);
            $comment->content = $request->content;
            $comment->save();

            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'message' => 'Comment updated successfully',
                'data' => $comment
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'status_code' => 500,
                'message' => 'An error occurred',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        $delete = Comment::findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
            'status_code' => 200,
            'message' => 'Comment deleted successfully',
        ], 200);
    }
}