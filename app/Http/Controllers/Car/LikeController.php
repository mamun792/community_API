<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
        try{
            $user_id = auth()->user()->id;
            $post_id = $request->post_id;
            
            $existing_like = Like::where('user_id', $user_id)->where('post_id', $post_id)->exists();

            
            if ($existing_like) {
               
            
                // Delete like
                Like::where('user_id', $user_id)->where('post_id', $post_id)->delete();
            
                // Get the updated like count
                $like_counter = Like::where('post_id', $post_id)->count();

            
                return response()->json([
                    'status' => 'success',
                    'status_code' => 200,
                    'message' => 'Post unliked successfully',
                    'data' => $like_counter
                ], 200);
            } else {
                // Increase like count
                $like_increment =$like_count = Like::count('like_count');
               $like_increment = $like_increment + 1;
            
                // Save new like
                $like = new Like;
                $like->user_id = $user_id;
                $like->post_id = $post_id;
                $like->liked = 1;
                $like->like_count = $like_increment;
                $like->save();
            
                return response()->json([
                    'status' => 'success',
                    'status_code' => 201,
                    'message' => 'Post liked successfully',
                    'data' => $like
                ], 201);
            }
            

    }  catch(\Exception $e){
        return response()->json([
            'status' => 'error',
            'status_code' => 500,
            'message' => 'An error occurred',
            'errors' => $e->getMessage()
        ], 500);
    } 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
