<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Order;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request as FacadesRequest;

class PublicController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $order = new Order();
        if(array_key_first(FacadesRequest::query()) !== null){
            $order = Order::find(array_key_first(FacadesRequest::query()))->with('items', 'orderMedias')->get()[0];
        }
        //dd($order);
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(9);
        return view('public.home', ['posts' => $posts, 'order' => $order]);
    }

    
}
