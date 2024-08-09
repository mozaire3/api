<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function show($id)
    {
        if (Category::where('id', $id)->exists()) {
            $user = Category::findOrFail($id);
            return response()->json($user);
        } else {
            return response(["message" => "category doesnot exist"], 401);
        }
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required','unique:categories'],
            'parent_id' => ['exists:categories,parent_id']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad params',
                'error' => $validator->messages(),
            ], 422);
        } else {
            $category = Category::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id
            ]);

            return response()->json([
                "message" => "category added",
                "category" => $category
            ], 201);
        }
       
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'parent_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad params',
                'error' => $validator->messages(),
            ], 422);
        } else {
            $category = Category::findOrFail($id);
            $category->update([
                "name" => $request->name,
                "parent_id" => $request->parent_id

            ]);


            // On retourne la réponse JSON
            return response()->json([
                "message" => "updated category",

            ], 201);
        }
    }


    public function destroy($id)
    {

        $category = Category::find($id);

        // $category->delete();

        return response()->json(["message" => "deleted"], 201);
    }
}
