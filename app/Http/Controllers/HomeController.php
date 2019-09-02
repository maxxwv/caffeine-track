<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CaffeineTrack;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $today = new \DateTime('today', new \DateTimeZone($request->user()->time_zone));
        $diary = CaffeineTrack::select('drinks.name', 'drinks.id', 'caffeine_content as caffeine', 'drinks.descr', 'drinks.servings as servings_per_container', 'caffeine_tracking.servings as servings_had', 'caffeine_tracking.created_at as date_ingested', 'users.max_caffeine')
            ->leftJoin('drinks', 'drink_id', '=', 'drinks.id')
            ->leftJoin('users', 'user_id', '=', 'users.id')
            ->whereDate('caffeine_tracking.created_at', '=', $today->format('Y-m-d'))
            ->where('user_id', $request->user()->id)
            ->get();
        $overview = $this->collateDiary($diary);
        return view('home', ['diary' => $diary, 'overview' => $overview]);
    }
    /**
     * Create the overview - we'll figure out how much _total_ caffeine the user has had
     * per drink, then subtract that from their personal max caffeine amount.
     */
    private function collateDiary($diary){
        $res = [];
        foreach($diary as $drink){
            $shot = $drink->servings_had * $drink->caffeine;
            $res[$drink->id]['name'] = $drink->name;
            $res[$drink->id]['drink_id'] = $drink->id;
            $res[$drink->id]['total_caffeine_ingested'] = !empty($res[$drink->id]['total_caffeine_ingested']) ? $res[$drink->id]['total_caffeine_ingested'] + $shot : $shot;
            $res[$drink->id]['left'] = !empty($res[$drink->id]['left']) ? $res[$drink->id]['left'] - $shot : $drink->max_caffeine - $shot;
            $res[$drink->id]['class_name'] = $res[$drink->id]['left'] >= $drink->max_caffeine ? " warning" : "";
        }
        return $res;
    }
}
