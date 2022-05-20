@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Product</h1>
    <a href="{{ route('product.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-arrow-left text-white-50"></i> Back</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">New Product</h6>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="form-group">
                        <label for="name">Product name</label>
                        <input required type="text" name="name" value="" class="form-control" id="name"
                            placeholder="Enter product ">
                    </div>
                    <input type="hidden" required name="tags" value="" id="tags">
                    <div class="form-group">
                        <label for="price">Price (TZS)</label>
                        <input required type="number" name="price" value="" min="50" class="form-control" id="price"
                            placeholder="Enter Price per item ">
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category">Discount</label>
                        <select class="form-control" id="discount" name="discount">
                            @foreach ($discounts as $discount)
                            <option value="{{ $discount->id }}">{{ $discount->name.' ( '.$discount->percent.' % )' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea required name="desc" value="" class="form-control" id="desc" rows="3"
                            placeholder="Enter description"></textarea>
                    </div>

                </div>
                <div class="col-sm-12 col-md-4">
                    <h6>Product Tags*</h6>

                    @foreach ($tags as $tag)
                    <div class="form-group">
                        <input type="checkbox" id="{{ 'tag'.$tag->id }}" value={{ $tag->id }}
                        class="tags
                        mr-2">
                        <label for="{{ 'tag'.$tag->id }}">{{ $tag->name }}</label>
                    </div>
                    @endforeach

                    <img src="" id="output" class="img img-fluid" alt="">
                    <div class="form-group">
                        <label for="thumb">Thumbnail</label>
                        <input required type="file" name="thumb" onchange="loadFile(event)" class="form-control"
                            id="thumb" placeholder="upload thumb">
                    </div>
                </div>

            </div>
            <button type="submit" onclick="checked()" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>



@endsection


<script>
    var checked = function(){
        var res = "";
        var tags = document.getElementsByClassName('tags');
        for (var i=0; i<tags.length; i++) {
            if(tags[i].checked) {
               res += tags[i].value+',';
            } 
        }
        
        //console.log(res);
        document.getElementById('tags').value = res;
    }

    var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };

</script>