@extends('app')
@section('title')
Edit Post
@endsection
@section('content')
 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" src="{{ asset('js/tinymce.min.js') }}"></script>

{!! Form::model($post, ['method' => 'POST', 'url' => '/update']) !!}
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="post_id" value="{{ $post->id }}{{ old('post_id') }}">
  <div class="form-group">
    {!! Form::input('text', 'title', null, ['class' => 'form-control', 'required', 'placeholder' => 'Enter title here']) !!}
  </div>
  <div class="form-group">
    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
  </div>
  <div class="form-group">
    {!! Form::select('taglist[]', $tagList, null , ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
  </div>

  @if($post->active == '1')
  <input type="submit" name='publish' class="btn btn-success" value = "Update"/>
  @else
  <input type="submit" name='publish' class="btn btn-success" value = "Publish"/>
  @endif
  <input type="submit" name='save' class="btn btn-default" value = "Save As Draft" />
  <a href="{{  url('delete/'.$post->id.'?_token='.csrf_token()) }}" class="btn btn-danger">Delete</a>
{!! Form::close() !!}

<script type="text/javascript">
  $('#tag_list').select2({
    placeholder: 'Choose a tag',
    tags: true,
    width: '100%',
  });

  tinymce.init({
    selector : "textarea",
    plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen textcolor ", "insertdatetime media table contextmenu paste"],
    toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor",
    height : "400"
  });
</script>
@endsection