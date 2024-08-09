<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }


    public function show($id)
    {
        if (User::where('id', $id)->exists()) {
            $user = User::findOrFail($id);
            return response()->json($user);
        } else {
            return response(["message" => "user doesnot exist"], 401);
        }
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'unique:users'],
            'email' => ['required', 'unique:users', 'regex:/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
            'age' => 'required|numeric',
            'password' => ['required', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/'],

        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad params',
                'error' => $validator->messages(),
            ], 422);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->age = $request->age;
            $user->password = $request->password;
            if ($request->isadmin) {
                $request->validate([
                    'isadmin' => 'boolean'
                ]);

                $user->isadmin = $request->isadmin;
            }
            $user->save();

            return response()->json(["message" => "user created succesfully"], 201);
        }
    }


    public function update(Request $request, $id)
    {

        if (User::where('id', $id)->exists()) {
            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [

                'name' => ['required', 'string', 'regex:/^([A-Za-z0-9\-\_\s]+)$/'],
                'email' => 'required|email',
                // 'age' => 'required|numeric',
                'currentpassword' => 'required'

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Bad params',
                    'error' => $validator->messages(),
                ], 422);
            } else {
                if ($request->input('password')) {

                    $request->validate([

                        'newpassword' => ['required', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/'],
                        'password_confirmation' => 'required_with:password',
                    ]);
                    if (Hash::check($request->input('currentpassword'), $user->password)) {


                        $user->update([
                            'name' => request('name'),
                            'email' => request('email'),
                            // 'age' => request('age'),
                            'password' => request('newpassword')

                        ]);

                        return response(["message" => "updated succesfully"], 201);
                    } else {

                        return response(["message" => "current password incorect"], 401);
                    }
                } else {

                    if (Hash::check($request->input('currentpassword'), $user->password)) {

                        $user->update([

                            'name' => request('name'),
                            'email' => request('email'),
                            'age' => request('age')
                        ]);

                        return response(["message" => "updated succefully"], 201);
                    } else {

                        return response(["message" => "current password incorrect"], 401);
                    }
                }
                return response()->json($user);
            }
        } else {
            return response(["message" => "user doesnot exist"], 401);
        }
    }

    public function destroy($id)
    {

        if (User::where('id', $id)->exists()) {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(["message" => "user deleted succesfully"], 200);
        } {
            return response()->json(["message" => "user doestnot exist"], 401);
        }
    }
}
