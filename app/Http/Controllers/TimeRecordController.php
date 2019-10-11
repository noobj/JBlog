<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\TimeRecord;
use App\TimeCategory;

class TimeRecordController extends Controller
{
	/**
	 * index controll
	 *
	 * @param string
	 * @return \Illuminate\Http\Response
	 */
    public function list(string $date = 'today')
    {
		//fetch 5 posts from database which are active and latest
		$date = str_replace('_', '-', $date);
		$date =  \Carbon\Carbon::parse($date);
		$records = TimeRecord::Today()->where('done', 1)->orderBy('created_at', 'desc')->paginate(5);

		$current = TimeRecord::Today()->where('done', 0)->first();
    	//page heading
    	$title = 'T.I.M.E';
    	//return home.blade.php template from resources/views folder
		return view('time_record.list', compact('records', 'current'))->withTitle($title);
    }
}
