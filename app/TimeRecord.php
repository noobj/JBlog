<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class TimeRecord extends Model
{
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'checkouted_time'
    ];

    // returns the instance of the user who is author of that post
    public function category()
    {
		return $this->belongsTo('App\TimeCategory', 'category_id');
    }

    public function scopeToday($query)
    {
		$query->whereDate('created_at', \Carbon\Carbon::today());
    }

    public function duriation()
    {
    	$checkedAt = Carbon::parse($this->checkouted_time);
    	$createdAt = Carbon::parse($this->created_at);

        if($checkedAt == null) $checkedAt = Carbon::now();

		return $createdAt->diff($checkedAt)->format('%hh %im %ss');
    }
}
