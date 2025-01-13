<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;


class PublicController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(9);
        return view('public.home', ['posts' => $posts]);
    }

    
}
