@extends('app')
@section('title')
<span class="glyphicon glyphicon-tag"></span>{{ $tag->name }}
@endsection
@section('content')
<div class="panel panel-default">
<div class="panel-body">
@foreach($posts as $post)
<p>
      <strong><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a></strong>
      <span class="well-sm">On {{ $post->created_at->format('M d,Y \a\t h:i a') }}</span>
</p>
@endforeach
</div>
</div>
@endsection