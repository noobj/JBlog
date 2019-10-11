<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\TimeRecord;
use App\TimeCategory;

class TimeRecordController extends Controller
{
    public function list()
    {
    	//fetch 5 posts from database which are active and latest
    	$records = TimeRecord::where('done', 0)->orderBy('created_at', 'desc')->paginate(5);
    	//page heading
    	$title = 'T.I.M.E';
    	//return home.blade.php template from resources/views folder
    	return view('time_record.list', compact('records'))->withTitle($title);
    }
}
