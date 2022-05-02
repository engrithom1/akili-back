@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Update Tag</h1>
    <a href="{{ route('tags.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-arrow-left text-white-50"></i> Back</a>
</div>

<!--message-->
@if (session()->has('message'))
<div class="alert alert-danger">
    {{session('message')}}
</div>
@endif
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Tag</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <form method="POST" action="{{ route('tags.update',$tag->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Tag name</label>
                        <input type="text" name="name" value="{{ $tag->name }}" class="form-control" id="name">
                    </div>

                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea name="desc" value="" class="form-control" id="desc"
                            rows="3">{{ $tag->desc }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="thumb">Thumbnail</label>
                        <input type="file" name="thumb" class="form-control" onchange="loadFile(event)" id="thumb"
                            placeholder="upload thumb">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-sm-6 col-md-4">
                <label for="name">Tags thumbnail</label>
                <img src="{{ asset('images/'.$tag->thumb) }}" id="output" class="img img-fluid" alt="image to upload">
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };

</script>