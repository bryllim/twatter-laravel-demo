<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{

    public function create(Request $request)
    {
        $newReaction = new Reaction;
        $newReaction->reaction = $request->reaction;
        $newReaction->user_id = Auth::user()->id;
        $newReaction->twat_id = $request->twat_id;
        $newReaction->save();
        return redirect()->route('home')->with('success', "Reaction added!");
    }
}
