<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Drink;
use App\CaffeineTrack;

class UserController extends Controller
{
    /**
     * Take in the caffeine from the drink.
     * Note that the api route is making use of the Auth middleware,
     * so by the time this hits the user should be logged in
     * and authenticated.
     *
     * @param $id   The drink ID
     * @return void
     */
    public function imbibe($id, $servings, Request $request){

        dd($request->user());

        // $user = User::findOrFail(Auth::user());
        $drink = Drink::findOrFail($id);
        $track = new CaffeineTrack();
        $track->drink_id = $drink->id;
        $track->user_id = $user->id;
        $track->caffeine_content = $drink->caffeine_amount;
        $track->servings = $servings;
        $track->save();
    }
}
