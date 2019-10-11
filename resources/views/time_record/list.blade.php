@extends('app')
@section('title')
{{ $title }}
@endsection
@section('content')
@if ( !isset($records) )
There is no record today.
@else
<div class="">
  <h2>
   WORKING ON [{{ $current->category->name }}] {{ $current->duriation() }}<br />
  </h2>
  @foreach( $records as $record )
    <h3> <font>{{ $record->category->name }}</font>
      {{ $record->created_at->toTimeString() }} ~
      {{ $record->checkouted_time->toTimeString() }}
      {{ $record->duriation() }}
    </h3>
  @endforeach
</div>
@endif
@endsection