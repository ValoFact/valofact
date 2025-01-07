<?php

namespace App\Http\Controllers\blog;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryFormRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the blogcategories
     */
    public function index()
    {
        $blogPosts = BlogCategory::orderBy('published_at', 'desc')->paginate(6);
        //redirect to the categories listing page
    }


    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        //redirect to the creating category page
    }


    /**
     * Display a specific blogcategory
     */
    public function show(BlogCategory $blogCategory)
    {
       //redirect to the category page
    }


    /**
     * Store a newly created blogcategory in storage.
     */
    public function store(BlogCategoryFormRequest $request)
    {
        $publishedAt = ['published_at' => now()->format('m/d/Y')];
        $data = $publishedAt + $request->validated();

        $blogPost = BlogCategory::create($data);

        //reditrect to blogpost show page with a success message
    }


    /**
     * Show the form for editing a specific category.
     */
    public function edit(BlogCategory $blogCategory)
    {
        //redirect to the editing category page
    }


    /**
     * Store a newly updated blogcategory in storage.
     */
    public function update(BlogCategoryFormRequest $request, BlogCategory $blogCategory)
    {
        $publishedAt = ['published_at' => now()->format('m/d/Y')];
        $data = $publishedAt + $request->validated();

        $blogCategory->update($data);

        //redirect to blogcategory show page with a success message
    }


    /**
     * Remove a specific blogcategory
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

       //redirect to the blogcategories listing page with a success message
    }


}