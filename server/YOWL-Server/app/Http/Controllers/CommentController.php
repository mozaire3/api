<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index()
    {
        $comment = Comment::orderBy('id','DESC')->get();
       
        return response()->json($comment);
    }

    public function show($id)
    {
        if (Comment::where('id', $id)->exists()) {
            $user = Comment::findOrFail($id);
            return response()->json($user);
        } else {
            return response(["message" => "comment doesnot exist"], 401);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required','exists:users,name'],
            'post_id' => ['required','exists:posts,id'],
            'content' => 'required',
            'parent_id' => ['exists:comments,id']
        ]);

       

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad params',
                'error' => $validator->messages(),
            ], 422);
        } else {
            $comment = new Comment();
            $comment->content = $request->content;
            $comment->post_id = $request->post_id;
            $comment->username = $request->username;
            if($request->parent_id){
                $comment->parent_id = $request->parent_id;

            }
            
    
            $comment->save();
            return $comment;
    
            // return response()->json(["message" => "created succefully"], 201);
        }

     

    }


    public function update(Request $request, $id)
    {

        if (Comment::where('id', $id)->exists()) {

            $comment = Comment::findOrFail($id);

            // La validation de données
            $validator = Validator::make($request->all(), [
                'content' => 'required'
            ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad params',
                'error' => $validator->messages(),
            ], 422);
        } else {
            $comment->update([
                "content" => request('content')
            ]);

            return response()->json([
                "message" => "updated comment",

            ], 201);
        }
            
        } else {
            return response(["message" => "comment doesnot exist"], 401);
        }
    }


    public function destroy($id)
    {

        if (Comment::where('id', $id)->exists()) {
            $comment = Comment::find($id);
            $comment->delete();
            return response()->json(["message" => "comment deleted"], 201);
           
        } else {
            return response(["message" => "comment doesnot exist"], 401);
        }
    }
}
