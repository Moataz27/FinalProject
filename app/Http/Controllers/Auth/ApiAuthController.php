<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => 'required|max:100|string',
            "email" => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8|max:100',
            'image' => 'nullable|mimes:png,jpg,jpeg,jfif|file'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $img = ($request->hasFile('image')) ? Storage::putFile('images', $request->image) : public_path('uploads/images/default.jfif');

        $imgPath = public_path('uploads') . $img;
        // return response()->json($imgPath);

        $access_token = Str::random(64);
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "image" => $imgPath,
            "access_token" => $access_token,
        ]);

        return response()->json([
            'access_token' => $access_token,
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'gender' => $user->gender,
            'image' => $user->image,
        ], 201);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "email" => 'required|email',
            'password' => 'required|string|min:8|max:100'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if($user !== null){
            if(Hash::check($request->password, $user->password)){
                $access_token = Str::random(64);
                $user->update([
                    'access_token' => $access_token
                ]);

                return response()->json([
                    'access_token' => $access_token,
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ], 200);
            } else{
                return response()->json([
                    'error' => "Cerdantial Are incorrect",
                ], 200);
            }
        }else{
            return response()->json([
                'error' => "Cerdantial Are incorrect",
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        $access_token = $request->header('access_token');
        $user = user::where('access_token', '=', $access_token)->first();

        $user->update([
            'access_token' => null
        ]);

        return response()->json([
            'msg' => "You Logged Out",
        ], 200);
    }
}


