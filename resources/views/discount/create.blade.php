@extends('layouts.admin')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Discount</h1>
    <a href="{{ route('discount.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-arrow-left text-white-50"></i> Back</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">New Discount</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <form method="POST" action="{{ route('discount.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">discount name</label>
                        <input type="text" name="name" value="" class="form-control" id="name"
                            placeholder="Enter discount ">
                    </div>

                    <div class="form-group">
                        <label for="percent">percents</label>
                        <input type="number" name="percent" min="0" max="99" value="" class="form-control" id="percent"
                            placeholder="Enter percent ">
                    </div>

                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea required name="desc" value="" class="form-control" id="desc" rows="3"
                            placeholder="Enter description"></textarea>
                    </div>



                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
            <div class="col-sm-6 col-md-4">

            </div>
        </div>
    </div>
</div>



@endsection