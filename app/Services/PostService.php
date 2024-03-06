<?php

namespace App\Services;

use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Image as ImageModel;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ImageRequest;
use Illuminate\Http\Response;

class PostService
{
    public function jsonResponse($status, $status_code, $message, $data = null){
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
            $posts= Post::withCount(['likes', 'comments'])
            ->with(['images' => function ($query) {
                $query->select('id', 'post_id', 'image');
            }])
            ->paginate(5);

            $response=[
                'posts' => PostResource::collection($posts),
                'meta' => [
                    'total' => $posts->total(),
                    'currentPage' => $posts->currentPage(),
                    'perPage' => $posts->perPage(),
                    'lastPage' => $posts->lastPage(),
                    'from' => $posts->firstItem(),
                    'to' => $posts->lastItem(),
                ]
            ];

            return $this->jsonResponse('success', Response::HTTP_OK, 'Posts retrieved successfully', $response);
                

        }catch(\Exception $e){
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
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

           

            return $this->jsonResponse('success', Response::HTTP_CREATED, 'Post created successfully', new PostResource($post));
        }catch(\Exception $e){
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
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

            return $this->jsonResponse('success', Response::HTTP_OK, 'Post retrieved successfully', new PostResource($post));
        }catch(\Exception $e){
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
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
                
                return $this->jsonResponse('success', Response::HTTP_CREATED, 'Images uploaded successfully', $images);
            } else {
                return $this->jsonResponse('error', Response::HTTP_BAD_REQUEST, 'No image uploaded');
            }
        } catch(\Exception $e) {
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
        }
    }
    public function getComments(string $id){
        try{
            $post = Post::findOrFail($id);

            $comments = $post->comments()->with(['user'=>function($query){
             $query->select('id','name');
            }])->get();

            return  $this->jsonResponse('success', Response::HTTP_OK, 'Comments retrieved successfully', $comments);
        }catch(\Exception $e){
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
        }
    }

    public function getLikes(string $id){
        try{
            $post = Post::findOrFail($id);
            $likes = $post->likes()->with(['user'=>function($query){
             $query->select('id','name');
            }])->get();
            return $this->jsonResponse('success', Response::HTTP_OK, 'Likes retrieved successfully', $likes);
        }catch(\Exception $e){
            return $this->jsonResponse('error', Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred', $e->getMessage());
        }
    }
       
}
