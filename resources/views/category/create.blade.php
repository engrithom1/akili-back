@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Category</h1>
    <a href="{{ route('category.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-arrow-left text-white-50"></i> Back</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">New Categories</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <form method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Category name</label>
                        <input type="text" name="name" value="" class="form-control" id="name"
                            placeholder="Enter Category ">
                    </div>

                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea required name="desc" value="" class="form-control" id="desc" rows="3"
                            placeholder="Enter description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="thumb">Thumbnail</label>
                        <input required type="file" name="thumb" onchange="loadFile(event)" class="form-control"
                            id="thumb" placeholder="upload thumb">
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
            <div class="col-sm-6 col-md-4">
                <label for="name">Category thumbnail</label>
                <img src="" id="output" class="img img-fluid" alt="">
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