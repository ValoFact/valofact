<?php

namespace App\Http\Controllers\blog;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostFormRequest;
use App\Models\BlogCategory;
use App\Models\BlogMedia;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        $user = FacadesRequest::user();
        $blogCategory = BlogCategory::find($request->validated('blog_category_id'));
        $validatedData = $request->validated();
        $data = ['published_at' => now()->format('m/d/Y'), 'user_id' => $user->id] + $validatedData;
        //creating the blogpost model
        $blogPost = BlogPost::create($data);
        //medias treatment
        if(!empty($data['medias'])){
            foreach($data['medias'] as $media):
                $mediaFile = /**@var UploadedFile|null */ $media['file'];
                if($mediaFile !== null && !$mediaFile->getError()){
                    $mediaData = ['blog_post_id' => $blogPost->id] + ['path' => $mediaFile->store('blog', 'public')];
                    $mediaModel = BlogMedia::create($mediaData);
                    $medias[] = $mediaModel;
                }
            endforeach;
        }
        //associating relations
        $blogPost->medias()->saveMany($medias);
        $blogCategory->blogPosts()->save($blogPost);
        $user->blogPosts()->save($blogPost);
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
        $validatedData = $request->validated();
        $data = ['published_at' => now()->format('m/d/Y')] + $validatedData;
        //deleting old medias records
        foreach($blogPost->medias as $media){
            Storage::disk('public')->delete($media->path);
        }
        $blogPost->medias->each->delete();
        //new medias treatment
        if(!empty($data['medias'])){
            foreach($data['medias'] as $media):
                $mediaFile = /**@var UploadedFile|null */ $media['file'];
                if($mediaFile !== null && !$mediaFile->getError()){
                    $mediaData = ['blog_post_id' => $blogPost->id] + ['path' => $mediaFile->store('blog', 'public')];
                    $mediaModel = BlogMedia::create($mediaData);
                    $medias[] = $mediaModel;
                }
            endforeach;
        }
        //blogpost model update
        $blogPost->update($data);
        //blogpost relations update
        $blogPost->medias()->saveMany($medias);

        //redirect to blogpost show page with a success message
    }


    /**
     * Remove a specific blogpost
     */
    public function destroy(BlogPost $blogPost)
    {
        //deleting medias records
        foreach($blogPost->medias as $media){
            Storage::disk('public')->delete($media->path);
        }
        $blogPost->delete();

       //redirect to the blogposts listing page with a success message
    }


}