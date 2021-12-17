<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class PostController extends Controller
{
    // post index
    public function index()
    {
        return response([
            'post'=> Post::orderBy('created_at','desc')->with('user:id,name,image')->withCount('comment','like')->get()
        ],200);
    }

    // get  single post 

    public function show()
    {
    return response(
        ['post'=>Post::where('id',$id)->withCount('comment','like')->get()],200
    );
    }

    // create post 
    public function store(Request $request)
    {
        // validates

        $attrs=$request->validate([
            'body'=>'required|string'
        ]);
        $post=Post::create([
            'body'=>$attrs['body'],
            'user_id'=>auth()->user()->id
        ]);

        return response([
            'message'=>'Post  Created',
            'post'=>$post
        ],200);
    }

     // Update post 
     public function update(Request $request ,$id)
     {
         $post=Post::find($id);

        if (!$post) {
           return response([
               'message'=>'Post Not  Fond'
           ],404);
        }

        if ($post->user_id!=auth()->user()->id) {
            return response([
                'message'=>'Permison  Denied'
            ],403);
        }
         // validates
 
         $attrs=$request->validate([
             'body'=>'required|string'
         ]);

         //update  post
         $post->update([
            'body' =>  $attrs['body']
        ]);
 
         return response([
             'message'=>'Post  Created',
             'post'=>$post
         ],200);
     }
     //Delete Post  

     public function destroy($id)
     {
        $post=Post::find($id);

        if (!$post) {
           return response([
               'message'=>'Post Not  Fond'
           ],404);
        }

        if ($post->user_id!=auth()->user()->id) {
            return response([
                'message'=>'Permison  Denied'
            ],403);
        }

        $post->commnet()->delete();
        $post->like()->delete();
        $post->delete();

        return response([
            'message'=>'Post Deleted',
            
        ],200);
     }
    
}
