<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeRecord extends Model
{
    // returns the instance of the user who is author of that post
    public function category()
    {
    	return $this->belongsTo('App\TimeCategory','category_id');
    }
}
