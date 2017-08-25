<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
	/**
     * show posts of this tag
     *
     * @param \App\Tag
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Tag $tag)
    {
    	$posts = $tag->posts;

    	return view('posts.tagshow', compact('posts', 'tag'));
    }//
}
