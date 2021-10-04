<?php

namespace App\Http\Controllers\Portal;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConversationController extends Controller
{
    public function show(Conversation $conversation)
    {
        /** @var Collection $users */
        $users = $conversation->users()->where('user_id', '<>', auth()->id())->get();

        $userNames = $users->map(function (User $u){

            return $u->fullName();
        })->implode(', ');


        return view('portal.conversation.show', compact('conversation'), compact('userNames'));
    }
}
