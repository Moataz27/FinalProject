<?php
namespace App\Http\Controllers\Social;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function index ()
    {
        $post=Post::orderBy('Created_at')->get();
        return response()->json(['posts'=>$post]);
    }

    public function getPostsFromUser($id)
    {
        $post=Post::where('user_id',$id)->with('comments')->get();
        return response()->json(['post' => $post , 'count'=>count($post)]);
    }
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'content'=>'required|min:3|max:255',
            'image' => 'nullable|file|mimes:png,jpg,jpeg,jfif'
        ]);

        if($validator)
        {
            $access_token = $request->header('access_token');
            $CurrentUser = user::where('access_token', '=', $access_token)->first();
            if($request->hasFile('image'))
            {
                $img = Storage::putFile('Post', $request->image);
                $imgPath = public_path('uploads') . $img;
            } else{
                $imgPath = null;
            }
            $post=Post::Create
            (
                [
                    'content'=>$request->content,
                    'user_id'=>$CurrentUser->id,
                    'image' => $imgPath,
                    'isEdited'=>false
                ]
            );
            if($post)
            {
                return response()->json(['data'=>$post]);
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
    public function update($id,Request $request)
    {
        $post=Post::Find($id);
        $validator = Validator::make($request->all(),[
            'content'=>'required|min:3|max:255'
        ]);
        if($validator)
        {
            $post->content=$request->content;
            $post->isEdited = true;
            $post->save();
            //  to Retrive All Posts
            // $posts=Post::orderBy('Created_at')->get();
            return response()->json(['post'=>$post]);
        }
        else
        {
            return response()->json
            (
                [
                    'errors'=>
                    [
                        'root'=>$validator
                    ]
                ]
            );
        }


    }

    public function delete($id)
    {
        $deletedpost=Post::destroy($id);
        $posts=Post::orderBy('Created_at')->get();
        if($deletedpost)
        {
            return response()->json([
                'posts'=>$posts
            ]);
        }

    }
}
