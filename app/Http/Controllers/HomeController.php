<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CaffeineTrack;
use App\Drink;

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
        $diary = CaffeineTrack::select('drinks.name', 'drinks.id', 'caffeine_content as caffeine', 'drinks.descr', 'drinks.servings as servings_per_container', 'caffeine_tracking.servings as servings_had', 'caffeine_tracking.created_at as date_ingested')
            ->leftJoin('drinks', 'drink_id', '=', 'drinks.id')
            ->whereDate('caffeine_tracking.created_at', '=', $today->format('Y-m-d'))
            ->where('user_id', $request->user()->id)
            ->get();
        $overview = $this->collateDiary($diary, $request);
        return view('home', [
            'diary' => $diary,
            'overview' => $overview,
            'select' => $this->getDrinks(),
        ]);
    }
    /**
     * Create the overview - we'll figure out how much _total_ caffeine the user has had
     * per drink, then subtract that from their personal max caffeine amount.
     */
    private function collateDiary($diary, Request $request){
        if($diary->isEmpty()){
            $diary = Drink::all();
        }
        $res = [];
        foreach($diary as $drink){
            $shot = !empty($drink->servings_had) ? $drink->servings_had * $drink->caffeine : 0;
            $res[$drink->id]['name'] = $drink->name;
            $res[$drink->id]['drink_id'] = $drink->id;
            $res[$drink->id]['total_caffeine_ingested'] = !empty($res[$drink->id]['total_caffeine_ingested']) ? $res[$drink->id]['total_caffeine_ingested'] + $shot : $shot;
            $res[$drink->id]['left'] = !empty($res[$drink->id]['left']) ? $res[$drink->id]['left'] - $shot : $request->user()->max_caffeine - $shot;
            $res[$drink->id]['class_name'] = $res[$drink->id]['left'] <= 0 ? " alert alert-danger" : "";
        }
        return $res;
    }
    /**
     * Format and return the drinks for use in the combobox on the data entry
     */
    private function getDrinks(){
        $drinks = Drink::all();
        $res = [];
        foreach($drinks as $drink){
            $res[$drink->id] = "{$drink->name} ({$drink->caffeine_amount}mg) - {$drink->servings} servings per container";
        }
        return $res;
    }
}
