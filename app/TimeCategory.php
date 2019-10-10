<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeCategory extends Model
{
	public $timestamps = false;

    // category has many posts
    public function records()
    {
        return $this->hasMany('App\TimeRecord','category_id');
    }
}
