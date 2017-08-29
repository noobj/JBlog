<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Post;
use App\User;
use App\Tag;
use App\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PostController extends Controller
{
	public function index()
	{
		//fetch 5 posts from database which are active and latest
		$posts = Post::where('active', 1)->orderBy('created_at', 'desc')->paginate(5);
		//page heading
		$title = 'Latest Possst';
		//return home.blade.php template from resources/views folder
		return view('home', compact('posts'))->withTitle($title);
	}

	public function create(Request $request)
	{
		// if user can post i.e. user is admin or author
		if($request->user()->can_post())
		{
			$tagList = Tag::pluck('name', 'name');
			return view('posts.create', compact('tagList'));
		}
		else
		{
			return redirect('/')->withErrors('You have not sufficient permissions for writing post');
		}
	}

	public function store(PostFormRequest $request)
	{
		$post = new Post();
		$post->title = $request->get('title');
		$post->body = $request->get('body');
		$post->slug = Str::slug($post->title);
		$post->author_id = $request->user()->id;



		if($request->has('save'))
		{
			$post->active = 0;
			$message = 'Post saved successfully';
		}
		else
		{
			$post->active = 1;
			$message = 'Post published successfully';
		}
		$post->save();

		if($request->input('tags')) {
            $this->syncTags($post, $request->input('tags'));
        }

		return redirect('/'.$post->slug)->withMessage($message);
	}

	/**
     * sync up the list of tags in the database
     *
     * @param Record $post
     * @param array $tags
     * @return \Illuminate\Http\Response
     */
    private function syncTags(Post $post, array $tags)
    {
        $tagList = [];
        foreach ($tags as $tag) {
            if(\App\Tag::where('name', '=', $tag)->exists()) {
                $tag = \App\Tag::where('name', $tag)->first();
                $tagList[] = $tag->id;
            } else {
                $tag = new \App\Tag(['name' => $tag]);
                $tag->save();
                $tagList[] = $tag->id;
            }
        }

        $post->tags()->sync($tagList);
    }

	public function show($slug)
	{
		$post = Post::where('slug',$slug)->first();
		if(!$post)
		{
			return redirect('/')->withErrors('requested page not found');
		}
		$comments = $post->comments;
		return view('posts.show')->withPost($post)->withComments($comments);
	}

	public function edit(Request $request, $slug)
	{
		$post = Post::where('slug', $slug)->first();
		if($post && ($request->user()->id == $post->author_id || $request->user()->is_admin())) {
			$tagList = Tag::pluck('name', 'name');
			return view('posts.edit', compact('tagList', 'post'));
		}
		return redirect('/')->withErrors('you have not sufficient permissions');
	}

	public function update(Request $request)
	{
		//
		$post_id = $request->input('post_id');
		$post = Post::find($post_id);
		if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin()))
		{
			$title = $request->input('title');
			$slug = Str::slug($title);
			$duplicate = Post::where('slug',$slug)->first();
			if($duplicate)
			{
				if($duplicate->id != $post_id)
				{
					return redirect('edit/'.$post->slug)->withErrors('Title already exists.')->withInput();
				}
				else
				{
					$post->slug = $slug;
				}
			}
			$post->title = $title;
			$post->body = $request->input('body');
			if($request->has('save'))
			{
				$post->active = 0;
				$message = 'Post saved successfully';
				$landing = 'edit/'.$post->slug;
			}
			else {
				$post->active = 1;
				$message = 'Post updated successfully';
				$landing = $post->slug;
			}
			$post->save();

			if($request->input('tags')) {
	            $this->syncTags($post, $request->input('tags'));
	        }
			return redirect($landing)->withMessage($message);
		}
		else
		{
			return redirect('/')->withErrors('you have not sufficient permissions');
		}
	}

	public function destroy(Request $request, $id)
	{
		$post = Post::find($id);
		if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin()))
		{
			$post->delete();
			$data['message'] = 'Post deleted Successfully';
		}
		else
		{
			$data['errors'] = 'Invalid Operation. You have not sufficient permissions';
		}
		return redirect('/')->with($data);
	}
}
