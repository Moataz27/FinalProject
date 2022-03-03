<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\post;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function create($id, Request $request){
        
        $validator = Validator::make($request->all(),[
            'comment'=>'required|string|min:1|max:255',
        ]);

        if($validator){
            $access_token = $request->header('access_token');
            $user = User::where('access_token', '=', $access_token)->first();
            $post = post::find($id);
            $comment = Comment::create([
                'comment' => $request->comment,
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            if($comment)
            {
                return response()->json(['data'=>$comment]);
            }
            else
            {
                return response()->json([
                    'errors'=>[
                        'root'=>$validator
                    ]
                ]);
            }
        }
    }
}
