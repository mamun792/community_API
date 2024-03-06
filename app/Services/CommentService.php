<?php
namespace App\Services;

use App\Models\Comment;
use App\Http\Resources\CommentResource;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class CommentService
{
  protected function jsonResponse($status, $status_code, $message, $data = null){
        return response()->json([
            'status' => $status,
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data
        ], $status_code);
  }

    public function index()
    {
        try{
           
           $comments = Comment::with('user')->paginate(5);
            $meta = [
                'total' => $comments->total(),
                'currentPage' => $comments->currentPage(),
                'perPage' => $comments->perPage(),
                'lastPage' => $comments->lastPage(),
                'from' => $comments->firstItem(),
                'to' => $comments->lastItem(),
            ];
          
           $response = [
                'comments' => CommentResource::collection($comments),
                'meta' => $meta
            ];

            return $this->jsonResponse('success', Response::HTTP_OK, 'Comments retrieved successfully', $response);
         

        }catch(\Exception $e){
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
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

           return $this->jsonResponse('success', Response::HTTP_CREATED, 'Comment created successfully', new CommentResource($comment));

        }catch(\Exception $e){
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
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

            return $this->jsonResponse('success', Response::HTTP_OK, 'Comment retrieved successfully', new CommentResource($comment));

        }catch(\Exception $e){
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
        }
    }

    public function update(CommentRequest $request, string $id)
    {
        try{
            $validated = $request->validated();

            $comment = Comment::findOrFail($id);
            $comment->content = $request->content;
            $comment->save();

            return $this->jsonResponse('success', Response::HTTP_OK, 'Comment updated successfully', new CommentResource($comment));
        }catch(\Exception $e){
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try{
            $comment = Comment::findOrFail($id);
            $comment->delete();
            return $this->jsonResponse('success', Response::HTTP_OK, 'Comment deleted successfully');
        }catch(\Exception $e){
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
        }
        
    }
}