<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Drink extends Model
{
    protected $fillable = ['name', 'description', 'caffeine', 'servings'];
  /**
   * Create the drinks table
   *
   * @return void
   */
    public function up(){
        Schema::create('drinks');
        Schema::table('drinks', function(Blueprint $table){
            $table->string('name', 256);
            $table->longText('description');
            $table->integer('caffeine')->default(0);
            $table->decimal('servings')->default(1);
            $table->timestamps();
        });
    }
    /**
     * Drop the table on a down
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('drinks');
    }
}
