<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LikesController extends Controller
{
    public function index()
    {
        $likes = Likes::all();
        return response()->json($likes);
    }

    public function show($id)
    {
        if (Likes::where('id', $id)->exists()) {
            $user = Likes::findOrFail($id);
            return response()->json($user);
        } else {
            return response(["message" => "lies doesnot exist"], 401);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required','exists:users,id'],
            'post_id' => ['required','exists:posts,id']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad params',
                'error' => $validator->messages(),
            ], 422);
        } else {

            $like = new Likes();
            $like->user_id = $request->user_id;
            $like->post_id = $request->post_id;


            $like->save();

            return response()->json(["message" => "liked succefully"], 201);
        }
    }


    public function update(Request $request, $id)
    {


        if (Likes::where('id', $id)->exists()) {

            $like = Likes::findOrFail($id);

            // La validation de données
            $validator = Validator::make($request->all(), [
                'user_id' => ['required','exists:users,id'],
                'post_id' => ['required','exists:posts,id']
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Bad params',
                    'error' => $validator->messages(),
                ], 422);
            } else {
    
                $like->user_id = $request->user_id;
                $like->post_id = $request->post_id;
    
    
                // On retourne la réponse JSON
                return response()->json([
                    "message" => "updated like",
    
                ], 201);
            }


        } else {
            return response(["message" => "like not exist"], 401);
        }
    }
}
