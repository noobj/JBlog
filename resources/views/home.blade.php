@extends('app')
@section('title')
{{ $title }}
@endsection
@section('content')
@if ( !isset($posts) )
There is no post till now. Login and write a new post now!!!
@else
<div class="">
  @foreach( $posts as $post )
  <div style="margin-bottom: 100px" class="list-group">
    <div class="">
    @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
        @if($post->active == '1')
        <a style="float: right" href="{{ url('edit/'.$post->slug)}}"><span class="glyphicon glyphicon-pencil"></span></a>
        @else
        <a style="float: right" href="{{ url('edit/'.$post->slug)}}"><span class="glyphicon glyphicon-pencil"></span></a>
        @endif
        @endif
      <h6>
      <b>
      {{ $post->created_at->format('n . d . y') }}
      </b>
      </h6>
      <h4><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>

      </h4>

    </div>
    <div class="">
      <article>
        {!! str_limit($post->body, $limit = 500, $end = '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}
      </article>
    </div>

    <div class="">
    <small>
        @if($post->tags->count())
          Tag:
          @foreach($post->tags->pluck('name') as $tag)
              <a href="{{ url('showtag/'.$tag)}}">{{ $tag }}</a>
          @endforeach
        @endif
        </small>
    </div>

  </div>
  @endforeach
  {!! $posts->render() !!}
</div>
@endif
@endsection