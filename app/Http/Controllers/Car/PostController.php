<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

use App\Http\Requests\ImageRequest;
use App\Services\PostService;

class PostController extends Controller
{
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
   
    public function index()
    {
       
        return $this->postService->index();     
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
    public function store(PostRequest $request)
    {

        return $this->postService->store($request);
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->postService->show($id);
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

   
    public function uploadImage(ImageRequest $request)
{
    return $this->postService->uploadImage($request);
    
}

   public function getComments(string $id)
   {
      return $this->postService->getComments($id);
   }
   
   public function getLikes(string $id)
   {
        return $this->postService->getLikes($id);
     }
        
}

