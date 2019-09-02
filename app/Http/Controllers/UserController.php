<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
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
    public function store(Request $request){
        $validatedData = $request->validate([
            'drink_id' => 'required|numeric',
            'servings' => 'required|numeric',
        ]);
        $user = User::findOrFail($request->user()->id);
        $drink = Drink::findOrFail($request->drink_id);
        $track = new CaffeineTrack();
        $track->drink_id = $drink->id;
        $track->user_id = $user->id;
        $track->caffeine_content = $drink->caffeine_amount;
        $track->servings = $request->servings;
        if($track->save()){
            if($request->ajax()){
                $ret = [
                    'servings' => $request->servings,
                    'caffeine_content' => $drink->caffeine_amount,
                    'drink_name' => $drink->name,
                    'drink_id' => $drink->id,
                    'when' => (new \DateTime('now', new \DateTimeZone($request->user()->time_zone)))->format('g:i a'),
                    'max_caffeine' => $request->user()->max_caffeine,
                    'success' => true,
                ];
                return response()->json(['results' => $ret]);
            }
            return redirect()->route('home');
        }
    }
}
