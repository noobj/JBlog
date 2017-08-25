@extends('app')
@section('title')
Add New Post
@endsection
@section('content')

 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" src="{{ asset('/js/tinymce.min.js') }}"></script>

<form action="/new-post" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
		<input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text" name = "title"class="form-control" />
	</div>
	<div class="form-group">
		<textarea name='body' >{{ old('body') }}</textarea>
	</div>
	<div class="form-group">
	{!! Form::select('tags[]', $tagList, 'null', ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
	</div>

	<input type="submit" name='publish' class="btn btn-success" value = "Publish"/>
	<input type="submit" name='save' class="btn btn-default" value = "Save Draft" />
</form>

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