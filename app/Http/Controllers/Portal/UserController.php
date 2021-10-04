<?php

namespace App\Http\Controllers\Portal;

use App\Models\Conversation;
use App\Models\PromotionalDesignation;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function references(?User $user, Request $request)
    {
        $user = $user->exists ? $user : auth()->user();
        $designations = PromotionalDesignation::query();

        $childs = $user->childs()->pluck('id')->toArray();

        $referencesUsers = User::query()
            ->where('designation_id', $request->designation)
            ->whereIn('id', $childs)
            ->withCount([
                'childs as registered_count' => function(Builder $builder){
                    $builder->registered();
                },
                'childs as unregistered_count' => function(Builder $builder){
                    $builder->unRegistered();
                }
            ]);

        $designations->whereNotNull('required_designation_id')
            ->withCount(['users' => function(Builder $builder) use($childs){

                $builder->whereIn('id', $childs);
            }]);

        return view('portal.user.references', compact('user'), [
            'designations' => $designations->get(),
            'reference_users' => $referencesUsers->get()
        ]);
    }

    public function sendSms(User $user)
    {
        $conversation = $user->conversations()->personal()->first();

        if(!$conversation){
            /** @var Conversation $conversation */
            $conversation = Conversation::create([]);

            $conversation->users()->attach([$user->id, auth()->id()]);
        }

        return redirect()->route('portal.conversations.show', $conversation);
    }
}
