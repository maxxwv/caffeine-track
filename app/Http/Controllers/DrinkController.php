<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Drink;
use App\Http\Resources\Drink as DrinkResource;
use App\Http\Resources\DrinkCollection as DrinkCollection;

class DrinkController extends Controller
{
    /**
     * Return the entire database of drinks in JSON format
     *
     * @return DrinkCollection
     */
    public function index(){
        return new DrinkCollection(drink::all());
    }
    /**
     *
     */
    public function show($id){
        return new PlayerResource(Player::findOrFail($id));
    }
}
