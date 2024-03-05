<?php

namespace App\Services;

use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Image as ImageModel;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ImageRequest;

class PostService
{
    public function index()
    {
        try{
            $posts= Post::withCount(['likes', 'comments'])
            ->with(['images' => function ($query) {
                $query->select('id', 'post_id', 'image');
            }])
            ->paginate(5);

            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'message' => 'Posts retrieved successfully',
                'data' => PostResource::collection($posts),
                'meta' => [
                    'total' => $posts->total(),
                    'currentPage' => $posts->currentPage(),
                    'perPage' => $posts->perPage(),
                    'lastPage' => $posts->lastPage(),
                    'from' => $posts->firstItem(),
                    'to' => $posts->lastItem(),
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

    public function store (PostRequest $request)
    {
        try{
            $validated = $request->validated();

            $post = new Post;
            $post->title = $request->title;
             $post->description = $request->description;
             $post->price = $request->price;
             $post->location = $request->location;
             $post->model = $request->model;
             $post->year = $request->year;
             $post->user_id = Auth::user()->id;
             $post->save();

           

            return response()->json([
                'status' => 'success',
                'status_code' => 201,
                'message' => 'Post created successfully',
                'data' => $post
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
            $post = Post::withCount(['likes', 'comments'])
            ->with(['images' => function ($query) {
                $query->select('id', 'post_id', 'image');
            }])
            ->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'message' => 'Post retrieved successfully',
                'data' => new PostResource($post)
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

    public function uploadImage(ImageRequest $request){
        try {
            $validated = $request->validated();
            
            $post = Post::findOrFail($request->post_id); 
            
            $images = [];
            
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $imagePath =substr(md5(time()), 0, 10) . '.' . $image->extension();
    
                    $image->move(public_path('images'), $imagePath);
                    
                    $imageModel = new ImageModel;
                    $imageModel->image = $imagePath;
                    $imageModel->post_id = $post->id;
                    $imageModel->save();
                    
                    $images[] = $imageModel;
                }
                
               
                $post->images()->saveMany($images);
                
                return response()->json([
                    'status' => 'success',
                    'status_code' => 201,
                    'message' => 'Images uploaded successfully',
                    'data' => $images
                ], 201);
            } else {
                return response()->json([
                    'status' => 'error',
                    'status_code' => 400,
                    'message' => 'No images were provided',
                ], 400);
            }
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'status_code' => 500,
                'message' => 'An error occurred',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    public function getComments(string $id){
        try{
            $post = Post::findOrFail($id);

            $comments = $post->comments()->with(['user'=>function($query){
             $query->select('id','name');
            }])->get();

            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'message' => 'Comments retrieved successfully',
                'data' => $comments
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

    public function getLikes(string $id){
        try{
            $post = Post::findOrFail($id);
            $likes = $post->likes()->with(['user'=>function($query){
             $query->select('id','name');
            }])->get();
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'message' => 'Likes retrieved successfully',
                'data' => $likes
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
       
}
