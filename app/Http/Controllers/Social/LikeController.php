<?php
namespace App\Http\Controllers\social;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\post;

class LikeController extends Controller
{
    //check the Authenication

    public function store(Post $post)
    {
        $post->like(current_user());
        return back();
    }

    public function destroy(Post $post)
    {
        $post->dislike(current_user());

        return back();
    }
    // public function toggleLikes($id)
    // {
    //     //Toggle Likes
    //     //return total Likers
    //     $user=$this->auth->toUser($this->auth->getToken);
    //     $post=Post::find($id);
    //     if($post&&$user)
    //     {
    //         $user->toggleLikes($post);
    //         return response()->json([
    //             'likes'=>$post->likers()->get()
    //         ]);
    //     }
    //     else
    //     {
    //         return response()->json([
    //             'errors'=>[
    //                 'root'=>'Could not find the post or User wasn\'t authenicated . '
    //             ]
    //         ]);
    //     }
    // }

    // public function getLikes($id)
    // {
    //     //Return Total Likers From Post
    //     $post=Post::find($id);
    //     if($post)
    //     {
    //         $user->toggleLikes($post);
    //         return response()->json([
    //             'likes'=>$post->likers()->get()
    //         ]);
    //     }
    //     else
    //     {
    //         return response()->json([
    //             'errors'=>[
    //                 'root'=>'Could not find the post . '
    //             ]
    //         ]);
    //     }
    // }
}