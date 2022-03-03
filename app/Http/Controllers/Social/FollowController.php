<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class FollowController extends Controller
{
    public function store(User $user)
    {
        auth()->user()->togglefollow($user);
        return back();
    }


    // public function toggleFollow($id)
    // {
    //     //$authencatied=$this->auth->toUser($this->aurh->getToken);
    //     $followedUSer=User::find($id);
    //     //if($authencteduser->toggleFollow($FollowedUser) )
    //     return response()->json([
    //         'data'=>[
    //             'Follower'=>AuthencatedUser->Following->get()
    //         ]
    //     ]);

    // }

    // public function followers($id)
    // {
    //     $user=User::Find($id);
    //     if($user)
    //     {
    //         return response()->json([
    //             'data'=>[
    //                 'Followers'=>$user->followers
    //             ]
    //         ]);
    //     }
    //     else
    //     {
    //         return response()->json([
    //             'errors'=>[
    //                 'root'=>'This User does not exist'
    //             ]
    //         ]);
    //     }
    // }
    // public function isFollowingEachOther($id)
    // {
    //     //check auth and get the token
    //     $authenicatedUser=$this->auth->toUser($this->auth->getToken());
    //     $followedUSer=User::Find($id);
    //     //checks if the followeed user is exist
    //     if($Followeduser)
    //     {
    //         if($authenicatedUser->areFollowingEachOther($FollowedUser))
    //         {
    //             return response()->json([
    //                 'data'=>$authenicatedUser->areFollowingEachOther($FollowedUser)
    //             ]);
    //         }
    //         else
    //         {
    //             return response()->json([
    //                 'data'=>$authenicatedUser->areFollowingEachOther($FollowedUser)
    //             ]);
    //         }

    //     }
    //    else
    //     return response()->json([
    //         'errors'=>
    //         [
    //             'root'=>'You Aren not following each other or u gave the wrong user id.'
    //         ]
    //     ]);

    // }


}