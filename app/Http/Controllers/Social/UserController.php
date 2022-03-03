<?php

namespace App\Http\Controllers\social;
use Illuminate\Http\Request;
use  App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function dates()
    {
        return response()->json([
            'created_at'=>auth()->User()->created_at->diffForHumans(),
            'updated_at'=>auth()->User()->updated_at->diffForHumans(),
        ]);
    }

    function search($name)
    {
        $result = User::where('name', 'LIKE', '%'. $name. '%')->get();
        if(count($result)){
            return response()->json($result);
        }
        else
        {
            return response()->json(['Result' => 'No Data not found'], 404);
        }
    }



    public function update(Request $request,$id)
    {
        $user=User::Find($id);
        if($user)
        {
            $validate = $request->validate([
                "name" => 'required|max:100|string',
                "email" => 'required|email|unique:users,email',
            ]);

            $user->name=$request['name'];
            $user->email=$request['email'];
            $user->save();
            return response([
                'success'=>true,
                'data' => $user,
                'msg' => "Updated Successfully"
            ],200);
        }
        else
        {
            return response()->json([
                'errors'=>'could not update your details'
            ]);
        }
    }


    public function changePassword(Request $request,$id)
    {
        $user=User::Find($id);
        if($user)
        {
            if(Hash::check($request['oldpassword'],$user->password))
            {
                $validate= $request->validate([
                    'password'=>'required|confirmed|min:8|max:100'
                ]);
                if($validate){
                    $user->password=Hash::make($request['password']);
                    $user->save();
                    return response()->json([
                        'success'=>true,
                        'msg' => 'Password Updated Successfully'
                    ]);
                }
                else
                {
                    return response()->json([
                        'errors'=>
                        [
                            'root' => $validate
                        ]
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'errors'=>
                    [
                        'root' => 'Please Enter Your Current Password'
                    ]
                ]);
            }
        }
    }
}
