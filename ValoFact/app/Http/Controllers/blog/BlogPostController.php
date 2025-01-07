<?php

namespace App\Http\Controllers\blog;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostFormRequest;
use App\Models\BlogPost;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the blogposts
     */
    public function index()
    {
        $blogPosts = BlogPost::orderBy('published_at', 'desc')->paginate(6);
        //redirect to the posts listing page
    }


    /**
     * Show the form for creating a new blogpost.
     */
    public function create()
    {
        //redirect to the creating post page
    }


    /**
     * Store a newly created blogpost in storage.
     */
    public function store(BlogPostFormRequest $request)
    {
        $publishedAt = ['published_at' => now()->format('m/d/Y')];
        $data = $publishedAt + $request->validated();

        $blogPost = BlogPost::create($data);

        //reditrect to blogpost show page with a success message
    }

    
    /**
     * Display a specific blogpost
     */
    public function show(BlogPost $blogPost)
    {
       //redirect to the post page
    }


    /**
     * Show the form for editing a specific blogpost.
     */
    public function edit(BlogPost $blogPost)
    {
        //redirect to the editing post page
    }


    /**
     * Store a newly updated blogpost in storage.
     */
    public function update(BlogPostFormRequest $request, BlogPost $blogPost)
    {
        $publishedAt = ['published_at' => now()->format('m/d/Y')];
        $data = $publishedAt + $request->validated();

        $blogPost->update($data);

        //redirect to blogpost show page with a success message
    }


    /**
     * Remove a specific blogpost
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

       //redirect to the blogposts listing page with a success message
    }


}