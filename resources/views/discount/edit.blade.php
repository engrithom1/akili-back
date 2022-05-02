@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Update Discount</h1>
    <a href="{{ route('discount.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-arrow-left text-white-50"></i> Back</a>
</div>

<!--message-->
@if (session()->has('message'))
<div class="alert alert-danger">
    {{session('message')}}
</div>
@endif
@if (session()->has('errorz'))
<div class="alert alert-danger">
    {{session('errorz')}}
</div>
@endif
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Discount</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <form method="POST" action="{{ route('discount.update',$discount->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Product name</label>
                        <input type="text" name="name" value="{{ $discount->name }}" class="form-control" id="name">
                    </div>

                    <div class="form-group">
                        <label for="percent">percents</label>
                        <input type="number" name="percent" min="0" max="99" value="{{ $discount->percent }}"
                            class="form-control" id="percent" placeholder="Enter percent ">
                    </div>

                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea name="desc" value="" class="form-control" id="desc"
                            rows="3">{{ $discount->desc }}</textarea>
                    </div>



                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-sm-6 col-md-4">

            </div>
        </div>
    </div>
</div>

@endsection