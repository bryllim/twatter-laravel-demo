<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function create(Request $request)
    {
        $reply = new Reply();
        $reply->content = $request->content;
        $reply->user_id = $request->user_id;
        $reply->twat_id = $request->twat_id;

        $reply->save();

        return redirect()->route('home')->with('success', "Reply posted!");
    }

    public function delete($id)
    {
        $reply = Reply::find($id);

        if(Auth::user()->id == $reply->user->id){
            $reply->delete();
            return redirect()->route('home')->with('success', "Reply deleted!");
        }else{
            return redirect()->route('home');
        }
    }
}
