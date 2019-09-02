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
        $diary = CaffeineTrack::select('name', 'caffeine_content as caffeine', 'drinks.descr', 'drinks.servings as servings_per_container', 'caffeine_tracking.servings as servings_had', 'caffeine_tracking.created_at as date_ingested', 'users.max_caffeine')
            ->leftJoin('drinks', 'drink_id', '=', 'drinks.id')
            ->whereYear('caffeine_tracking.created_at', '=', $today->format('Y'))
            ->whereMonth('caffeine_tracking.created_at', '=', $today->format('m'))
            ->whereDay('caffeine_tracking.created_at', '=', $today->format('d'))
            ->where('user_id', $request->user()->id)
            ->orderBy('drinks.id')
            ->get();
        $res = [];
        foreach($diary as $item){
            $res[$item->id]['total_caffeine_ingested'] += $item->caffeine;
            $res[$item->id]['total_servings_had'] += $item->servings_had;
            $res[$item->id]['name'] = $item->name;
            $res[$item->id]['description'] => $item->descr;
        }
        return view('home', ['diary' => $diary]);
        // return view('home', ['diary' => $diary]);
    }
}
